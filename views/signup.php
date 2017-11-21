<?php
/**
* \file      views/signup.php
* \author    Jérémy Spieldenner
* \version   2.0
* \date      20 Octobre 2014
*  \brief    Affiche le formulaire d'inscription
*
* \details   La vue permet à l'utilisateur de s'inscrire en lui demandant de renseigner un login et un mot de passe qui est revérifié. Il y un lien vers la page de connexion si l'utilisateur est deja inscrit.
*/
?>

<div class="top-bar">
	<p> S'inscrire </p>
</div>



<div class="signup">

	<div class="signup-card">
		<form method="post" action="<?=BASEURL?>/index.php/user/signup">

		<div class="formline-login">
			<input type="text" id="login" placeholder="Login" name="login">
		</div>
		<div class="formline-password">
			<input type="password" id="password" placeholder="Mot de passe" name="password">
		</div>
		<div class="formline-confirm">
			<input type="password" id="password_check" placeholder="Confirmation mot de passe" name="password_check">
		</div>
		<div class="formline-btn">
			<input type="submit" value="S'inscrire">
		</div>
		</form>
		<a href="<?=BASEURL?>/index.php/user/signin">Déjà membre?</a>
	</div>
</div>
