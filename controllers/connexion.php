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


$db = Database::DB();

$userManager = new UserManager($db);

if (isset($_POST['email']) AND isset($_POST['password']) AND !empty($_POST['email']) AND !empty($_POST['password'])) {
    $email = $_POST["email"];
    $password = $_POST['password'];
    if ($userManager->checkIfExist($email)) {

        $user = $userManager->getUser($email);
        $userPassword = $user->getPassword();

        if (password_verify($password, $userPassword)) {

            session_start();

            $_SESSION['user'] = $user;
            header('Location: index.php');

        } else {
            $errorConnect = "L'email ou le mot de passe est incorrect";
           
        }
        
    } else {
        $errorConnect = "L'email ou le mot de passe est incorrect";
    }


}


require "../views/connexionView.php";