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

    /**
     * Take all account in db and display
     *
     * @return array
     */
    public function getAccounts() {
        $arrayOfAccounts = [];

        $query = $this->getDb()->query('SELECT * FROM accounts');
        $dataAccounts = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($dataAccounts as $dataAccount) {
            $arrayOfAccounts[] = new Account($dataAccount);
        }

        return $arrayOfAccounts;
    }

    /**
     * Get one account by id or name
     *
     * @param int or string $element
     * @return void
     */
    public function getAccount($element) {

        if (is_string($element)) {

            $query = $this->getDB()->prepare('SELECT * FROM accounts WHERE name = :name');
            $query->bindValue('name', $element, PDO::PARAM_STR);
            $query->execute();

        } elseif (is_int($element)) {

            $query = $this->getDB()->prepare('SELECT * FROM accounts WHERE id = :id');
            $query->bindValue('id', $element, PDO::PARAM_INT);
            $query->execute();
        }

        $dataAccount = $query->fetch(PDO::FETCH_ASSOC);

        return new Account($dataAccount);
    }

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
    /**
     * Update db to account
     *
     * @param Account $account
     * @return void
     */
    public function update(Account $account) {
        $query = $this->getDb()->prepare('UPDATE accounts SET balance = :balance WHERE id = :id');
        $query->bindValue('balance', $account->getBalance(), PDO::PARAM_INT);
        $query->bindValue('id', $account->getId(), PDO::PARAM_INT);
        $query->execute();
    }
    //delete account

    //TRANSFERT ENTRE COMPTE AUSSI
    public function transfer(Account $beginAccount, Account $endAccount, int $numTransfer) {

        $beginAccount->debit($numTransfer);
        $endAccount->credit($numTransfer);

        $this->update($beginAccount);
        $this->update($endAccount);

    }
}
