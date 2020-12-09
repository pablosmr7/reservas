<script>
	// **** Petición y respuesta AJAX con JS tradicional ****

	peticionAjax = new XMLHttpRequest();

	function borrarPorAjax(idInstalacion) {
		if (confirm("¿Está seguro de que desea borrar la instalacion?")) {
			idInstalacionGlobal = idInstalacion;
			peticionAjax.onreadystatechange = borradoInstalacionCompletado;
			peticionAjax.open("GET", "index.php?action=borrarInstalacionAjax&idInstalacion=" + idInstalacion, true);
			peticionAjax.send(null);
		}
	}

	function borradoLibroCompletado() {
		if (peticionAjax.readyState == 4) {
			if (peticionAjax.status == 200) {
				idInstalacion = peticionAjax.responseText;
				if (idInstalacion == -1) {
					document.getElementById('msjError').innerHTML = "Ha ocurrido un error al borrar la instalacion";
				} else {
					document.getElementById('msjInfo').innerHTML = "Instalacion borrada con éxito";
					document.getElementById('instalacion' + idInstalacion).remove();
				}
			}
		}
	}

	// **** Petición y respuesta AJAX con jQuery ****

	$(document).ready(function() {
		$(".btnBorrar").click(function() {
			if (confirm("¿Está seguro de que desea borrar la instalacion?")) {
				$.get("index.php?action=borrarInstalacionAjax&idInstalacion=" + this.id, null, function(idInstalacionBorrado) {
					if (idInstalacionBorrado == -1) {
						$('#msjError').html("Ha ocurrido un error al borrar la instalacion");
					} else {
						$('#msjInfo').html("Instalacion borrada con éxito");
						$('#libro' + idInstalacionBorrado).remove();
					}
				});
			}
		});
	});
</script>



<?php
echo "<h2><a href='index.php?action=mostrarListaUsuarios'>Lista Usuarios</a></h2> 
		<h2><a href='index.php?action=mostrarListaInstalaciones'text>Lista Instalaciones</a></h2> 
 		<h2><a href='index.php?action=mostrarListaReservas'>Lista Reservas</a></h2>";


echo "<h3>Gestion Instalaciones</h3>";
// Mostramos info del usuario logueado (si hay alguno)
if ($this->seguridad->haySesionIniciada()) {
	echo "<p>Hola, " . $this->seguridad->get("nombreUsuario") . "</p>";
	echo "<p align='right'><img width='50' src='" . $this->seguridad->get("fotografiaUsuario") . "'></p>";
}
// Mostramos mensaje de error o de información (si hay alguno)
if (isset($data['msjError'])) {
	echo "<p style='color:red' id='msjError'>" . $data['msjError'] . "</p>";
} else {
	echo "<p style='color:red' id='msjError'></p>";
}
if (isset($data['msjInfo'])) {
	echo "<p style='color:blue' id='msjInfo'>" . $data['msjInfo'] . "</p>";
} else {
	echo "<p style='color:blue' id='msjInfo'></p>";
}


// Enlace a "Iniciar sesión" o "Cerrar sesión"
if (isset($_SESSION["idUsuario"])) {
	echo "<p><a href='index.php?action=cerrarSesion'>Cerrar sesión</a></p>";
} else {
	echo "<p><a href='index.php?action=mostrarFormularioLogin'>Iniciar sesión</a></p>";
}


if (count($data['listaInstalaciones']) > 0) {

	// Ahora, la tabla con los datos de los libros
	echo "<table border ='1'>";
	foreach ($data['listaInstalaciones'] as $instalacion) {
		echo "<tr id='libro" . $instalacion->idInstalacion . "'>";
		echo "<td>" . $instalacion->nombre . "</td>";
		echo "<td>" . $instalacion->descripcion . "</td>";
		echo "<td><img src='" . $instalacion->imagen . "' width='100' height='100'></td>";
		echo "<td>" . $instalacion->precio . "</td>";
		
		// Los botones "Modificar" y "Borrar" solo se muestran si hay una sesión iniciada
		if ($this->seguridad->haySesionIniciada()) {
			echo "<td><a href='index.php?action=formularioModificarInstalacion&idInstalacion=" . $instalacion->idInstalacion . "'>Modificar</a></td>";
			echo "<td><a href='index.php?action=borrarInstalaciones&idInstalacion=" . $instalacion->idInstalacion . "'>Borrar Instalacion</a></td>";
								
		}
		echo "</tr>";
	}
	echo "</table>";
} else {
	// La consulta no contiene registros
	echo "No se encontraron datos";
}


	echo "<p><a href='index.php?action=formularioInsertarInstalaciones'>Nueva Instalacion</a></p>";