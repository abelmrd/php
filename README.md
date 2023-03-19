## Modelo vista controlador MVC

Podríamos definir a este modelo dividiendo en tres componentes principales: el modelo, la vista y el controlador.

- El modelo: representa los datos y la lógica de la aplicación.
- La vista: representa la interfaz de usuario de la aplicación.
- El controlador: actúa como intermediario entre el modelo y la vista, y es responsable de manejar las solicitudes del usuario y actualizar el modelo y la vista según sea necesario.

Para este proyecto utilizamos el modelo vista controlador para estructurar y organizarlo.

Separamos por una parte el controlador, donde está definida la funcionalidad de la página.

Cada función está definida para llamarla cuando sea necesario, instanciando el objeto y

mostrando la vista que sea para cada función, se llama desde el código.
 Con los métodos hacemos funciones de una clase concreta y la llamamos en la instancia de esta clase.

Con el modelo manejamos los datos que vamos a introducir o vamos a recoger de la base de datos.

Con las distintas vistas, que está formada siempre por el header que es la cabecera y el footer que es el pie de página, el usuario puede ver el contenido de la página. En el centro estará la vista que llama el controlador, que podría ser ver el carrito, los productos... etc
 Las vistas seria la interfaz que ve el usuario, y estos datos son proporcionados por el controlador.

En nuestro proyecto hemos decidido implementar una parte administrativa, donde podremos iniciar sesión.

Al comprobar si el usuario ingresado en el login es el mismo que está alojado en la base de datos, la página nos mostrará la opción de añadir productos, eliminarlos o cerrar sesión.
 Por ejemplo, desde este apartado no tenemos acceso a añadir productos al carrito. No tiene mucho sentido que el administrador se compre productos a sí mismo.

Estas comprobaciones las realizamos sabiendo si la sesión este iniciado y el valor del array en concreto el usuario es el administrador o no de la página.

De la parte del usuario podemos ver la lista de productos, agregarlos al carrito y ver los detalles de los mismos, estaría enfocado a la compra de los productos e interacción en la página como usuario.
 Nunca un usuario "corriente" o potencial cliente podrá eliminar productos de la página ni tampoco añadirlos.

Si la sesión esta vacía o el usuario es el administrador (Abel), no podrá acceder a estas opciones destinadas al usuario final.

El diseño está configurado por varios archivos css a los que los llamamos en las vistas, si bien es cierto que, para algunos detalles como tamaño de letra, márgenes y demás se ha implementado implícito en las vistas. Si fuera un diseño más complejo si sería necesario implementarlo en páginas adicionales como hemos hecho en el header,footer y login.

A pesar de que en este proyecto no tendría mucha diferencia en tiempo de ejecución ni carga de trabajo, cabe destacar que con un proyecto de mayor envergadura seria importante diferenciar el controlador de usuarios y el de productos, y no almacenarlos en un solo controlador. En el de usuarios crearíamos las clases y funciones que va a realizar el administrador, y en productos quedaríamos las funciones propias de la tienda como mostrar el carrito, añadir productos etc.

Aquí explicamos una de las funciones del controlador, en concreto la de ver el carrito.
Más tarde veremos la vista donde se muestran los datos que calcula el controlador a través del modelo productos, donde se manejan los datos.

#### Código del controlador para ver el carrito


  ```
  public function showCart() {
    if (isset($_SESSION["user"])) {
        $cart = array();
        $total = 0;
        // recorremos el carrito y obtenemos la información de cada producto por su id
        //
        foreach ($_SESSION["cart"] as $ID_pedido => $quantity) {
            require_once("models/productos.php");
            $pDAO = new ProductoDAO();
            $product = $pDAO->getProductById($ID_pedido);
            $product["cantidad"] = $quantity; // asignamos el valor de la variable a la propiedad cantidad
            $cart[] = $product;
            $total += $product["precio"] * $quantity;
        }
        // calcular el total del carrito si no hay productos (esta vacío) y la sesión esta vacía
        if (!empty($_SESSION["cart"])) {
            $total = $this->calculateTotal();
        }
        // mostramos la vista del carrito con los datos
        View::show("showCart", array("cart" => $cart, "total" => $total));
    } else {
        // lo mostramos e la vista
        View::show("showCart", null);
    }
}

   ```

 ### Código de la vista donde mostramos los datos
 
  \<?php

  // Inicializa el total en 0
   $total = 0;
  // Verifica si el carrito tiene elementos antes de calcular el total
   if (isset($\_SESSION['cart']) && count($\_SESSION['cart']) \> 0) {

//Recorremos los elementos en el carrito y suma sus precios multiplicando por la cantidad

foreach ($\_SESSION['cart'] as $item) {

$total += $item['precio'] \* $item['cantidad'];

}

}

?\>

//codigo html para modificar el estilo, incluyendo márgenes y tamaño de fuente principalmente

\<head\>

\<title\>Carrito de compras\</title\>

\<style\>

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

\</style\>

\</head\>

\<body\>

\<!-- Imprime la tabla con los elementos del carrito --\>

\<div class="container"\>

\<h1\> Carrito de compras \</h1\>

\<table class="table"\>

\<tr\>

\<th\>Producto\</th\>

\<th\>Nombre\</th\>

\<th\>Descripción\</th\>

\<th\>Precio\</th\>

\<th\>Cantidad\</th\>

\</tr\>

\<?php foreach ($\_SESSION['cart'] as $ID\_pedido =\> $item): ?\>

\<!-- Recorremos todos los items que están guardados en la sesión el array carrito de la id concreta

y los mostramos llamando al array item y dentro al valor asociado--\>

\<tr\>

\<td\>\<?php echo "\<img src='/assets/".$item['imagen']."' class='img-fluid' width='100px'\>"; ?\>\</td\>

\<td\>\<?php echo $item['nombre']; ?\>\</td\>

\<td\>\<?php echo $item['descripcion']; ?\>\</td\>

\<td\>\<?php echo $item['precio']; ?\> €\</td\>

\<td\>\<?php echo $item['cantidad']; ?\>\</td\>

\</tr\>

\<?php endforeach; ?\>

\<tr\>

\<td colspan="3"\>\</td\>

\<td\>\<strong\>Total:\</strong\>\</td\>

\<!-- mostramos el valor de la variable total arriba calculado, que es la suma de los productos --\>

\<td colspan="2"\>\<strong\>\<?php echo $total; ?\> €\</strong\>\</td\>

\</tr\>

\</table\>

\</div\>

\</body\>

\<!-- Fin del código --\>
``
