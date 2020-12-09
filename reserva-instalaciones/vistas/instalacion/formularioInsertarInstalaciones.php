<?php
			// Comprobamos si hay una sesión iniciada o no
				echo "<h1>Insercion de Instalacion</h1>";

				// Creamos el formulario con los campos del libro
				echo "<form action = 'index.php' method = 'POST' enctype='multipart/form-data'>
					Nombre:<input type='text' name='nombre'><br>
					Descripcion:<input type='text' name='descripcion'><br>
					Precio:<input type='int' name='precio'>€ por hora<br>
					Imagen:<input type='file' name='imagen'><br>";

				// Añadimos un selector para el id del autor o autores
				/*echo "Autores: <select name='autor[]' multiple size='3'>";
				foreach ($data['listaAutores'] as $autor) {
					echo "<option value='" . $autor->idPersona . "'>" . $autor->nombre . " " . $autor->apellido . "</option>";
				}
				echo "</select>";*/
				echo "<a href='index.php?action=formularioInsertarInstalaciones'>Añadir nueva</a><br>";

				// Finalizamos el formulario
				echo "  <input type='hidden' name='action' value='insertarInstalacion'>
						<input type='submit'>
					</form>";
				echo "<p><a href='index.php'>Volver</a></p>";
