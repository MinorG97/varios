<?php

require('../models/conect.php');
$conexion = Connection::ConectDB();
if ($conexion->connect_error) {
    die('connection failed' . $conexion->connect_error);
} else {
    try {


        if (isset($_POST['email']) && !empty($_POST['email'])) {
            $mail = $_POST['email'];
            
            $pass = $conexion->prepare("SELECT contra FROM clients  WHERE correo='$mail'");
            $pass->execute();
            $valor = $pass->fetchAll();
            $valor2 = $valor[0]["contra"];
            if ($pass->rowCount()>0) {
                //notificar
                $to = $_POST['email']; //destinatario
                $from = "From:" . "gogrooming.com"; //se configura los envios de correo
                $subject = "Recordar Contraseña";
                $message = "Su clave es: " . $valor2;
                mail($to, $subject, $message, $from);
                echo '<script type="text/javascript">
                alert("Correo enviado satisfactoriamente");
                window.location.href="../index.php";
                </script>';
                // header("Location:../index.php");
            } else {
                echo '<script type="text/javascript">
                alert("Correo no existe por favor registrese");
                window.location.href="../index.php";
                </script>';
            }
        } else {
            echo 'no hay' . $_POST['email'];
        }
    } catch (Exception $e) {
        echo 'error capturado', $e->getMessage(), "\n";
    }
}



?>
