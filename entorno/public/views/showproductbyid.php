<div class="container">
  <div class="row">
    <div class="col-md-4">
      <?php echo "<img src='/assets/".$data['imagen']."' class='img-fluid'>"; ?>
    </div>
    <div class="col-md-8">
      <?php echo "<h1>".$data['nombre']."</h1>"; ?>
      <?php echo "<h2>Producto</h2>"; ?>
      <?php echo "<h4>".$data['descripcion']."</h4>"; ?>
      <?php echo "<h2>Composición</h2>"; ?>
      <?php echo "<h4>".$data['composicion']."</h4>"; ?>
      <?php echo "<div class='cuadrado mb-3'>"."<p class='precio'>"."Precio<br>".$data['precio']."€"."</p>"."</div>"; ?>
      <div class="mt-1">
        <div class="btn-group" role="group">
          <!-- Botón para volver -->
          <a href="index.php?controller=ProductController&action=getAllProducts" class="nav-link active mr-2" style="background-color: #49f780; border-color: #49f780; border-radius: 5px; padding: 10px 20px; color: #ffffff; text-decoration: none;">Volver atrás</a>

          <?php if (!isset($_SESSION["user"]) || (isset($_SESSION["user"]) && $_SESSION["user"] != "Abel")): ?>
            <!-- Botón para añadir -->
            <form method="post" action="index.php?controller=ProductController&action=addToCart">
              <?php if (isset($data['ID_pedido'])): ?>
                <input type="hidden" name="ID_pedido" value="<?php echo $data['ID_pedido']; ?>">
              <?php endif; ?>
              <button type="submit" class="btn btn-primary mr-2" style="margin-left: 10px;">Añadir al carrito
                <img src="assets/carro.png" width="20" height="20">
              </button>
            </form>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>


<style>
  .cuadrado {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 180px;
    height: 180px;
    margin: 10px;
    border-radius: 50%;
    box-shadow: inset 0 0 5px rgba(0,0,0,0.5), 0 1px 0 rgba(255,255,255,0.2), 0 1px 2px rgba(0,0,0,0.2);
    border: solid 1px rgba(255,255,255,0.4);
    background: linear-gradient(to bottom, #49f780, #49d4f7);
    margin-left: 700px;
  }
  
  .precio {
    font-family: 'Bangers', cursive;
    font-size: 40px;
    font-weight: normal;
    color: #000000;
    text-shadow: 0 1px 0 rgba(255,255,255,0.5);
    text-transform: uppercase;
    letter-spacing: 2px;
    text-align: center;
    line-height: 1em;
  }

</style>

<link href="https://fonts.googleapis.com/css?family=Bangers&display=swap" rel="stylesheet">

