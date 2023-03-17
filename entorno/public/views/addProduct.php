<!--
    Vista para añadir nuevos productos. Contiene el código HTML con el formulario así como el código PHP para
    mostrar errores de validación, en caso de existir.
-->
   <div class="container"> 
   <h4>Introduce los datos de los productos:</h4>

    <form class="form" action="index.php?controller=ProductController&action=aniadirProduct" method="post">
        <div class="form-group">
            <label class="form-label" style="font-size:1.2rem" for="nombre">Nombre:</label>
            <input class="form-control" type="text" name="nombre"  maxlength="50" value="" ><br>   
            <?php
                if (isset($data) && isset($data['nombre']))
                echo "<div class='alert alert-danger'>"
                       .$data['nombre'].
                      "</div>";
            ?>
        </div>
        <div class="form-group">
            <label class="form-label" style="font-size:1.2rem" for="descripcion">Descripción:</label>
            <input class="form-control" type="text" name="descripcion" ><br>
            <?php
                if (isset($data) && isset ($data['descripcion']))
                echo "<div class='alert alert-danger'>"
                       .$data['descripcion'].
                      "</div>";
            ?>
        </div>
        <div class="form-group">
            <label class="form-label" style="font-size:1.2rem" for="precio">Precio:</label>
            <input class="form-control" type="text" name="precio" ><br>
            <?php
                if (isset($data) && isset($data['precio']))
                echo "<div class='alert alert-danger'>"
                       .$data['precio'].
                      "</div>";
            ?>
        </div>

        <div class="form-group">
            <label class="form-label" style="font-size:1.2rem" for="composicion">Composición:</label>
            <input class="form-control" type="text" name="composicion" ><br>
            <?php
                if (isset($data) && isset ($data['composicion']))
                echo "<div class='alert alert-danger'>"
                       .$data['composicion'].
                      "</div>";
            ?>
        </div>
        <div class="form-group">
            <label class="form-label" style="font-size:1.2rem" for="imagen">imagen:</label>
            <input class="form-control" type="file" name="imagen"><br>
            <?php
                if (isset($data) && isset ($data['imagen']))
                echo "<div class='alert alert-danger'>"
                       .$data['imagen'].
                      "</div>";
            ?>
        </div>
        <?php
                if (isset($data) && isset($data['general']))
                echo "<div class='alert alert-danger'>"
                       .$data['general'].
                      "</div>";
            ?>
        <div class="form-group">
            <input class="form-control" type="submit" name="insertar" value="Enviar">
        </div>
        
    </form>
    </div>
    

 