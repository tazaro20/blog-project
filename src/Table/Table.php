<?php
namespace App\Table;

use App\Table\Exception\NotFoundException;

class Table
{
    protected $pdo;
    protected $class = null;
    protected $table = null;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function find(int $id)
    {
        $query = $this->pdo->prepare("SELECT * FROM `" . $this->table . "` WHERE id = :id");
        $query->execute(['id' => $id]);
        $query->setFetchMode(\PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();

        if ($result === false) {
            throw new NotFoundException($this->table, $id);
        }
        return $result;
    }

    /**
     * Vérifie si une valeur existe dans la table.
     *
     * @param string $field Champ à rechercher.
     * @param mixed $value Valeur associée au champ.
     * @param int|null $except Identifiant à exclure (optionnel).
     * @return bool
     */
    public function exists(string $field, $value, ?int $except = null): bool
    {
        $sql = "SELECT COUNT(id) FROM {$this->table} WHERE $field = ?";
        $params = [$value];
        if ($except !== null) {
            $sql .= " AND id != ?";
            $params[] = $except;
        }
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        return (int)$query->fetch(\PDO::FETCH_NUM)[0] > 0;
    }

    public function all(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->pdo->query($sql)->fetchAll(\PDO::FETCH_CLASS, $this->class);
    }

    public function queryFetchAll(string $sql): false|array
    {
        $result = $this->pdo->query($sql);
        if ($result === false) {
            return false;
        }
        return $result->fetchAll(\PDO::FETCH_CLASS, $this->class);
    }

    public function delete(int $id): void
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $ok = $query->execute([$id]);
        if ($ok === false) {
            throw new \Exception("Impossible de supprimer l'enregistrement $id dans la table {$this->table}");
        }
    }

    public function create(array $data): int
    {
        $sqlFields = [];
        foreach ($data as $key => $value) {
            $sqlFields[] = "$key = :$key";
        }
        $query = $this->pdo->prepare("INSERT INTO {$this->table} SET " . implode(', ', $sqlFields));
        $ok = $query->execute($data);
        if ($ok === false) {
            throw new \Exception("Impossible d'ajouter l'élément dans la table {$this->table}");
        }
        return (int)$this->pdo->lastInsertId();
    }

    public function update(array $data, int $id): void
    {
        $sqlFields = [];
        foreach ($data as $key => $value) {
            $sqlFields[] = "$key = :$key";
        }
        $data['id'] = $id; // Ajoute l'id aux données
        $query = $this->pdo->prepare("UPDATE {$this->table} SET " . implode(', ', $sqlFields) . " WHERE id = :id");
        $ok = $query->execute($data);
        if ($ok === false) {
            throw new \Exception("Impossible de modifier l'enregistrement dans la table {$this->table}");
        }
    }
}
