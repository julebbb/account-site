<?php

declare(strict_types = 1);

class UserManager
{
    private $_db;


    /**
     * constructor
     *
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->setDb($db);
    }

    /**
     * Get the value of _db
     */ 
    public function getDb()
    {
        return $this->_db;
    }

    /**
     * Set the value of _db
     *
     * @param PDO $db
     * @return  self
     */ 
    public function setDb(PDO $db)
    {
        $this->_db = $db;

        return $this;
    }

    /**
     * Get one account by id or name
     *
     * @param int or string $element 
     * @param int id_user
     * @return void
     */
    public function getAccount($element, int $id_user) {

        if (is_string($element)) {

            $query = $this->getDB()->prepare('SELECT * FROM accounts WHERE name = :name AND id_user = :id_user');
            $query->bindValue('name', $element, PDO::PARAM_STR);
            $query->bindValue('id_user', $id_user, PDO::PARAM_INT);

            $query->execute();

        } elseif (is_int($element)) {

            $query = $this->getDB()->prepare('SELECT * FROM accounts WHERE id = :id AND id_user = :id_user');
            $query->bindValue('id', $element, PDO::PARAM_INT);

            $query->execute();
        }

        $dataUser = $query->fetch(PDO::FETCH_ASSOC);

        return new User($dataUser);
    }

    /**
     * Add account function
     *
     * @param object $account
     */
    public function add(User $user) {
        $query = $this->getDb()->prepare('INSERT INTO users(name, email, password) VALUES (:name, :email, :password)');
        $query->bindValue('name', $user->getName(), PDO::PARAM_STR);
        $query->bindValue('email', $user->getEmail(), PDO::PARAM_STR);
        $query->bindValue('password', $user->getPassword(), PDO::PARAM_STR);
        $query->execute();
    }

    /**
     *Function who check if exist
     *
     * @param string $name
     * @return boolean
     */
    public function checkIfExist(string $email) {

        $query = $this->getDb()->prepare('SELECT * FROM users WHERE email = :email');
        $query->bindValue('email', $email, PDO::PARAM_STR);

        $query->execute();

        // Check if exist if is in db
        if ($query->rowCount() > 0)
        {
            return true;
        }
        
        // If is not in db
        return false;
    }

    /**
     * Delete function
     *
     * @param Account $account
     * @return void
     */
    public function delete($user) {
        $query = $this->getDb()->prepare('DELETE FROM users WHERE id = :id');
        $query->bindValue('id', $account->getId(), PDO::PARAM_INT);

        $query->execute();
    }

}
