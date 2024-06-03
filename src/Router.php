<?php

namespace App;

use App\Security\ForbiddenException;
use App\Table\Exception\NotFoundException;
use Exception;
class Router
{
    /**
     * @var string
     */
    private $viewsPath ;
    /**
     * @var \AltoRouter
     */
    private $router ;

    public function __construct($viewsPath)
    {
        $this->viewsPath = $viewsPath;
        $this->router = new \AltoRouter();
    }
    public function get(string $url,string $view,?string $name= null):self
    {
        $this->router->map('GET',$url,$view,$name);
        return $this;
    }
    public function post(string $url,string $view,?string $name= null):self
    {
        $this->router->map('POST',$url,$view,$name);
        return $this;
    }
    public function match(string $url,string $view,?string $name= null):self
    {
        $this->router->map('POST|GET',$url,$view,$name);
        return $this;
    }
    /**
     * @throws Exception
     */
    public function url(string $name, array $params = []): ?string
    {
        return  $this->router->generate($name,$params);
    }
    public function run():self
    {
        $match = $this->router->match();
        $view = $match['target'] ?: 'e404';
        $params = $match['params'];
        $router = $this;
        $isAdmin = str_contains($view, 'admin/');
        $layout = $isAdmin ? 'admin/layouts/default' : 'layouts/default';
        try {
            ob_start();
            require $this->viewsPath . DIRECTORY_SEPARATOR . $view .'.php';
            $content = ob_get_clean();
            require $this->viewsPath . DIRECTORY_SEPARATOR .$layout. '.php';
        }catch (ForbiddenException $e){
            header('Location: '.$this->url('login') . '?forbidden=1');
        }
        return $this;
    }
}