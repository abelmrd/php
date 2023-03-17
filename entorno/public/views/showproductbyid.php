<div class="container">
    <?php echo "<h1>".$data['nombre']. "</h1>";
    ?>
</div>
<div class="container">
    <?php echo "<img src=/assets/".$data['imagen']." width='200' height='300'>";
    ?>
</div>
<div style="position: relative; top: -220px; left: 320px;">
    <?php 
    echo "<h2>Producto</h2>";
     echo "<p style='text-align: right; display: inline-block; font-size: 22px;'>".$data['descripcion']."</p>";
     echo "<br>";
     echo "<h2>Composición</h2>";
     echo "<p style='text-align: right; display: inline-block; font-size: 22px;'>".$data['composicion']."</p>";
    ?> 
</div>
<div style="position: absolute; top: 300px; right: 50px;" class="cuadrado">   
  <?php 
    echo "<p>"."Precio"." ".$data['precio']."€"."</p>";
  ?>
</div>

<style>
.cuadrado {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 150px;
  height: 150px;
  margin: 10px;
  border-radius: 50%;
  box-shadow: 0 0 0 2px #4c4c4c, 0 0 0 4px #d9d9d9, 0 0 0 6px #4c4c4c;
  font-weight: bold;
  font-size: 20px;
  color: #000000;
  background: linear-gradient(to bottom, #49f780, #49d4f7);
}
</style>


