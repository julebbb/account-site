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
     * Get one user by id or name
     *
     * @param int or string $element 
     * @return void
     */
    public function getUser($element) {

        if (is_string($element)) {

            $query = $this->getDB()->prepare('SELECT * FROM users WHERE email = :email ');
            $query->bindValue('email', $element, PDO::PARAM_STR);

            $query->execute();

        } elseif (is_int($element)) {

            $query = $this->getDB()->prepare('SELECT * FROM users WHERE id = :id ');
            $query->bindValue('id', $element, PDO::PARAM_INT);

            $query->execute();
        }

        $dataUser = $query->fetch(PDO::FETCH_ASSOC);

        return new User($dataUser);
    }

    /**
     * Add user function
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


}
