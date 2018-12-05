<?php

// On enregistre notre autoload.
function chargerClasse($classname)
{
    if(file_exists('../models/'. $classname.'.php'))
    {
        require '../models/'. $classname.'.php';
    }
    else 
    {
        require '../entities/' . $classname . '.php';
    }
}
spl_autoload_register('chargerClasse');

$db = Database::DB();

//New manager for account
$accountManager = new AccountManager($db);

//Array for display type of account
$arrayAccount = ['Compte courant', 'PEL', 'Livret A', 'Compte joint'];

//Variable for display errors
$errorCreate = "";

//**** ADD NEW ACCOUNT ****
if (isset($_POST['name']) AND !empty($_POST['name'])) {
    $name = htmlspecialchars($_POST['name']);
    if (in_array($name, $arrayAccount) AND is_string($name)) {
        if ($accountManager->checkIfExist($name)) {
            $errorCreate = "Vous ne pouvez avoir qu'un seul compte " . $name . " !";
        } else {

            $newAccount = new Account(array(
                'name' => $name
            ));
            
            //Add account in db
            $accountManager->add($newAccount);
            header('index.php');
        }
        
    } else {
        $errorCreate = "Erreur dans le select !";
    }
}

//**** DISPLAY ACCOUNT EXIST ****/
$displayAccount = $accountManager->getAccounts();


//**** CREDIT ACCOUNT ****/
if (isset($_POST['id']) AND isset($_POST['balance']) AND isset($_POST['payment'])
    AND !empty($_POST['id'] AND !empty($_POST['balance']) AND !empty($_POST['payment']))) {

    $id = (int) $_POST['id'];
    $balance = (int) $_POST['balance'];

    $account = $accountManager->getAccount($id);

    $account->credit($balance);

    $accountManager->update($account);

    header('Location: index.php');
}

//**** DEBIT ACCOUNT ****/
if (isset($_POST['id']) AND isset($_POST['balance']) AND isset($_POST['debit'])
    AND !empty($_POST['id'] AND !empty($_POST['balance']) AND !empty($_POST['debit']))) {

    $id = (int) $_POST['id'];
    $balance = (int) $_POST['balance'];

    $account = $accountManager->getAccount($id);

    $account->debit($balance);

    $accountManager->update($account);
    
    header('Location: index.php');
}
//**** TRANSFERT BETWEEN ACCOUNT ****/


include "../views/indexView.php";
