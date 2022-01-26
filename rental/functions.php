<?php
    require('admin/sql_connect.php');

   function get_tools($type){

        global $mysqli;

        switch($type){
            case 'available':
                $sql = "SELECT id,name,price,photo_url FROM tools WHERE available = 1";
                break;
            case 'unavailable':
                $sql = "SELECT tools.id, tools.name, tools.price, tools.photo_url, reservations.to_date FROM tools INNER JOIN reservations ON tools.id = reservations.tool_id WHERE tools.available = 0";
                break;
            case 'select':
                $sql = "SELECT id,name FROM tools WHERE available = 1";
                break;
        }

        if($type == "available") {
            $sql = "SELECT id,name,price,photo_url FROM tools WHERE available = 1";
        } elseif($type == "unavailable") {
            $sql = "SELECT tools.id, tools.name, tools.photo_url, tools.price, reservations.to_date FROM tools INNER JOIN reservations ON tools.id = reservations.tool_id WHERE tools.available = 0";
        } elseif($type == "select") {
            $sql = "SELECT id,name FROM tools WHERE available =1";
        }
        
        $result = $mysqli -> query($sql);

        $rows = $result -> fetch_all(MYSQLI_ASSOC);

        return $rows;
   }
   function generate_dashboard() {
    global $mysqli;

    $sql = "SELECT tools.name, clients.surname, reservations.cost, reservations.to_date FROM reservations INNER JOIN tools ON reservations.tool_id = tools.id INNER JOIN clients ON clients.id = reservations.client_id";

    $result = $mysqli -> query($sql);
    $rows = $result -> fetch_all(MYSQLI_ASSOC);

    return $rows;
}
function reserve($name, $surname, $phone, $tool_id, $termin, $days, $hours) {
    global $mysqli;

    $from_date = $termin;

    $to_date = date('Y-m-d H:i',strtotime($from_date.'+'.$days.' days + '.$hours.' hours'));

    $sql = "SELECT price, name, available FROM tools WHERE id = $tool_id";

    $result = $mysqli -> query($sql);
    $row = $result -> fetch_row();

    $price = $row[0];
    $tool_name = $row[1];
    $available = $row[2];

    if($available != 1) {
        die('Narzędzie zajęte!');
    }

    $cost = ($days * 24 + $hours) * $price;

    $sql_2 = "INSERT INTO clients (`name`,`surname`,`phone`) VALUES (?,?,?)";

    if($statement = $mysqli -> prepare($sql_2)) {
        if($statement -> bind_param('sss', $name, $surname, $phone)) {
            $statement -> execute();
            $client_id = $mysqli -> insert_id;
                 $sql_3 = "INSERT INTO reservations (`client_id`, `tool_id`, `from_date`, `to_date`, `cost`) VALUES (?,?,?,?,?)";

                 if($statement_2 = $mysqli -> prepare($sql_3)){
                     if($statement_2 -> bind_param('iissi',$client_id,$tool_id,$from_date,$to_date,$cost)){
                         $statement_2 -> execute();
                         $mysqli -> query("UPDATE tools SET available = 0 WHERE id = $tool_id");
                         header("Location: index.php");
                     }
                 }
        }
     } else {
         die('Niepoprawne zapytanie!'.$mysqli -> err_message());
 }

}
?>

