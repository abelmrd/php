<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=devide-width, initial-scale=1">
    <title> Vitalia nutrición </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous"/>
    <link type="text/css" href="/views/css/header.css" rel="stylesheet">
    
</head>

<body>
<!--
  Página de cabecera estática. Contiene el menú de la aplicación con enlaces que apuntan a la página
  index con el controlador y acción apropiado.
-->
<div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-0">
        <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
            <img src="/assets/vitalia.png" alt="Logo de La botica de Abel" class="logo" width="450" height="150"> <!-- disminuye el tamaño del logotipo --> 
            
        </a>

        <ul class="nav nav-pills">
            <?php if (isset($_SESSION["user"])) : ?>
                <li class="nav-item"><a href="index.php?controller=ProductController&action=aniadirProduct" class="nav-link active" aria-current="page" style="background-color: #49f780; border-color: #49f780;margin-right: 10px;">Añadir</a></li>
                <li class="nav-item"><a href="/models/cerrarsesion.php" class="nav-link active" aria-current="page" style="background-color: #49f780; border-color: #49f780;">Cerrar sesión</a></li>
<?php else: ?>
    <li class="nav-item"><a href="index.php?controller=ProductController&action=login" class="nav-link active" aria-current="page" style="background-color: #49f780; border-color: #49f780;margin-right: 10px;">Login</a></li>
<?php if (!empty($_SESSION["cart"])) : ?>
    <li class="nav-item"><a href="index.php?controller=ProductController&action=showCart" class="nav-link" style="background-color: #49f780; border-color: #49f780;">Ver carrito</a></li>
<?php endif; ?>
<?php endif; ?>
<li class="nav-item"><a href="index.php?controller=ProductController&action=getAllProducts" class="nav-link" style="color: #49f780;">Listar Productos</a></li>
</ul>
</header>

</div>
