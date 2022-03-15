<?php 

    include('db.php');

    $query = "SELECT * FROM contactos";

    $resultado = mysqli_query($conexion, $query);

    $jsonArray = array();

    $jsonTotal = array();

    while($row = mysqli_fetch_array($resultado)){
        $jsonArray["Id_Contacto"] = $row["Id_Contacto"];
        $jsonArray["Ciudad"] = $row["Ciudad"];
        $jsonArray["Direccion"] = $row["Direccion"];
        $jsonArray["Telefono"] = $row["Telefono"];
        array_push($jsonTotal, $jsonArray);
    }

    echo json_encode($jsonTotal);
?>