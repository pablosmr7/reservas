<?php
		// Comprobamos si hay una sesión iniciada o no
		echo "<h1>Alta de Usuarios</h1>";

		// Creamos el formulario con los campos del libro
		echo "<form action = 'index.php' method = 'post' enctype='multipart/form-data'>
			Email:<input type='text' name='email'><br>
			Contraseña:<input type='text' name='password'><br>
			Nombre:<input type='text' name='nombre'><br>
			Primer apellido:<input type='text' name='apellido1'><br>
            Segundo apellido:<input type='text' name='apellido2'><br>
            DNI:<input type='text' name='dni'><br>
            Imagen:<input type='file' name='imagen'><br>
			Tipo:<select name='tipo'>
				<option value='user' selected >Usuario</option>
				<option value='admin'>Admin</option>
			</select><br><br>";

		// Finalizamos el formulario
		echo "  <input type='hidden' name='action' value='insertarUsuario' onclick='comprobarPasswd()'>
				<input type='submit'>
		</form>";
		echo "<p><a href='index.php?action=listaUsuarios'>Volver</a></p>";