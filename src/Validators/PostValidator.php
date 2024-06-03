<?php
namespace App\Validators;

use App\Table\PostTable;
class PostValidator extends AbstractValidator
{
    protected $data;
    protected $validator;

    public function __construct(array $data,PostTable $table,?int $postID = null)
    {
        parent::__construct($data);
        $this->validator->rule('required',['name','slug']);
        $this->validator->rule('lengthBetween',['name','slug'],3,200);
        $this->validator->rule('slug','slug');
        $this->validator->rule(function ($field,$value) use ($table,$postID){
            return !$table->exists($field,$value,$postID);
        },['slug','name'], 'ce slug est deja utilisé');
    }
}