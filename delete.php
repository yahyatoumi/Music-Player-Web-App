<?php 
    session_start();
    require_once("Includes/connection.php");

    print_r($_SESSION);
    if(isset($_POST["deletec"])){
        $cn;
        $query = "DELETE from albums_table where album_id = 
        '$_SESSION[album_id]'";
        $stmt = $cn->exec($query);
        header("Location: http://localhost/Project/mainpage.php");

    }
    
    ?>
