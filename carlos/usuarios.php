<?php
error_reporting(1);
session_start();

if ( !(isset($_SESSION["Campo0"])) ) {
	header("location: index.php");
}
require("Conexion.php");
$objeto = new Conexion();

if ( isset($_POST['btnAgregar']) ){
	 
	$Tabla = 'admin';
	$pass = utf8_decode( htmlspecialchars( addslashes( $_POST['inpConAg'] ) ) );
	$Datos = array (
		0 => utf8_decode( htmlspecialchars( addslashes( $_POST['inpNomAg'] ) ) ),
		1 => utf8_decode( htmlspecialchars( addslashes( $_POST['inpApeAg'] ) ) ),
		2 => utf8_decode( htmlspecialchars( addslashes( $_POST['inpUseAg'] ) ) ),
		3 => password_hash($pass, PASSWORD_DEFAULT, array("cost"=>15)),
	);
	$Campos = array (
		0 => "nombres",
		1 => "apellidos",
		2 => "usuarios",
		3 => "contrasena",
	);
	$objeto->Insertar($Tabla, $Datos, $Campos);
	echo '<script type="text/javascript">alert("Agregado correctamente")</script>';
	header("Location: usuarios.php");
}elseif ( isset($_GET['idDesactivar']) )
{
	$Tabla = 'admin';
	$Datos = array (
		0 => 'Inactivo',
	);
	$Campos = array (
		0 => "estatus",
	);
	$Where = array(
		0 => 'id = "'.$_GET['idDesactivar'].'"',
	);
	$Cambios = '';
	for ($i=0; $i < count($Datos); $i++) {
		if ( $Cambios == '' && $Datos[$i] != '' ) {
			$Cambios .= $Campos[$i]." = '".$Datos[$i]."'";
		}
		elseif ( $Datos[$i] != '' ) {
			$Cambios .= ", ".$Campos[$i]." = '".$Datos[$i]."'";
		}
	}
	$Condicion = '';
	for ($i=0; $i < count($Where); $i++) {
		if ( $i == 0 ) {
			$Condicion .= $Where[$i];
		}
		else {
			$Condicion .= " and ".$Where[$i];
		}
	}
	$Instruccion = "UPDATE $Tabla SET $Cambios where $Condicion";
	$objeto->Buscar_Instruccion($Instruccion);
	echo '<script type="text/javascript">alert("Usuario desactivado correctamente")</script>';
	header("Location: usuarios.php");
}elseif ( isset($_GET['idActivar']) )
{
	$Tabla = 'admin';
	$Datos = array (
		0 => 'Activo',
	);
	$Campos = array (
		0 => "estatus",
	);
	$Where = array(
		0 => 'id = "'.$_GET['idActivar'].'"',
	);
	$Cambios = '';
	for ($i=0; $i < count($Datos); $i++) {
		if ( $Cambios == '' && $Datos[$i] != '' ) {
			$Cambios .= $Campos[$i]." = '".$Datos[$i]."'";
		}
		elseif ( $Datos[$i] != '' ) {
			$Cambios .= ", ".$Campos[$i]." = '".$Datos[$i]."'";
		}
	}
	$Condicion = '';
	for ($i=0; $i < count($Where); $i++) {
		if ( $i == 0 ) {
			$Condicion .= $Where[$i];
		}
		else {
			$Condicion .= " and ".$Where[$i];
		}
	}
	$Instruccion = "UPDATE $Tabla SET $Cambios where $Condicion";
	$objeto->Buscar_Instruccion($Instruccion);
	echo '<script type="text/javascript">alert("Usuario activado correctamente")</script>';
	header("Location: usuarios.php");
}elseif ( isset($_GET["idModificar"]) )
{
	$Instruccion =  "select * from admin where id = '".$_GET["idModificar"]."'";
	$editar = $objeto->Buscar_Instruccion($Instruccion);
}

if ( isset($_POST['btnModificar']) )
{
	 
	$Tabla = 'admin';
	$Datos = array (
		0 => utf8_decode( htmlspecialchars( addslashes( $_POST['inpNomEd'] ) ) ),
		1 => utf8_decode( htmlspecialchars( addslashes( $_POST['inpApeEd'] ) ) ),
		2 => utf8_decode( htmlspecialchars( addslashes( $_POST['inpUseEd'] ) ) ),
		3 => utf8_decode( htmlspecialchars( addslashes( $_POST['estado'] ) ) ),
	);
	$Campos = array (
		0 => "nombres",
		1 => "apellidos",
		2 => "usuarios",
		3 => "estatus",
	);
	if ($_POST['inpConEd'] != "") {
		$pass = utf8_decode( htmlspecialchars( addslashes( $_POST['inpConEd'] ) ) );
		$Datos[] = password_hash($pass, PASSWORD_DEFAULT, array("cost"=>15));
		$Campos[] = "contrasena";
	}
	$Where = array(
		0 => 'id = "'.$_POST['inpIdEd'].'"',
	);
	$Cambios = '';
	for ($i=0; $i < count($Datos); $i++) {
		if ( $Cambios == '' && $Datos[$i] != '' ) {
			$Cambios .= $Campos[$i]." = '".$Datos[$i]."'";
		}
		elseif ( $Datos[$i] != '' ) {
			$Cambios .= ", ".$Campos[$i]." = '".$Datos[$i]."'";
		}
	}
	$Condicion = '';
	for ($i=0; $i < count($Where); $i++) {
		if ( $i == 0 ) {
			$Condicion .= $Where[$i];
		}
		else {
			$Condicion .= " and ".$Where[$i];
		}
	}
	$Instruccion = "UPDATE $Tabla SET $Cambios where $Condicion";
	$objeto->Buscar_Instruccion($Instruccion);

	echo '<script type="text/javascript">alert("Modificado correctamente")</script>';
	header("Location: usuarios.php");
}


 ?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Nava</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<style>
/* Style The Dropdown Button */
.dropbtn {
    background-color: rgba(247, 247, 247, 0.95);
    color: #636363 !important;
    
    font-size: 0.9em;
    border: none;
    cursor: pointer;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
    position: relative;
    display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
}

/* Links inside the dropdown */
.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #f1f1f1}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {
    display: block;
}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown:hover .dropbtn {
    background-color: #3e8e41;
}
</style>
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

                <!-- Nav -->
					<nav id="nav">
						<ul>
                            <li><a href="usuarios.php" >Agregar Usuarios</a></li>
							<li><a href="departamentos.php" >Agregar Departamentos</a></li>
							<li><a href="apoyos.php" >Agregar Apoyos</a></li>
							<li><a href="apoyos.php" >Agregar Ayudas</a></li>
							<li class="dropdown">      
                                    <a href="#" class="dropbtn active" >Agregar Beneficiario</a>
                                    <div class="dropdown-content">
                                        <a href="beneficiarios_agregar.php"> Agregar </a>
                                        <a href="beneficiarios_consultar.php"> Consultar </a>
                                        <a href="#"> Link 3 </a>
                                    </div> 
                            </li>
							<li><a href="cerrar.php" >Cerrar sesión</a></li>
						</ul>
					</nav>

				<!-- Main -->
					<div id="main">

						<!-- Content -->
							<section id="content" class="main">

                                <?php if ( !isset($_GET["idModificar"]) ): 
								//if ( !(isset($_POST["btnAg"])) && !(isset($_POST["btnBu"])) && !(isset($_POST["btnAgregar"])) && !(isset($_POST["btnBuscar"])) && !(isset($_GET["idDesactivar"])) && !(isset($_GET["idActivar"])) && !(isset($_GET["idModificar"])) ): ?>
									<section align="center">
										<h2>Registrar Usuarios</h2>

									</section>
                                    <section align="center">
                                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                            <div class="row gtr-uniform">

												<div class="col-6">
                                                    <input type="text" name="inpNomAg" id="inpNomAg" placeholder="Nombres" onkeypress="return longitud(this, 100) && validar(event,'letras','áéíóú ')" />
                                                </div>
												<div class="col-6">
                                                    <input type="text" name="inpApeAg" id="inpApeAg" placeholder="Apellidos" onkeypress="return longitud(this, 100) && validar(event,'letras','áéíóú ')" />
                                                </div>

												<div class="col-6">
                                                    <input type="text" name="inpUseAg" id="inpUseAg" placeholder="Usuario" onkeypress="return longitud(this, 100) && validar(event,'ambos','')" />
                                                </div>
												<div class="col-6">
                                                    <input type="password" name="inpConAg" id="inpConAg" placeholder="Contraseña" onkeypress="return longitud(this, 100) && validar(event,'ambos','')" />
                                                </div>
                                                
                                                <!--  <div class="row gtr-uniform">-->
												<?php if ($_SESSION["Campo0"]): ?>
                                                    <div class="col-12">
                                                    <input  name="btnAgregar" type="submit" value="Agregar" class="primary" onclick="return guardar()" />
                                                    </div>
                                                <?php endif; ?>
                                               <!-- </div>-->
                                            </div>
                                            
                                          
                                        </form>
                                    </section>
                                    <form method="post" action="usuarios.php"> 
                                        
                                    </form>
                                    
										<?php
										
										
                                        if ( isset($_POST['btnBuscar']) ){
											$nombre	=	$_POST['inpBus1'];
											$estado	=	$_POST['inpBus2'];
											
											if($nombre != ""){
												$FilNombre=" and concat(nombres,' ',apellidos) like '".$nombre."%'";
											}
											if($estado != ""){
												$FilEstado="and estatus='".$estado."'";
											}else{
												$FilEstado="";
											}
											$Instruccion =  "select * from admin where nombres <> '' ".$FilNombre." ".$FilEstado;
										}else{
											$Instruccion =  "select * from admin where nombres <> '' ";	
										}
										 
										$DatosBuscados = $objeto->Buscar_Instruccion($Instruccion);
                                        ?>

												<section align="center">
										<h2>Buscar</h2>
										<form method="post" action="usuarios.php">
											<div class="row gtr-uniform">
                                                <div class="col-5 col-1-xsmall">
													<input type="text" name="inpBus1" id="inpBus1" placeholder="Nombre Apellidos" value="<?php echo $_POST["inpBus1"]; ?>" />
												</div>
                                                <div class="col-5">
													<select name="inpBus2" id="inpBus2">
														<option value="">- Ambos -</option>
														<option value="Activo" <?php if ($_POST["inpBus2"] == "Activo") { echo "selected"; } ?> >Activos</option>
														<option value="Inactivo" <?php if ($_POST["inpBus2"] == "Inactivo") { echo "selected"; } ?> >Inactivos</option>
													</select>
												</div>
                                                <div class="col-2">
                                                	 <ul class="actions">
													<input id="btnBuscar" name="btnBuscar" type="submit" value="Buscar" class="primary" />
												</ul>
												</div>
                                                
											</div>

                                            <br><br>
											
                                            <div class="table-wrapper">
    											<table class="alt">
    												<thead>
    													<tr>
    														<td>ID</td>
    														<td>Nombres</td>
                                                            <td>Apellidos</td>
                                                            <td>Usuario</td>
															<td>Estatus</td>
                                                            <td>Acciones</td>
    													</tr>
    												</thead>
    												<tbody>
														<?php foreach ($DatosBuscados as $renglon){ ?>
											            <tr>
															<td><?php echo $renglon[0]; ?></td>
											              	<td><?php echo $renglon[1]; ?></td>
															<td><?php echo $renglon[2]; ?></td>
											              	<td><?php echo $renglon[3]; ?></td>
															<td><?php echo $renglon[5]; ?></td>
											              	<td>
                                                            <button type="button"><a href="usuarios.php?idModificar=<?php echo $renglon[0]; ?>">Modificar</a></button>
											              	 
															<?php if ( $renglon[5] == "Activo" and $renglon[0] != "1" ){ ?>
																<button type="button" style="background-color:#F00 !important; color:#FFF !important;"><a href="usuarios.php?idDesactivar=<?php echo $renglon[0]; ?>">Desactivar</a></button>
															<?php } ?>
															<?php if ( $renglon[5] != "Activo" ){ ?>
																<button type="button"  style="background-color:#008040 !important; color:#FFF !important;"><a href="usuarios.php?idActivar=<?php echo $renglon[0]; ?>">Activar</a></button>
															<?php } ?>
															</td>
											            </tr>
											            <?php } ?>
    												</tbody>
    											</table>
											</div>
										</form>
									</section>

                                               
											</div>
										</form>
                                <?php  endif; ?>

                                <?php if ( isset($_POST["btnBu"]) || isset($_POST["btnBuscar"]) || isset($_GET["idDesactivar"]) || isset($_GET["idActivar"]) ): ?>
                                    
                                <?php endif; ?>

								<?php if ( isset($_GET["idModificar"]) ): ?>
                                    <section align="center">
                                        <h2>Modificar</h2>
                                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                            <div class="row gtr-uniform">

												<div class="col-12" style="display:none">
                                                    <input type="text" name="inpIdEd" id="inpIdEd" placeholder="Id" value="<?php echo $editar[0][0]; ?>" />
                                                </div>

												<div class="col-6">
                                                    <input type="text" name="inpNomEd" id="inpNomEd" placeholder="Nombres" onkeypress="return longitud(this, 100) && validar(event,'letras','áéíóú ')" value="<?php echo $editar[0][1]; ?>" />
                                                </div>
												<div class="col-6">
                                                    <input type="text" name="inpApeEd" id="inpApeEd" placeholder="Apellidos" onkeypress="return longitud(this, 100) && validar(event,'letras','áéíóú ')"
													value="<?php echo $editar[0][2]; ?>" />
                                                </div>

												<div class="col-6">
                                                    <input type="text" name="inpUseEd" id="inpUseEd" placeholder="Usuario" onkeypress="return longitud(this, 100) && validar(event,'ambos','')" value="<?php echo $editar[0][3]; ?>" />
                                                </div>
												<div class="col-6">
                                                    <input type="password" name="inpConEd" id="inpConEd" placeholder="Contraseña" onkeypress="return longitud(this, 100) && validar(event,'ambos','')"  />
                                                </div>
                                                <?php if(abs($_GET["idModificar"]) != 1){?>
                                                <div class="col-6">
                                                    <select name="estado" id="estado"> 
                                                    <option value="Activo"  <?php if(trim($editar[0][5]) == 'Activo'){echo "selected";} ?> >Activo</option>
                                                    <option value="Inactivo" <?php if(trim($editar[0][5]) == 'Inactivo'){echo "selected";} ?>>Inactivo</option>
                                                    </select>
                                                </div>
												<?php }else{
													?>
                                                    <input type="hidden" name="estado" id="estado"   value="Activo" />
                                                    <?php
													} ?>
                                                <div class="col-6">
                                                    <input name="btnModificar" type="submit" value="Modificar" class="primary" onclick="return modificar()" /> <input name="btnRegresar" type="submit" value="Regresar" class="primary"   />
                                                </div>
                                                
                                            </div>
                                        </form>
                                    </section>
                                <?php endif; ?>

                            </section>

					</div>

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>

 <script type="text/javascript">
 const validar = (e,tipo,otros) => {
	 key = e.keyCode || e.which;
	 tecla = String.fromCharCode(key).toLowerCase();
	 if ( tipo == "letras" )
	 {
		 letras = "áéíóúabcdefghijklmnñopqrstuvwxyz";
	 }
	 else if( tipo == "numeros" )
	 {
		 letras = "1234567890";
	 }
	 else if( tipo == "ambos" )
	 {
		 letras = "1234567890áéíóúabcdefghijklmnñopqrstuvwxyz";
	 }
	 letras = letras+otros

	 especiales = "8-37-39-46";

	 tecla_especial = false
	 for(let i in especiales){
		 if(key == especiales[i]){
			 tecla_especial = true;
			 break;
		 }
	 }

	 if(letras.indexOf(tecla)==-1 && !tecla_especial){
		 return false;
	 }
 }
 const longitud = (campo, longitudMaxima) => {
     try {
         if (campo.value.length > (longitudMaxima - 1))
             return false;
         else
             return true;
     } catch (e) {
         return false;
     }
 }
 const sinEspacios = (str) => {
     let cadena = '';
     let arrayString = str.split(' ');
     for (let i = 0; i < arrayString.length; i++)
     {
         if (arrayString[i] != "")
         {
             cadena += arrayString[i];
         }
     }
     return cadena;
 }
 const guardar = () => {
	 nom = document.getElementById('inpNomAg')
	 ape = document.getElementById('inpApeAg')
	 use = document.getElementById('inpUseAg')
	 con = document.getElementById('inpConAg')

	 if ( sinEspacios(nom.value) == "" ) {
	 	nom.focus()
		alert("Llene el campo de nombre.")
		return false
	 }
	 else if ( sinEspacios(ape.value) == "" ) {
	 	ape.focus()
		alert("Llene el campo de apellidos.")
		return false
	 }
	 else if ( sinEspacios(use.value) == "" ) {
	 	use.focus()
		alert("Llene el campo de usuario.")
		return false
	 }
	 else if ( sinEspacios(con.value) == "" ) {
	 	con.focus()
		alert("Llene el campo de contraseña.")
		return false
	 }
 }
 const modificar = () => {
	 nom = document.getElementById('inpNomEd')
	 ape = document.getElementById('inpApeEd')
	 use = document.getElementById('inpUseEd')
	 con = document.getElementById('inpConEd')

	 if ( sinEspacios(nom.value) == "" ) {
	 	nom.focus()
		alert("Llene el campo de nombre.")
		return false
	 }
	 else if ( sinEspacios(ape.value) == "" ) {
	 	ape.focus()
		alert("Llene el campo de apellidos.")
		return false
	 }
	 else if ( sinEspacios(use.value) == "" ) {
	 	use.focus()
		alert("Llene el campo de usuario.")
		return false
	 }
 }
 </script>
