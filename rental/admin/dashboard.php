<?php
session_start();
require('../functions.php');
    if(!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] !== true){
        die("Dostęp zabroniony!");
    }
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

    <title>Dashboard</title>
</head>

<body>
    <div class="col-12">
        <h1 class="text-center font-weight-bold p-5">REZERWACJE</h1>
        <div class="text-center">
            <a href="../index.php" class="m-2">POWRÓT</a> | <a href="logout.php" class="m-2">WYLOGUJ</a>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">
                        </th>
                        <th scope="col">Narzędzie</th>
                        <th scope="col">Wypożyczył</th>
                        <th scope="col">Koszt</th>
                        <th scope="col">Zwrot</th>
                    </tr>
                </thead>
                <tbody>
                
                    <?php
                        $rows = generate_dashboard();

                        for($i=0;$i<count($rows);$i++){
                            echo '<tr>';
                            echo '<th scope="row">'.($i+1).'</th>';
                            echo '<td>'.$rows[$i]['name'].'</td>';
                            echo '<td>'.$rows[$i]['surname'].'</td>';
                            echo '<td>'.$rows[$i]['cost'].'</td>';
                            echo '<td>'.$rows[$i]['to_date'].'</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>



    <!-- Optional JavaScript; choose one of the two! -->

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