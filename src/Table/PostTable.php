<?php

namespace App\Table;

use App\PaginatedQuery;
use App\Model\Post;

final class PostTable extends Table
{
    /**
     * @var string Le nom de la table dans la base de données
     */
    protected $table = "post";

    /**
     * @var string Le nom de la classe associée
     */
    protected $class = Post::class;

    /**
     * Met à jour un post dans la base de données.
     *
     * @param Post $post Le post à mettre à jour
     * @throws \Exception Si la mise à jour échoue
     */
    public function updatePost(Post $post): void
    {
        $this->update([
            "name" => $post->getName(),
            "slug" => $post->getSlug(),
            "content" => $post->getContent(),
            "created_at" => $post->getCreatedAt()->format('Y-m-d H:i:s')
        ], $post->getId());

    }

    public function createPost(Post $post): void
    {
        $id = $this->create([
            "name" => $post->getName(),
            "slug" => $post->getSlug(),
            "content" => $post->getContent(),
            "created_at" => $post->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
        $post->setId($id);
    }

    /**
     * Récupère une liste paginée de posts.
     *
     * @return array Un tableau contenant les posts et l'objet PaginatedQuery
     */
    public function findPaginated(): array
    {
        $pagination = new PaginatedQuery(
            "SELECT * FROM {$this->table} ORDER BY created_at DESC",
            "SELECT COUNT(id) FROM {$this->table}",
            $this->pdo
        );
        $posts = $pagination->getItems(Post::class);
        (new CategoryTable($this->pdo))->hydratePosts($posts);
        return [$posts, $pagination];
    }

    /**
     * Récupère une liste paginée de posts pour une catégorie spécifique.
     *
     * @param int $categoryId L'identifiant de la catégorie
     * @return array Un tableau contenant les posts et l'objet PaginatedQuery
     */
    public function findPaginatedForCategory(int $categoryId): array
    {
        $paginatedQuery = new PaginatedQuery(
            "
SELECT p.*
FROM post p
JOIN post_category pc ON pc.post_id = p.id
WHERE pc.category_id = {$categoryId}
ORDER BY created_at DESC",
            "SELECT COUNT(category_id) FROM post_category WHERE category_id = {$categoryId}",
            $this->pdo
        );
        $posts = $paginatedQuery->getItems(Post::class);
        (new CategoryTable($this->pdo))->hydratePosts($posts);
        return [$posts, $paginatedQuery];
    }
}
