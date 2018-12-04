<?php

declare(strict_types = 1);

class AccountManager
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

    //afficher toutes les db

    //create account
    /**
     * Add account function
     *
     * @param object $account
     */
    public function add(Account $account) {
        $query = $this->getDb()->prepare('INSERT INTO accounts(name, balance) VALUES (:name, :balance)');
        $query->bindValue('name', $account->getName(), PDO::PARAM_STR);
        $query->bindValue('balance', $account->getBalance(), PDO::PARAM_INT);
        $query->execute();
    }

    //Check if exist
    /**
     *Function who check if exist
     *
     * @param string $name
     * @return boolean
     */
    public function checkIfExist(string $name) {

        $query = $this->getDb()->prepare('SELECT * FROM accounts WHERE name = :name');
        $query->bindValue('name', $name, PDO::PARAM_STR);
        $query->execute();

        // Check if exist if is in db
        if ($query->rowCount() > 0)
        {
            return true;
        }
        
        // If is not in db
        return false;
    }
    //edit account
    //delete account

}
