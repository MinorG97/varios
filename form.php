<?php

if(!empty($_POST)){
    $name=$_POST['name'];
    $password=$_POST['password'];
    $captcha=$_POST['g-recaptcha-response'];
    $secret='6LfBWNsUAAAAALhZf6Wzr9__y7jT4vABIpZPo8TL';

    if (!$captcha) {
        echo 'porfavor verifica el cap';
    }
    $response=file_get_contents(
        "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha"
       
    );
    var_dump($response);
    $arr=json_decode($response,true);
    if ($arr['success']) {
        echo 'correcto';
    }else {
        echo ' comprobar captcha';
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>ReCaptcha Google</title>
</head>

<body>
<form id="form" action="form.php" method="POST">
    Usuario: <input type="text" name="name">
    <br><br>
    password: <input type="password" name="password">
    <br><br>
    <div class="g-recaptcha" data-sitekey="6LfBWNsUAAAAAA_xcQYXEbQusyyaVBsH3NnwGZgs"></div>
    <br><br>
    <button type="submit" name="login" value="Login"> Login </button>
</form>



</body>

</html>