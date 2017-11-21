<nav class="navbar navbar-expand-lg justify-content-between navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Sport-Max</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="<?=BASEURL?>index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
    	<a class="nav-link dropdown-toggle" href="<?=BASEURL?>index.php/hockey/home" id="nhlDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        NHL
     	</a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="<?=BASEURL?>index.php/hockey/calendar">Calendar</a>
            <a class="dropdown-item" href="<?=BASEURL?>index.php/hockey/results">Results</a>
            <a class="dropdown-item" href="<?=BASEURL?>index.php/hockey/classment">Classment</a>
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
            <a class="dropdown-item" href="<?=BASEURL?>index.php/soccer/classment">Classment</a>
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
            <a class="dropdown-item" href="<?=BASEURL?>index.php/football/classment">Classment</a>
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
            <a class="dropdown-item" href="<?=BASEURL?>index.php/basketball/classment">Classment</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?=BASEURL?>index.php/basketball/teams">Teams</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>