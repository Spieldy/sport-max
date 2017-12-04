<nav class="navbar navbar-expand-lg justify-content-between navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Sport-Max</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?=BASEURL?>index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
        	<a class="nav-link dropdown-toggle" href="<?=BASEURL?>index.php/hockey/home" id="nhlDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            NHL
         	</a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="<?=BASEURL?>index.php/hockey/calendar">Calendar</a>
            <a class="dropdown-item" href="<?=BASEURL?>index.php/hockey/results">Results</a>
            <a class="dropdown-item" href="<?=BASEURL?>index.php/hockey/standing">Standing</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?=BASEURL?>index.php/hockey/teams">Teams</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="mlsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            MLS
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="<?=BASEURL?>index.php/soccer/calendar">Calendar</a>
            <a class="dropdown-item" href="<?=BASEURL?>index.php/soccer/results">Results</a>
            <a class="dropdown-item" href="<?=BASEURL?>index.php/soccer/standing">Standing</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?=BASEURL?>index.php/soccer/teams">Teams</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link dropdown-toggle" href="#" id="nflDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            NFL
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="<?=BASEURL?>index.php/football/calendar">Calendar</a>
            <a class="dropdown-item" href="<?=BASEURL?>index.php/football/results">Results</a>
            <a class="dropdown-item" href="<?=BASEURL?>index.php/football/standing">Standing</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?=BASEURL?>index.php/football/teams">Teams</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link dropdown-toggle" href="#" id="nbaDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            NBA
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="<?=BASEURL?>index.php/basketball/calendar">Calendar</a>
            <a class="dropdown-item" href="<?=BASEURL?>index.php/basketball/results">Results</a>
            <a class="dropdown-item" href="<?=BASEURL?>index.php/basketball/standing">Standing</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?=BASEURL?>index.php/basketball/teams">Teams</a>
          </div>
        </li>
      </ul>
    </div>
    <?php if (user_connected()) { ?>
      <div class="text-white"><?php echo $_SESSION['user']; ?></div>
      <a href="<?=BASEURL?>index.php/user/show_state">settings</a>
      <a href="<?=BASEURL?>index.php/user/signout">signout</a>
    <?php } ?>
  </nav>