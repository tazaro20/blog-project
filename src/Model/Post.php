<?php
namespace App\Model;

use App\Helpers\Text;

class Post
{
    private $id;

    /**
     * @var string|null Le nom/titre du post
     */
    private $name;

    /**
     * @var string|null Le contenu du post
     */
    private $content;

    /**
     * @var string|null La date de création du post (format date-time)
     */
    private $created_at;

    /**
     * @var string|null Le slug (URL simplifiée) du post
     */
    private $slug;

    /**
     * @var array Les catégories associées au post
     */
    private $categories = [];

    /**
     * Obtient le nom/titre du post.
     *
     * @return string|null Le nom du post ou null si non défini
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Obtient un extrait du contenu du post.
     *
     * @return string|null Un extrait du contenu du post ou null si le contenu est vide
     */
    public function getExcerpt(): ?string
    {
        if ($this->content === null) {
            return null;
        }
        return nl2br(htmlentities(Text::excerpt($this->content)));
    }

    /**
     * Obtient la date de création du post sous forme d'objet DateTime.
     *
     * @return \DateTime La date de création du post
     */
    public function getCreatedAt(): ?\DateTime
    {
        if ($this->created_at === null) {
            return null;
        }
        return \DateTime::createFromFormat('Y-m-d H:i:s', $this->created_at);
    }

    /**
     * Obtient le contenu formaté du post avec les sauts de ligne convertis en balises <br> et les entités HTML échappées.
     *
     * @return string|null Le contenu formaté du post ou null si le contenu est vide
     */
    public function getFormattedContent(): ?string
    {
        return nl2br(htmlspecialchars($this->content));
    }

    /**
     * Obtient l'identifiant unique du post.
     *
     * @return int|null L'identifiant du post ou null si non défini
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * @param mixed $id
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Obtient le slug (URL simplifiée) du post.
     *
     * @return string|null Le slug du post ou null si non défini
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Définit le nom/titre du post.
     *
     * @param string $name Le nom du post
     * @return self L'instance courante de Post pour le chaînage
     */
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Définit le contenu du post.
     *
     * @param string $content Le contenu du post
     * @return self L'instance courante de Post pour le chaînage
     */
    public function setContent($content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Obtient le contenu brut du post.
     *
     * @return string|null Le contenu du post ou null si non défini
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Obtient les catégories associées au post.
     *
     * @return array Les catégories du post
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * Ajoute une catégorie au post.
     *
     * @param Category $category La catégorie à ajouter
     */
    public function addCategory(Category $category): void
    {
        $this->categories[] = $category;
        $category->setPost($this);
    }

    /**
     * Définit la date de création du post.
     *
     * @param string $created_at La date de création du post (format date-time)
     * @return self L'instance courante de Post pour le chaînage
     */
    public function setCreatedAt(string $created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * Définit le slug (URL simplifiée) du post.
     *
     * @param string $slug Le slug du post
     * @return self L'instance courante de Post pour le chaînage
     */
    public function setSlug($slug): self
    {
        $this->slug = $slug;
        return $this;
    }
}
