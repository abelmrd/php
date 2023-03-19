<?php
include_once ("views/header.php");
include ("Controllers/ProductsController.php");

//Punto de entrada a la aplicación. Si no se recibe parámetro action y controller en la url
//se muestra la página de inicio (texto HTML).
//En caso de que si se reciba, se instancia el controlador y se invoca la acción indicada.

if (isset($_REQUEST['action']) && isset($_REQUEST['controller']) ){
    $act=$_REQUEST['action'];
    $cont=$_REQUEST['controller'];

    //Instanciación del controlador e invocación del método
    $controller=new $cont();
    $controller->$act();

}
else
    //Página de entrada <div class="d-flex justify-content-center"><p>Desarrollo de aplicaciones web con PHP utilizando la arquitectura Modelo Vista Controlador (MVC)</p></div>
    echo '<div class="container mt-3">
    <h1>Bievenidos a Vitalia</h1>
    <h2>Somos tu mayor aliado en nutrición y suplementos</h2>
    <div class="d-flex justify-content-center image-container">
  <img src="assets/vitalia2.png" width="649" height="300">
</div>

    
    
  </div>';

  require_once ("views/footer.php");

?>
<style>
  .image-container {
  max-width: 649px; 
  margin: 20px auto; 
  display: flex;
  justify-content: center;
  border: 5px solid #49f780;
  box-sizing: border-box; 
  padding: 1px; 
}

</style>
