<?php

declare(strict_types = 1);

/**
 * class AccountManager
 * 
 */
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
    public function getAccounts($user) {
        $arrayOfAccounts = [];

        $query = $this->getDb()->prepare('SELECT * FROM accounts WHERE id_user = :id_user');
        $query->bindValue('id_user', $user->getId(), PDO::PARAM_INT);
        $query->execute();

        $dataAccounts = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($dataAccounts as $dataAccount) {
            
            //Verif if name of $dataAccount is name of account 
            if ($dataAccount['name'] === 'PEL') {

                $arrayOfAccounts[] = new PEL($dataAccount);
            } elseif ($dataAccount['name'] === 'Livret A') {

                $arrayOfAccounts[] = new LivretA($dataAccount);
            } elseif ($dataAccount['name'] === 'Compte courant') {

                $arrayOfAccounts[] = new CompteCourant($dataAccount);
            } elseif ($dataAccount['name'] === 'Compte joint') {

                $arrayOfAccounts[] = new CompteJoint($dataAccount);
            }

        }


        return $arrayOfAccounts;
    }

    /**
     * Get one account by id or name
     *
     * @param int or string $element 
     * @param int id_user
     * @return object
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
            $query->bindValue('id_user', $id_user, PDO::PARAM_INT);

            $query->execute();
        }

        $dataAccount = $query->fetch(PDO::FETCH_ASSOC);

        if (in_array("PEL", $dataAccount, true)) {
            return new PEL($dataAccount);
        } elseif (in_array("Compte courant", $dataAccount, true)) {
            return new CompteCourant($dataAccount);
        } elseif (in_array("Compte joint", $dataAccount, true)) {
            return new CompteJoint($dataAccount);
        }elseif (in_array("Livret A", $dataAccount, true)) {
            return new LivretA($dataAccount);
        }
    }

    /**
     * Add account function
     *
     * @param object $account
     */
    public function add($account) {

        $query = $this->getDb()->prepare('INSERT INTO accounts(name, balance, id_user) VALUES (:name, :balance, :id_user)');
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
    public function checkIfExist(string $name, int $id_user) {

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
    public function update(Account $account) {
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
    public function delete(Account $account) {
        $query = $this->getDb()->prepare('DELETE FROM accounts WHERE id = :id AND id_user = :id_user');
        $query->bindValue('id', $account->getId(), PDO::PARAM_INT);
        $query->bindValue('id_user', $account->getId_user(), PDO::PARAM_INT);

        $query->execute();
    }

    /**
     * Tranfer function between account
     *
     * @param Account $beginAccount
     * @param Account $endAccount
     * @param integer $numTransfer
     * @return void
     */
    public function transfer(Account $beginAccount, Account $endAccount, int $numTransfer) {

        $beginAccount->debit($numTransfer);
        $endAccount->credit($numTransfer);

        $this->update($beginAccount);
        $this->update($endAccount);

    }
}
