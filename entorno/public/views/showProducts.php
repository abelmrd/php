<div class="container">
    <h1> Listado de productos </h1>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($data as $article): ?>   
            <div class="col">
                <div class="card">
                <div class="card-body">
  <h5 class="card-title" style="font-size: 1.5rem;"><?php echo $article['nombre']; ?></h5>
  <p class="card-text" style="font-size: 1rem;"><?php echo $article['descripcion']; ?></p>
  <p class="card-text" style="font-size: 1rem;">Precio: <?php echo $article['precio']; ?> €</p>
  <div class="btn-group" role="group">
    <a href="index.php?controller=ProductController&action=getProductById&ID_pedido=<?php echo $article['ID_pedido']; ?>" class="btn btn-primary">Ver más</a>
  </div>
  <div class="btn-group" role="group">
    <form method="post" action="index.php?controller=ProductController&action=addToCart">
      <?php if (isset($article['ID_pedido'])): ?>
        <input type="hidden" name="ID_pedido" value="<?php echo $article['ID_pedido']; ?>">
      <?php endif; ?>
      <button type="submit" class="btn btn-primary">Añadir al carrito</button>
    </form>
  </div>
</div>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>







