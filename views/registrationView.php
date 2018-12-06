<?php
include 'includes/header.php';

?>

<div class="container">

	<header class="flex">
		<p class="margin-right">Bienvenue sur l'application Comptes Bancaires</p>
	</header>


    <div class="connexion">

        <h1>Inscription :</h1>

        <form action="controllers/registration.php" method="post" class="flex">

        <?php//If error exist?>
        <!--<p class="error-message"><?php //Ajout des erreurs a l'inscription   ?></p>-->
        <?php?>

        <label for="name">Entrez votre prénom :</label>
        <input type="text" name="name" required>

        <label for="email">Entrez votre email :</label>
        <input type="email" name="email" required>

        <label for="password">Entrez votre mot de passe :</label>
        <input type="password" name="password" required>

        <input type="submit" value="Envoyer">

        </form>

    </div>


</div>

<?php
include 'includes/footer.php';
?>