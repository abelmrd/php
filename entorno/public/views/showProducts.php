<div class="container">
    <h1>Listado de productos</h1>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($data as $article): ?>   
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" style="font-size: 1.5rem;"><?php echo $article['nombre']; ?></h5>
                        <p class="card-text" style="font-size: 1rem;"><?php echo $article['descripcion']; ?></p>
                        <p class="card-text" style="font-size: 1rem;">Precio: <?php echo $article['precio']; ?> €</p>
                        <div class="btn-group" role="group">
                            
                        <a href="index.php?controller=ProductController&action=getProductById&ID_pedido=<?php echo $article['ID_pedido']; ?>" class="btn btn-primary">
  Ver más 
  <img src="assets/lupa.png" width="20" height="20">
</a>
                        
                        <!--<a href="index.php?controller=ProductController&action=getProductById&ID_pedido=<?php echo $article['ID_pedido']; ?>" class="btn btn-primary">Ver más</a>-->
                        </div>
                        <!--Comprobamos si el usuario esta logeado y es abel, para habilitar el noton de eliminar. Si hay usuario conectado pero no es abel saldra e boton de añadir al carrito y vermas-->
                        <?php if (isset($_SESSION["user"]) && $_SESSION["user"] == "Abel"): ?>
                            <div class="btn-group" role="group">
                                <form method="post" action="index.php?controller=ProductController&action=deleteProductById">
                                 <?php if (isset($article['ID_pedido'])): ?>
                                <input type="hidden" name="ID_pedido" value="<?php echo $article['ID_pedido']; ?>">
                                <?php endif; ?>
                                <button type="submit" class="btn btn-danger">Eliminar 
                                <img src="assets/pape.png" width="20" height="20">
                                </button>
                                </form>
                            </div>
                        <?php endif; ?>
                        <!--si no hay usuari logeado o el usuario no es abel, me muestra añadir al carrito +vermas -->
                        <?php if (!isset($_SESSION["user"]) || (isset($_SESSION["user"]) && $_SESSION["user"] != "Abel")): ?>
                            <div class="btn-group" role="group">
                                <form method="post" action="index.php?controller=ProductController&action=addToCart">
                                <?php if (isset($article['ID_pedido'])): ?>
                                <input type="hidden" name="ID_pedido" value="<?php echo $article['ID_pedido']; ?>">
                                <?php endif; ?>
                                <button type="submit" class="btn btn-primary">Añadir al carrito
                                <img src="assets/carro.png" width="20" height="20">
                                </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>







