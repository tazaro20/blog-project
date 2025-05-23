<?php


namespace App\Table;

use App\Model\User;
use App\Table\Exception\NotFoundException;

final class UserTable extends Table
{
    /**
     * @var string Le nom de la table dans la base de données
     */
    protected $table = "user";

    /**
     * @var string Le nom de la classe associée
     */
    protected $class = User::class;
    public function findByUsername(string $username)
    {
        $query = $this->pdo->prepare("SELECT * FROM `" . $this->table . "` WHERE username = :username");
        $query->execute(['username' => $username]);
        $query->setFetchMode(\PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();

        if ($result === false) {
            throw new NotFoundException($this->table, $username);
        }

        return $result;
    }

}

