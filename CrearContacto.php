<?php 
    include('db.php');

    $query = "INSERT INTO contactos(Ciudad, Direccion, Telefono) VALUES ('".$_GET['ciudad']."', '".$_GET['direccion']."', ".$_GET['telefono'].")";

    mysqli_query($conexion, $query);
?>