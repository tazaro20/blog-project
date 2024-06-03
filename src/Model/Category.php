<?php
namespace App\Model;

class Category
{
    // Propriétés privées de la classe Category
    private $id;
    private $slug;
    private $name;
    private $post;
    private $post_id;

    /**
     * Méthode pour récupérer l'ID de la catégorie
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * Méthode pour récupérer le slug de la catégorie
     *
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }

    /**
     * Méthode pour récupérer le nom de la catégorie
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * Méthode pour définir l'objet Post associé à cette catégorie
     *
     * @param Post $post
     * @return void
     */
    public function setPost(Post $post): void
    {
        $this->post = $post;
    }

    /**
     * Méthode pour récupérer l'ID du post associé à cette catégorie
     *
     * @return int|null
     */
    public function getPostId(): ?int
    {
        return $this->post_id;
    }

    public function setCreatedAt(string $date)
    {
    }

}
