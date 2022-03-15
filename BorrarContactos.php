<?php 
    include("db.php");

    $query = "DELETE FROM contactos WHERE Id_Contacto = ".$_GET["id"];

    mysqli_query($conexion, $query);
?>