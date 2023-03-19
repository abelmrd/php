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
    // para el login comprobamos que se haya enviado y guardamos en las variables l usuario y contraseña
    //llamo al archivo de conexion db.php y la conecto
    //se hace una consulta para comprobobar que las variables tienen los valores que hay en la tabla usuarios de la bd
    //se guarda en $result
    //si el contenido del array en user yes igual al resultado abrimos la pestaña de añadir productos habilitada al administrador
    // y si no nos vuelve a mostrar el login y un pequeño mensaje de error
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
                echo "<h1><center>Usuario incorrecto</center></h1>";
                View::show("login", null);
            }
            $stmt->closeCursor();
        } else {
            View::show("login", null);
        }
    }
    //comprobamos si el ID esta en el array , llamamos al dao, eliminamos el producto y mostramos todos los productos
    //asi eliminamos una producto de la base de datos 
    public function deleteProductById() {
        if (isset($_POST['ID_pedido'])) {
            require_once("models/productos.php");
            $pDAO = new ProductoDAO();
            if ($pDAO->deleteProductById($_POST['ID_pedido'])) {
                $this->getAllProducts();
            }
        }
    }
                
    
// para el carrito de la compra y mostrarlo, perimero vemos si ha iniciado sesión e inicializamos el carrito y la variable total
 
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

//método para calcular el total. lo inciamos a 0 . recorremos los productos del carrito 
//suma del precio por la cantidad de cada producto en el carrito y se devuelve el valor total
public function calculateTotal() {
    $total = 0;
    foreach ($_SESSION['cart'] as $ID_pedido => $item) {
        $total += $item['precio'] * $item['cantidad'];
    }
    return $total;
}


//método poara cerrar sesisión eliminamos la sesión del usuario y le mostramos el login de nuevo
public function cerrarsesion() {
session_destroy();
View::show("login", null);;
}




//método para añadir productos al carrito
//conectamos a la base de datos con db.php
//utilizamos una consulta que nos muestre el id nombre descripción y precio de la tabla cuando el id sea el pulsado
//con execute la ejecuta en el objeto
//obtenemos resultados de la consulta con fetchAll() del objeto PDO guardando en la variable $result como un array
//añadimos un nuevo elemento al array $_SESSION["cart"] con la cantidad 
//cierra la conexión


public function addToCart() {
    // recuperamos el ID del producto y la cantidad desde $_POST
    $ID_pedido = $_POST['ID_pedido'];
    $quantity = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1;
    // si el carrito no existe, lo creamos como un array vacío
    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = array();
    }
    // si el producto ya está en el carrito, sumamos la cantidad nueva a la existente
    if (isset($_SESSION["cart"][$ID_pedido])) {
        $_SESSION["cart"][$ID_pedido]["cantidad"] += $quantity;
        $_SESSION["cart"][$ID_pedido]["total"] += $_SESSION["cart"][$ID_pedido]["precio"] * $quantity;
    } else { // si no está, simplemente lo añadimos
        require_once("db/db.php");
        $dbh = Database::connect();
        $stmt = $dbh->prepare("SELECT ID_pedido, nombre, descripcion, precio, imagen FROM Productos WHERE ID_pedido = ?");
        $stmt->bindParam(1, $ID_pedido);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION["cart"][$ID_pedido] = array(
            'nombre' => $result[0]['nombre'],
            'descripcion' => $result[0]['descripcion'],
            'precio' => $result[0]['precio'],
            'imagen' => $result[0]['imagen'],
            'cantidad' => $quantity,
            'total' => $result[0]['precio'] * $quantity
        );
        $dbh = null;
    }
    // calcular el total del carrito
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['total'];
    }
    // redireccionamos a la página del producto
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