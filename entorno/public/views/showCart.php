<?php
// Inicializa el total en 0
$total = 0;
// Itera a través de los elementos en el carrito y suma sus precios
foreach ($_SESSION['cart'] as $item) {
    $total += $item['precio'] * $item['cantidad'];
}
?>

<head>
    <title>Carrito de compras</title>
    <style>
        body {
            font-size: 16px;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 0px;
        }
        table {
            font-size: 18px;
        }
        .card-title {
            font-size: 1.5rem;
        }
        .card-text {
            font-size: 1rem;
        }
    </style>
</head>
<body>
<!-- Imprime la tabla con los elementos del carrito -->
<div class="container">
    <h1> Carrito de compras </h1>
    <table class="table">
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Cantidad</th>
            
        </tr>
        <?php foreach ($_SESSION['cart'] as $ID_pedido => $item): ?>
            <tr>
                <td><?php echo $item['nombre']; ?></td>
                <td><?php echo $item['descripcion']; ?></td>
                <td><?php echo $item['precio']; ?> €</td>
                <td><?php echo $item['cantidad']; ?></td>
                
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="2"></td>
            <td><strong>Total:</strong></td>
            <td colspan="2"><strong><?php echo $total; ?> €</strong></td>
        </tr>
    </table>
</div>
</body>



