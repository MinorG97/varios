<?php
try {
    $pdo=new PDO('mysql:host=localhost;dbname=paginacion','root','');
    echo('logrado');
} catch (Exception $th) {
    echo $th;
}

?>