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
    public function add($account) {

        $query = $this->getDb()->prepare('INSERT INTO accounts(name, balance, id_user) VALUES (:name, :balance, id_user)');
        $query->bindValue('name', $account->getName(), PDO::PARAM_STR);
        $query->bindValue('balance', $account->getBalance(), PDO::PARAM_INT);
        $query->bindValue('id_user', $account->getId_user(), PDO::PARAM_INT);
        $query->execute();
    }

    /**
     *Function who check if exist
     *
     * @param string $name
     * @return boolean
     */
    public function checkIfExist(string $name) {

        $query = $this->getDb()->prepare('SELECT * FROM accounts WHERE id_user = :id_user AND name = :name');
        $query->bindValue('name', $name, PDO::PARAM_STR);
        $query->bindValue('id_user', $id_user, PDO::PARAM_INT);

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
     * Update db to account
     *
     * @param Account $account
     * @return void
     */
    public function update($account) {
        $query = $this->getDb()->prepare('UPDATE accounts SET balance = :balance WHERE id = :id AND id_user = :id_user');
        $query->bindValue('balance', $account->getBalance(), PDO::PARAM_INT);
        $query->bindValue('id_user', $account->getId_user(), PDO::PARAM_INT);
        $query->bindValue('id', $account->getId(), PDO::PARAM_INT);
        $query->execute();
    }

    /**
     * Delete function
     *
     * @param Account $account
     * @return void
     */
    public function delete($account) {
        $query = $this->getDb()->prepare('DELETE FROM accounts WHERE id = :id AND id_user = :id_user');
        $query->bindValue('id', $account->getId(), PDO::PARAM_INT);
        $query->bindValue('id_user', $account->getId_user(), PDO::PARAM_INT);

        $query->execute();
    }

}
