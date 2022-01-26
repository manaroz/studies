<?php 

if(!empty($_POST)){
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $phone = trim($_POST['phone']);
    $tool_id = $_POST['tool'];
    $termin = $_POST['date'];
    $days = $_POST['days'];
    $hours = $_POST['hours'];

    foreach($_POST as $p) {
        if($p == '') {
            die('Uzupełnij pole!');
        }
    }

    $today = date('Y-m-d');
    $end_date = date('Y-m-d', strtotime($today.'+ 13 days'));

    if($termin < $today || $termin > $end_date) {
        die('Niepoprawna data!');
    }
    if($days <1 || $days > 13) {
        die('Niepoprawna liczba dni!');
    }
    if($hours <0 || $days > 23) {
        die('Niepoprawna liczba godzin!');
    }

    require('functions.php');
    reserve($name,$surname,$phone,$tool_id,$termin,$days,$hours);
}

?>