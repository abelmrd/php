<?php
/**
 *  Controlador de Productos. Implementará todas las acciones que se puedan llevar a cabo desde las vistas
 * que afecten a productos de la tienda.
 */
include ("views/View.php");
class ProductController {
    /**
     * Método que obtiene todos los productos de la BBDD y los muestra a través de la vista showProducts.
     */
    public function getAllProducts (){
        require_once ("models/productos.php");
        $pDAO=new ProductoDAO();
        $products=$pDAO->getAllProducts();
        $pDAO=null;
        View::show("showProducts", $products);
    }
    public function getProductById (){
        require_once ("models/productos.php");
        $pDAO=new ProductoDAO();
        $products=$pDAO->getProductById($_GET['ID_pedido']);
        $pDAO=null;
        View::show("showProductById", $products);
    }
    public function login() {
        if (isset($_POST["nombre"])) {
            $user = $_POST["nombre"];
            $pass = $_POST["password"];
            require_once("db/db.php");
            $dbh = Database::connect();
            $stmt = $dbh->prepare("SELECT nombre, password FROM Usuarios WHERE nombre = ? AND password = ?");
            $stmt->bindParam(1, $user);
            $stmt->bindParam(2, $pass);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $dbh = null;
            if ($result) {
                $_SESSION["user"] = $result['nombre'];
                echo "<script>window.location.href = 'index.php?controller=ProductController&action=aniadirProduct';</script>";
                return;
            } else {
                View::show("login", null);
            }
            $stmt->closeCursor();
        } else {
            View::show("login", null);
        }
    }
    
    /**
 * Método que muestra el contenido del carrito de la compra
 */
public function showCart() {
    if (isset($_SESSION["user"])) {
        $cart = array();
        $total = 0;
        // Recorremos el carrito y obtenemos la información de cada producto
        foreach ($_SESSION["cart"] as $ID_pedido => $quantity) {
            require_once("models/productos.php");
            $pDAO = new ProductoDAO();
            $product = $pDAO->getProductById($ID_pedido);
            $product["cantidad"] = $quantity; // Reemplazamos 'quantity' por 'cantidad'
            $cart[] = $product;
            $total += $product["precio"] * $quantity;
        }
        // Calcular el total del carrito si no está vacío
        if (!empty($_SESSION["cart"])) {
            $total = $this->calculateTotal();
        }
        // Mostramos la vista del carrito pasándole los datos necesarios
        View::show("showCart", array("cart" => $cart, "total" => $total));
    } else {
        // Redireccionamos a la página de inicio de sesión
        View::show("showCart", null);
    }
}



/**
 * Método que elimina un producto del carrito de la compra
 */
/**
 * Método que elimina un producto del carrito de la compra
 */





public function calculateTotal() {
    $total = 0;
    foreach ($_SESSION['cart'] as $ID_pedido => $item) {
        $total += $item['precio'] * $item['cantidad'];
    }
    return $total;
}
/**
 * Método que añade un producto al carrito de la compra
 */
public function addToCart() {
    // Recuperamos el ID del producto y la cantidad desde $_POST
    $ID_pedido = $_POST['ID_pedido'];
    $quantity = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1;
    // Si el carrito no existe, lo creamos como un array vacío
    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = array();
    }
    // Si el producto ya está en el carrito, sumamos la cantidad nueva a la existente
    if (isset($_SESSION["cart"][$ID_pedido])) {
        $_SESSION["cart"][$ID_pedido]["cantidad"] += $quantity;
        $_SESSION["cart"][$ID_pedido]["total"] += $_SESSION["cart"][$ID_pedido]["precio"] * $quantity;
    } else { // Si no está, simplemente lo añadimos
        require_once("db/db.php");
        $dbh = Database::connect();
        $stmt = $dbh->prepare("SELECT ID_pedido, nombre, descripcion, precio FROM Productos WHERE ID_pedido = ?");
        $stmt->bindParam(1, $ID_pedido);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION["cart"][$ID_pedido] = array(
            'nombre' => $result[0]['nombre'],
            'descripcion' => $result[0]['descripcion'],
            'precio' => $result[0]['precio'],
            'cantidad' => $quantity,
            'total' => $result[0]['precio'] * $quantity
        );
        $dbh = null;
    }
    // Calcular el total del carrito
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['total'];
    }
    // Redireccionamos a la página del producto
    View::show("showCart", array('total' => $total));
}

    /**
     * Método que añade un producto a la BBDD recogiendo los datos que llegan a través de $_POST. Previo
     * a la inserción realiza la validación de los datos.
     */
    public function aniadirProduct (){
        $errores=array();      
        /* Si se ha pulsado en el botón insertar se validan los datos y en caso de error, éstos se almacenan
        en el array $errores*/
        if (isset($_POST['insertar'])){
            if (!isset($_POST['nombre']) || strlen($_POST['nombre'])==0) 
                $errores['nombre']="El nombre no puede estar vacío.";
            if (!isset($_POST['descripcion']) || strlen($_POST['descripcion'])<10) 
                $errores['descripcion']="La descripción debe tener al menos 10 caracteres";    
            if (!isset($_POST['precio']) || strlen($_POST['precio'])==0) 
                $errores['precio']="El precio no puede estar vacío.";
            if (!isset($_POST['composicion']) || strlen($_POST['composicion'])<10) 
                $errores['composicion']="La descripción debe tener al menos 10 caracteres";
            if (!isset($_POST['imagen']) || strlen($_POST['imagen'])==0) 
                $errores['imagen']="Debes añadir una imagen.";
            /**
             * Si el array está vacío es que no hay errores. Si instancia un ProductoDAO y se trata de insertar
             * el nuevo producto en la BBDD. 
             * Si se produce la inserción, se llama al método que muestra todos los productos de la tienda.
             * Si hay error, se muestra la vista de inserción pasándole el array de errores.
             */
                if (empty($errores)){
                include ("models/productos.php");
                $pDAO=new ProductoDAO();
                if ($pDAO->insertProduct($_POST['nombre'], $_POST['descripcion'], $_POST['precio'], $_POST['composicion'], $_POST['imagen']))
                    $this->getAllProducts();                 
                else {
                    $errores['general']="Problemas al insertar";
                    View::show("addProduct", $errores);  
                }     
            }
            else  View::show("addProduct", $errores);               
        }
        // Si no se pulsó el botón insertar, se muestra la vista con el formulario.
        else {
            View::show("addProduct", null);
        }
    }
}
?>