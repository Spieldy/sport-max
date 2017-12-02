<?php

 session_start();

  require_once 'config.php';
  require_once 'global/utils.php';
  require_once 'models/base.php';
  require_once 'models/user.php';



  $db = new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD);
  Model_Base::set_db($db);

 

  date_default_timezone_set('Europe/Paris');

  define('BASEURL', 'http://localhost/sport-max/');

  ob_start();

  if(isset($_SERVER['PATH_INFO'])) {
    $args = explode('/', $_SERVER['PATH_INFO']);
    $found = false;

    if(count($args) >= 3) {
      $controller = $args[1];
      $method = $args[2];
      $params = array();
      for ($i=3; $i < count($args); $i++) {
        $params[] = $args[$i];
      }

      $controller_file = dirname(__FILE__).'/controllers/'.$controller.'.php';
      if (is_file($controller_file)) {
        require_once $controller_file;
        $controller_name = 'Controller_'.ucfirst($controller);
        if (class_exists($controller_name)) {
          $c = new $controller_name;
          if (method_exists($c, $method)) {
            $found = true;
            call_user_func_array(array($c, $method), $params);
          }
        }
      }
    }

    if (!$found) {
      http_response_code(404);
      $error_message = "Erreur 404";
      include('views/error.php');
    }
  } elseif(BASEURL) {
    include 'views/home.php';
  }

  $content = ob_get_clean();

?>

<!doctype html>
<html lang="en">
  <head>
    <title>Sport-Max</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  </head>
  <body>
  	<?php 
  		include 'views/navbar.php';
      if (user_connected()) {
        $user = User::get_by_login($_SESSION['user']);
      }
  	?>
    <div class="container">
    	<?php 
    		echo $content;
    	 ?>
    </div>

    <!-- Optional JavaScript -->
    <script> var baseurl = '<?=BASEURL?>'; </script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>
