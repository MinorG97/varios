<?php
include_once 'conexion.php';

//llamar a todos los articulos
$sql = 'SELECT * FROM articulos';
$sentencia = $pdo->prepare($sql);
$sentencia->execute();
$resultado = $sentencia->fetchAll();
//var_dump($resultado);

$articulo_x_pagina = 4;

//contar articulos de nuestra base de datos
$total_articulos_db = $sentencia->rowCount();
//echo $total_articulos_db;
$paginas = $total_articulos_db / 4;
//para redondear hacia arriba y no se quede un articulo por fuera
$paginas = ceil($paginas);

?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <div class="container my-5">
        <h1 class="mb-5">Paginacion</h1>
<!---para hacer que la pagina muestre solo cierta cantidad  -->
    <?php   
        if (!$_GET) {
            header('Location:paginacion.php?pagina=1');
        }
        //para que no paginen mas de lo debido
        if ($_GET['pagina']>$paginas ||$_GET['pagina']<=0 ) {
            header('Location:paginacion.php?pagina=1');
        }

    //esa variable $iniciar nos ayudara hacer el calculo para ir pasando de paginacion
    $iniciar=($_GET['pagina']-1)*$articulo_x_pagina;
    //echo $iniciar;

        $sql_articulos='SELECT*FROM articulos LIMIT :iniciar,:narticulos';
        $sentencia_articulos=$pdo->prepare($sql_articulos);
        $sentencia_articulos->bindParam(':iniciar',$iniciar,PDO::PARAM_INT);
        $sentencia_articulos->bindParam(':narticulos',$articulo_x_pagina,PDO::PARAM_INT);
        $sentencia_articulos->execute();

        $resultado_articulos=$sentencia_articulos->fetchAll();
    ?>

        <?php foreach ($resultado_articulos as $articulo) : ?>
            <div class="alert alert-primary" role="alert">
                <?php echo $articulo['titulo']  ?>
            </div>
        <?php endforeach ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item
                <?php echo $_GET['pagina'] <= 1  ? 'disabled':'' ?>"
                >
                    <a class="page-link" href="paginacion.php?pagina=<?php echo $_GET['pagina']-1; ?>">Ant</a>
                </li>

                <?php for ($i = 0; $i < $paginas; $i++) :  ?>
                    <li class="page-item <?php echo $_GET['pagina']==$i+1 ? 'active':'' ?>">
                        <a class="page-link" href="paginacion.php?pagina=<?php echo $i + 1; ?>">
                            <?php echo $i + 1; ?>
                        </a>
                    </li>
                <?php endfor ?>

                <li class="page-item
                 <?php echo $_GET['pagina']>=$paginas ? 'disabled':'' ?>
                ">
                    <a class="page-link"  href="paginacion.php?pagina=<?php echo $_GET['pagina']+1; ?>">Sig</a>
                </li>
            </ul>
        </nav>
    </div>




    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>