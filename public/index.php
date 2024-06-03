<?php

require '../vendor/autoload.php';

define('DEBUG_TIME', microtime(true));

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

if (isset($_GET['page']) && $_GET['page'] === '1'){
  $uri = explode('?',$_SERVER['REQUEST_URI'])[0];
  $get = $_GET;
  unset($get['page']);
  $query = http_build_query($get);
  if (!empty($query)){
      $uri = $uri .'?'. $query;
  }
  http_response_code(301);
  header("Location: $uri");
  exit();
}

$router= new App\Router(dirname(__DIR__). DIRECTORY_SEPARATOR .'/views');

$router
    ->get('/','/index','home')
    ->get('/blog/category/[*:slug]-[i:id]','category/show','category')
    ->get('/blog/[*:slug]-[i:id]','post/show','post')
    ->match('/login','auth/login','login')
    ->post('/logouts','auth/logouts','logouts')

    //Admin
        //Gestion des articles
    ->get('/admin','admin/post/index','admin_posts')
    ->match('/admin/post/[i:id]','admin/post/edith','admin_post')
    ->post('/admin/post/[i:id]/delete','admin/post/delete','admin_posts_delete')
    ->match('/admin/post/new','admin/post/new','admin_posts_new')
        //Gestions des categories
    ->get('/admin/categories','admin/category/index','admin_categories')
    ->match('/admin/category/[i:id]','admin/category/edith','admin_category')
     ->post('/admin/category/delete/[i:id]', 'admin/category/delete', 'admin_Category_delete')
    ->match('/admin/category/new','admin/category/new','admin_category_new')
    ->run();




