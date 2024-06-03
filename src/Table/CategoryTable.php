<?php

namespace App\Table;

use App\Model\Category;
use App\Model\Post;
use \PDO;

/**
 * @method delete(mixed $id)
 */
class CategoryTable extends Table
{
    protected $table = "category";
    protected $class = Post::class;

    public function hydratePosts(array $posts): void
    {
        $postById = [];

        foreach ($posts as $post) {
            $postById[$post->getId()] = $post;
        }

        $categories = $this->pdo->query('
                                   SELECT c.*, pc.post_id FROM post_category pc 
                                   JOIN category c ON c.id = pc.category_id
                                   WHERE pc.post_id IN (' . implode(', ', array_keys($postById)) . ')
                                  ')->fetchAll(\PDO::FETCH_CLASS, Category::class);

        foreach ($categories as $category) {
            $postById[$category->getPostId()]->addCategory($category);
        }
    }
    public function all(): array
    {
          return $this->queryFetchAll("select * from {$this->table}");
    }
}