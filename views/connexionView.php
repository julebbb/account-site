<?php
require "includes/header.php";
?>
<main class="container">
    
    <header class="flex">
		<p class="margin-right">Bienvenue sur l'application Comptes Bancaires</p>    
    </header>

    <section class="connexion">

        <h1>Se connecter :</h1>

        <?php if (!empty($errorConnect)) {?>
        <p class="error-message"><?php echo $errorConnect;?></p>
        <?php }?>

        <form action="connexion.php" method="post" class="flex">
            <label for="email">Email :</label>
            <input type="email" name="email" required>
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" required>

            <input type="submit" value="Se connecter">
        </form>

        <a href="registration.php">Pas encore inscrit ? Cliquez ici !</a>
    
    </section>
</main>

<?php
require 'includes/footer.php';
?>