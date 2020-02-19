<?php

   try {
       if(isset($_POST['email']) && !empty($_POST['email'])){
            $pass=substr(md5(microtime()),1,8);
            $mail=$_POST['email'];

            $conn=new mysqli('localhost','user','password','bd');
            if ($conn->connect_error) {
                die('connection failed'.$conn->connect_error);
            }
            $sql="Update tbl_usuario Set password='$pass'where correo='$mail'";
            if ($conn->query($sql)===true) {
                echo "usuario modificado con exito";
            }else{
                echo "error modificado:".$conn->error;
            }

            //notificar
            $to=$_POST['email'];//destinatario
            $from="From:"."Masterhouse";//se configura los envios de correo
            $subject="Recordar Contraseña";
            $message="El sistema la asigno la clave".$pass;

            mail($to,$subject,$message,$from);
            echo 'correo enviado a:'. $_POST['email'];

       }else{
           echo'informacion incompleta';
       }
   } catch (Exception $e) {
       echo 'error capturado', $e->getMessage(),"\n";
       
   }
?>