<?php

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

session_start();

if (!isset($_SESSION['user'])) {

    header('Location: registration.php');
    
}

$db = Database::DB();

$userManager = new UserManager($db);

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
// $displayAccount = $accountManager->getAccounts();


//**** CREDIT ACCOUNT ****/
if (isset($_POST['id']) AND isset($_POST['balance']) AND isset($_POST['payment'])
    AND !empty($_POST['id'] AND !empty($_POST['balance']) AND !empty($_POST['payment']))) {

    $id = (int) $_POST['id'];
    $balance = (int) $_POST['balance'];

    if ($id > 0 AND $balance > 0) 
    {
        $account = $accountManager->getAccount($id);

        $account->credit($balance);

        $accountManager->update($account);

        header('Location: index.php');
    }
    else 
    {
        $errorsAccount = 'Il faut indiquer une somme supérieur à 0 pour pouvoir créditer !';
    }
}

$errorsAccount = "";

//**** DEBIT ACCOUNT ****/
if (isset($_POST['id']) AND isset($_POST['balance']) AND isset($_POST['debit'])
    AND !empty($_POST['id'] AND !empty($_POST['balance']) AND !empty($_POST['debit']))) {

    $id = (int) $_POST['id'];
    $balance = (int) $_POST['balance'];

    if ($id > 0 AND $balance > 0) {
        $account = $accountManager->getAccount($id);

        if ($account->getName() != "PEL") {
            
            $account->debit($balance);

            $accountManager->update($account);
    
            header('Location: index.php');
        } else {
            $errorsAccount = 'Vous ne pouvez pas débiter sur ce compte !';
        }

        
    } else {
        $errorsAccount = 'Il faut indiquer une somme supérieur à 0 pour pouvoir débiter !';
    }

   
}

$errorTransfer = "";

//**** TRANSFERT BETWEEN ACCOUNT ****/
if (isset($_POST['transfer']) AND isset($_POST['idPayment']) AND isset($_POST['idDebit']) AND isset($_POST['balance'])
AND !empty($_POST['transfer']) AND !empty($_POST['idPayment']) AND !empty($_POST['idDebit']) AND !empty($_POST['balance'])) {
    $idPayment = (int) $_POST['idPayment'];
    $idDebit = (int) $_POST['idDebit'];
    $balance = (int) $_POST['balance'];
    if ($balance > 0) {
        if ($idPayment > 0 AND $idDebit > 0) {

            //Account who we give money
            $accountPayment = $accountManager->getAccount($idPayment);
            //Create a object with db

            //Account who we take money
            $accountDebit = $accountManager->getAccount($idDebit);
            //Create a object with db

            if ($accountDebit->getName() != "PEL") {
                
                $accountManager->transfer($accountDebit, $accountPayment, $balance);

                header('Location: index.php');
            } else {
                $errorTransfer = "Vous ne pouvez transférer de l'argent depuis le compte PEL !";
            }
            

        } else {
            $errorTransfer = "Erreur au niveau des comptes sont t'ils bien selectionnées ?";
        }
    } else {
        $errorTransfer = "Il faut indiquer une somme supérieur à 0 pour pouvoir tranférer à un autre compte !";
    }
}

/**** DELETE ACCOUNT ****/
if (isset($_POST['id']) AND isset($_POST['delete']) AND !empty($_POST['id']) AND !empty($_POST['delete'])) {
    $id = (int) $_POST['id'];

    if ($id > 0) {
        $account = $accountManager->getAccount($id);
        $accountManager->delete($account);

        header('Location: index.php');
    }
}

include "../views/indexView.php";
