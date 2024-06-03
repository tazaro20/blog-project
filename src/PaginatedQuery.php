<?php
namespace App;

use \PDO;

class PaginatedQuery
{
    private $query;
    private $queryCount;
    private $pdo;
    private $perPage;
    private $count;
    private $items ;

    /**
     * Constructeur de la classe PaginatedQuery
     *
     * @param string $query Requête SQL pour récupérer les éléments paginés
     * @param string $queryCount Requête SQL pour compter le nombre total d'éléments
     * @param \PDO|null $pdo Instance PDO pour la connexion à la base de données
     * @param int $perPage Nombre d'éléments par page
     */
    public function __construct(
        string $query,
        string $queryCount,
        ?\PDO $pdo = null,
        int $perPage = 12
    ) {
        $this->query = $query;
        $this->queryCount = $queryCount;
        $this->pdo = $pdo ?: Connection::getPDO();
        $this->perPage = $perPage;
    }

    /**
     * Calcule le nombre total de pages
     *
     * @return int Nombre total de pages
     */
    private function getPages(): int
    {
        if ($this->count === null) {
            $this->count = (int)$this->pdo
                ->query($this->queryCount)
                ->fetch(PDO::FETCH_NUM)[0];
        }
        return ceil($this->count / $this->perPage);
    }

    /**
     * Récupère les éléments de la page courante
     *
     * @return array Tableau d'objets de la classe spécifiée par $classMapping
     */
    public function getItems(string $classMapping): array
    {
       if ($this->items === null){
           $currentPage = $this->getCurrentPage();
           $pages = $this->getPages();
           if ($currentPage > $pages) {
               throw new \Exception("Cette page n'existe pas");
           }
           $offset = $this->perPage * ($currentPage - 1);
           return $this->items = $this->pdo->query(
               $this->query . " LIMIT {$this->perPage} OFFSET $offset"
           )->fetchAll(PDO::FETCH_CLASS, $classMapping);
       }
       return $this->items;
    }

    /**
     * Génère le lien pour la page précédente
     *
     * @param string $link Lien de base pour la pagination
     * @return string|null HTML du lien ou null si pas de page précédente
     */
    public function previousLink(string $link): ?string
    {
        $currentPage = $this->getCurrentPage();
        if ($currentPage <= 1) return null;
        if ($currentPage > 2) $link .= "?page=" . ($currentPage - 1);
        return <<<HTML
<a href="{$link}" class="btn btn-primary"> &laquo; Page précédente</a>
HTML;
    }

    /**
     * Génère le lien pour la page suivante
     *
     * @param string $link Lien de base pour la pagination
     * @return string|null HTML du lien ou null si pas de page suivante
     */
    public function nextLink(string $link): ?string
    {
        $currentPage = $this->getCurrentPage();
        $pages = $this->getPages();
        if ($currentPage >= $pages) return null;
        $link .= "?page=" . ($currentPage + 1);
        return <<<HTML
<a href="{$link}" class="btn btn-primary ml-auto"> Page suivante &raquo;</a>
HTML;
    }

    /**
     * Récupère la page courante à partir de l'URL
     *
     * @return int Numéro de la page courante
     */
    private function getCurrentPage(): int
    {
        return URL::getPositiveInt('page', "1");
    }
}
