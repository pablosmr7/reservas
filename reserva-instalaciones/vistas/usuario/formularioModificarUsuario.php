<?php

$usuario = $data['usuario'];


echo "<h1>Modificar Usuario</h1>";
echo "<form action = 'index.php' method = 'POST' enctype='multipart/form-data'>
        <input type='hidden' name='idUsuario' value='$usuario->idUsuario'>
        
        E-mail:<input type='email' name='email' value='$usuario->email'><br>
        Contraseña:<input type='password' name='password' id='psswd1' value='$usuario->password'><br>
        Comprobar Contraseña:<input type='password' name='password' id='psswd2' value='$usuario->password'><span id='mensajeUsuario'></span><br>
        Nombre:<input type='text' name='nombre' value='$usuario->nombre'><br>
        Primer Apellido:<input type='text' name='apellido1' value='$usuario->apellido1'><br>
        Segundo Apellido:<input type='text' name='apellido2' value='$usuario->apellido2'><br>
        DNI:<input type='text' name='dni' value='$usuario->dni'><br>
        Imagen:<input type='file' name='imagen' value='$usuario->imagen'><br>
        <img src=".$usuario->imagen." width='80' height='80'><br><br>";

    echo "<input type='hidden' name='action' value='modificarUsuario' onclick='comprobarPasswd()'>
          <input type='submit'>
    </form>";
echo "<p><a href='index.php?action=mostrarUsuarios'>Volver</a></p>";