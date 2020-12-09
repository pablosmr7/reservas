<?php
    $instalacion = $data['instalacion'];

    echo "<h3>Modificar Instalacion</h3>";
    echo "<form action = 'index.php' method = 'post' enctype='multipart/form-data'>
            <input type='hidden' name='idInstalacion' value='$instalacion->idInstalacion'>
            Nombre:<input type='text' name='nombre' value='$instalacion->nombre'><br>
            Descripcion:<input type='text' name='descripcion' value='$instalacion->descripcion'><br>
            Imagen:<input type='file' name='imagen' value='$instalacion->imagen'><br>
            <img src=".$instalacion->imagen." width='80' height='80'><br><br>
            Precio:<input type='text' name='precio' value='$instalacion->precio'>€ por hora<br>";
        echo "<input type='hidden' name='action' value='modificarInstalacion'>
            <input type='submit'>
        </form>";
    echo "<p><a href='index.php?action=modificarInstalacion'>Volver</a></p>";
