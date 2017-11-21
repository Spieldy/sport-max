<?php
/**
* \file      controllers/user.php
* \author    Jérémy Spieldenner
* \version   1.0
* \date      20 Octobre 2014
* \brief     Contrôle la correction
*
* \details   Cette classe permet la création d'un utilisateur de part son inscription, et gère également sa connexion ainsi que sa déconnexion.
*/

require_once 'models/user.php';
require_once 'models/parameter.php';

// require_once 'CAS/phpCAS-master/config.php';
// require_once 'CAS/phpCAS-master/CAS.php';

class Controller_User
{
	/**
	* \brief     Affiche la page de connexion et gère la connexion d'un utilisateur.
	*/
	public function signin() {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
				if (isset($_SESSION['user'])) {
					$_SESSION['user'] = $u->login();
					show_message('message_success',"You're already connected as ".$_SESSION['user']);
					include 'views/signin.php';
				}
				else {
					include 'views/signin.php';
				}
				break;

			case 'POST' :
				if (isset($_POST['login']) && isset($_POST['password'])) {
					$u = User::get_by_login(htmlspecialchars($_POST['login']));
					if (!is_null($u)) {
						if ($u->password() == sha1($_POST['password']))
						{
							$_SESSION['user'] = $u->login();
							show_message('message_success',"Vous êtes connecté");
							include 'views/correction_newcorrection.php';
						}
						else {
							show_message('message_error',"Echec de connexion : login ou mot de passe incorrect");
							include 'views/signin.php';
						}
					}
					else {
						show_message('message_error',"Echec de connexion : login ou mot de passe incorrect");
						include 'views/signin.php';
					}
				}
				else {
						show_message('message_error',"Données incompletes!");
						include 'views/signin.php';
				}
				break;
		}
	}

	/**
	* \brief     Affiche la page d'inscription et gère la création d'un nouvel utilisateur d'après les données réceptionnées.
	*/
	public function signup() {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
				if (isset($_SESSION['user'])) {
					show_message('message_success',"Déjà connecté en tant que ".$_SESSION['user']);
					include 'views/home.php';
				}
				else {
					include 'views/signup.php';
				}
				break;

			case 'POST' :
				if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['password_check'])) {
					$exist = User::exist_login(htmlspecialchars($_POST['login']));
					if (!$exist) {
						if($_POST['password'] == $_POST['password_check']) {
							//Fonction sha1 permet crypté le mot de passe
							User::insert(htmlspecialchars($_POST['login']),sha1($_POST['password']),null);
							$user = User::get_by_login(htmlspecialchars($_POST['login']));
							$idUser = $user->id();
							Parameter::insert($idUser);
							show_message('message_success',"Inscription de ".$_POST['login'].' !');
							include 'views/home.php';
						}
						else {
							show_message('message_error',"Pas le même mot de passe");
							include 'views/signup.php';
						}
					}
					else {
						show_message('message_error',"Entrer d'autres informations");
						include 'views/signup.php';
					}
				}
				else {
						show_message('message_error',"Données incomplètes");
						include 'views/signup.php';
				}
				break;
		}
	}

	/**
	* \brief     Gère la deconnexion d'un utilisateur et le redirige sur la page d'acceuil.
	*/
	public function signout() {
		unset($_SESSION['user']);
		header('Location: '.BASEURL.'/index.php');
	}

}
