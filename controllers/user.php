<?php


require_once 'models/user.php';
require_once 'global/utils.php';


class Controller_User
{

	public function signin() {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
				if (isset($_SESSION['user'])) {
					//$_SESSION['user'] = $u->login();
					//show_message('message_success',"You're already connected as ".$_SESSION['user']);
					include 'views/home.php';
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
							include 'views/home.php';
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
							show_message('message_success',"Inscription de ".$_POST['login'].' !');
							include 'views/home.php';
						}	
						else {
							show_message('message_error',"Pas le même mot de passe");
							include 'views/signup.php';
						}
					}
					else {
						show_message('message_error',"Already existing account");
						include 'views/home.php';
					}
				}
				else {
						show_message('message_error',"Données incomplètes");
						include 'views/signup.php';
				}
				break;
		}
	}

	public function show_state() {
		if (user_connected()) {
			include 'views/state_form.php';
		}
	}

	public function change_state() {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'POST':
				if (user_connected()) {
					$string_state = "";
					$string_state = $_POST["sport_state"].$_POST["display_state"];
					$user = User::get_by_login($_SESSION['user']);
					$user->set_state($string_state);
					$user->save();
					include 'views/home.php';
				} else {
					include 'views/signin.php';
				}
				break;

		}
	}

	
	public function signout() {
		unset($_SESSION['user']);
		include('views/home.php');
	}

}
