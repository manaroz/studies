<?php
require('functions.php');
?>
<!doctype html>
<html lang="pl">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="shortcut icon" href="assets/favicon3.png" type="image/x-icon">
  <link rel="stylesheet" href="css/style.css">
  <title>Wypożyczalnia narzędzi</title>
</head>

<body>
  <!--header-->
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark pl-8">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item pr-3">
            <a class="nav-link" href="">HOME</a>
          </li>
          <li class="nav-item pr-3">
            <a class="nav-link" onclick="smoothScroll('#available')">DOSTĘPNE NARZĘDZIA</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" onclick="smoothScroll('#reservation')">ZAREZERWUJ</a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="container h-75 d-flex align-items-center">
      <div class="row">
        <div class="col-12">
          <h1 class="text-white font-weight-bold">WYPOŻYCZALNIA NARZĘDZI</h1>
        </div>
        <div class="col-12">
          <div class="row mt-5 d-flex">
            <button class="col-lg-3 col-md-6 col-sm-12 m-4 font-weight-bold" onclick="smoothScroll('#available')">OFERTA</button>
            <button class="col-lg-3 col-md-6 col-sm-12 m-4 font-weight-bold" onclick="smoothScroll('#reservation')">REZERWUJ</button>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!--header-->

  <!--available-->
  <section id="available">
    <div class="container-fluid p-5">
      <div class="row">
        <div class="col-12">
          <h1 class="text-center p-5">DOSTĘPNE NARZĘDZIA</h1>
        </div>
      </div>
      
      <div class="row">

        <?php
          $rows = get_tools('available');

          foreach($rows as $r) {
            echo '<div class="col-lg-3 col-md-6 col-sm-12 mt-3">';
            echo '<div class="card">';
            echo '<img src="assets/'.$r['photo_url'].'" class="card-img-top" alt="tool">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title text-center">'.$r['name'].'</h5>';
            echo '<p class="text-center font-weight-bold">'.$r['price'].' zł/h</p>';
            echo '<button class="btn btn-primary col-12" onclick="reserve('.$r['id'].')">REZERWUJ</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }
        ?>

      </div>
    </div>
  </section>
  <!--available-->

  <!--unavailable-->
  <section id="unavailable">
    <div class="container-fluid p-5">
      <div class="row">
        <div class="col-12">
          <h1 class="text-center p-5">OBECNIE ZAREZERWOWANE</h1>
        </div>
      </div>

      <div class="row">
     
        <?php
          $rows = get_tools('unavailable');

          foreach($rows as $r) {
            echo '<div class="col-lg-3 col-md-6 col-sm-12 mt-3">';
            echo '<div class="card">';
            echo '<img src="assets/'.$r['photo_url'].'" class="card-img-top" alt="tool">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title text-center">'.$r['name'].'</h5>';
            echo '<p class="text-center font-weight-bold">'.$r['price'].' zł/h</p>';
            echo '<button class="btn btn-info col-12" disabled>DOSTĘPNY OD: '.substr($r['to_date'],0,-3).'</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }
        ?>
        
      </div>
    </div>
  </section>
  <!--unavailable-->

  <!--reservation form-->
  <section id="reservation">
    <div class="container-fluid">
      <h1 class="text-white text-center p-5 font-weight-bold">ZAREZERWUJ</h1>
      <div class="row">
        <div class="col-12 d-flex justify-content-center p-5 text-white">
          <form action="reserve.php" method="POST">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="name">Imię</label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Podaj imię" required>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="surname">Nazwisko</label>
                  <input type="text" class="form-control" name="surname" id="surname" placeholder="Podaj nazwisko"
                    required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="phone">Telefon</label>
              <input type="tel" class="form-control" placeholder="Podaj numer telefonu" required>
            </div>
            <div class="form-group">
              <label for="tool">Narzędzie</label>
              <select name="tool" class="form-control" id="tool">
              <?php
                  $rows = get_tools("select");

                  foreach($rows as $r) {
                    echo '<option value="'.$r['id'].'">'.$r['name'].'</option>';
                  }
                ?>
              </select>
            </div>

            <div class="row">
              <div class="col-sm-5">
                <div class="form-group">
                  <label for="date">Termin</label>
                  <input type="datetime-local" class="form-control" name="date" id="date" required>
                </div>
              </div>
              <div class="col-sm-7">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="days">Dni</label>
                      <input type="number" class="form-control" name="days" id="days" min="0" max="13">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="hours">Godzin</label>
                      <input type="number" class="form-control" name="hours" id="days" min="0" max="23">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 mt-4">
                <input type="submit" value="REZERWUJ" class="btn btn-secondary col-12">
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <button onclick="smoothScroll('header')" id="up-button"></button>

  <!--reservation form-->

  <footer>
    <div class="col-12">
      <h6 class="text-center font-weight-bold p-1">COPYRIGHT©2021 MR&AP&JS&WSz Team</h6>
    </div>
  </footer>

  <!-- Optional JavaScript; choose one of the two! -->
  <script src="js/myScript.js"></script>

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>