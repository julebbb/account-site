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

//New database
$db = Database::DB();

//New manager for user
$userManager = new UserManager($db);

//Error variable
$errorConnect = "";

/**** CONNEXION ****/
if (isset($_POST['email']) AND isset($_POST['password']) AND !empty($_POST['email']) AND !empty($_POST['password'])) 
{
    $email = $_POST["email"];
    $password = $_POST['password'];

    //Verif if email exist
    if ($userManager->checkIfExist($email)) {

        //Create object with $email in paramater
        $user = $userManager->getUser($email);
        $userPassword = $user->getPassword();

        //Verif password
        if (password_verify($password, $userPassword)) {

            session_start();

            //Create object session
            $_SESSION['user'] = $user;
            
            //Redirect
            header('Location: index.php');

        } 
        else 
        {
            $errorConnect = "L'email ou le mot de passe est incorrect";   
        }
        
    } 
    else 
    {
        $errorConnect = "L'email ou le mot de passe est incorrect";
    }
}


require "../views/connexionView.php";