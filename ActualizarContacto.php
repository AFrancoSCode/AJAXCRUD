<?php
    include("db.php");

    $query = "UPDATE contactos SET Ciudad='".$_GET["ciudad"]."', Direccion='".$_GET["direccion"]."', Telefono=".$_GET["telefono"]." WHERE Id_Contacto=".$_GET["id"];

    $resultado = mysqli_query($conexion, $query);

    echo $resultado;
?>