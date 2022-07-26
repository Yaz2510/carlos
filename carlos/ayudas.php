<?php
error_reporting(1);
session_start();

 
if ( !(isset($_SESSION["Campo0"])) ) {
	header("location: index.php");
}
require("Conexion.php");
$objeto = new Conexion();

if ( isset($_POST['btnAgregar']) ){
	 
	$Tabla = 'ayudas';
	$pass = utf8_decode( htmlspecialchars( addslashes( $_POST['inpConAg'] ) ) );
	
	$cantidad	=	abs($_POST['inpCantidad']);
	$c_campos	=	"";
	$c_tipo		=	"";
	for($f1=1;$f1<=$cantidad;$f1++){
		$c_campos	.=	trim($_POST['inpCampos'.$f1])."|";
		$c_tipo		.=	trim($_POST['inpTipo'.$f1])."|";
	}
 
	$c_campos 	= substr($c_campos, 0, -1);
	$c_tipo 	= substr($c_tipo, 0, -1);
	
	$Datos = array (
		0 => utf8_decode( htmlspecialchars( addslashes( $_POST['inpAyuda'] ) ) ),
		1 => utf8_decode( htmlspecialchars( addslashes( $_POST['inpDep'] ) ) ),
		2 => utf8_decode( htmlspecialchars( addslashes( $_POST['inpCantidad'] ) ) ),
		
		3 => utf8_decode( htmlspecialchars( addslashes( $c_campos ) ) ),
		4 => utf8_decode( htmlspecialchars( addslashes( $c_tipo ) ) ),
		5 => utf8_decode( htmlspecialchars( addslashes( abs($_SESSION['usuario_id']) ) ) ),
		6 => utf8_decode( htmlspecialchars( addslashes( 'Activo' ) ) ),
	);
	$Campos = array (
		0 => "ayuda",
		1 => "idDep",
		2 => "cantidad", 
		3 => "campos",
		4 => "tipo",
		5 => "admin",
		6 => "estatus",
	);
	$objeto->Insertar($Tabla, $Datos, $Campos);
	echo '<script type="text/javascript">alert("Agregado correctamente")</script>';
	header("Location: ayudas.php");
}elseif ( isset($_GET['idDesactivar']) )
{
	$Tabla = 'ayudas';
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
	echo '<script type="text/javascript">alert("Ayuda desactivada correctamente")</script>';
	header("Location: ayudas.php");
}elseif ( isset($_GET['idActivar']) )
{
	$Tabla = 'ayudas';
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
	header("Location: ayudas.php");
}elseif ( isset($_GET["idModificar"]) )
{
	$Instruccion =  "select * from ayudas where id = '".$_GET["idModificar"]."'";
	$editar = $objeto->Buscar_Instruccion($Instruccion);
}

if ( isset($_POST['btnModificar']) )
{
	 
	$Tabla = 'ayudas';
	$Datos = array (
		0 => utf8_decode( htmlspecialchars( addslashes( $_POST['inpAyuda'] ) ) ),
		1 => utf8_decode( htmlspecialchars( addslashes( $_POST['inpCantidad'] ) ) ),
		2 => utf8_decode( htmlspecialchars( addslashes( $_POST['inpCampos'] ) ) ),
		3 => utf8_decode( htmlspecialchars( addslashes( $_POST['inpTipo'] ) ) ),
		4 => utf8_decode( htmlspecialchars( addslashes( $_POST['inpAdmin'] ) ) ),
		5 => utf8_decode( htmlspecialchars( addslashes( $_POST['estado'] ) ) ),
	);
	$Campos = array (
		0 => "ayuda",
		1 => "cantidad",
		2 => "campos",
		3 => "tipo",
		4 => "admin",
		5 => "estatus",
	);
	
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
	header("Location: ayudas.php");
}


$query_departamento =  "select * from dep order by departamento";	
$rs_departamento = $objeto->Buscar_Instruccion($query_departamento);
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
							<li><a href="ayudas.php" >Agregar Ayudas</a></li>
							<li class="dropdown">      
                                    <a href="#" class="dropbtn active" >Agregar Beneficiario</a>
                                    <div class="dropdown-content">
                                        <a href="beneficiarios_agregar.php"> Agregar </a>
                                        <a href="beneficiarios_consultar.php"> Cosnsultar </a>
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
										<h2>Registrar Ayudas</h2>

									</section>
                                    <section align="center">
                                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                            <div class="row gtr-uniform">

                                            	<div class="col-6">
                                                    <input type="text" name="inpAyuda" id="inpAyuda" value="<?php echo $_POST["inpAyuda"]; ?>" onkeypress="return longitud(this, 100) && validar(event,'ambos','áéíóú ')" placeholder="Nombre de la ayuda" />
                                                </div>

                                                <div class="col-6">
                                                    <select name="inpDep" id="inpDep" >
                                                        <option value="">- Departamento -</option>
                                                        <?php 
														
														foreach ($rs_departamento as $rs_departamento_row){ 
														   
														?>
                                                        	<option value="<?php echo $rs_departamento_row[0]; ?>" <?php if($_POST["inpDep"] == $rs_departamento_row[0]) { echo "selected"; } ?>><?php echo $rs_departamento_row[1]; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="col-12">
                                                <select  name="inpCantidad" id="inpCantidad" onChange="submit()">
                                                <option value="0">- Seleccione -</option>
                                                <?php 
												for($f1=1;$f1<=10;$f1++){
													if($f1 == abs($_POST['inpCantidad'])){$SelCantidad="selected";}else{$SelCantidad="";}
													echo '<option '.$SelCantidad.' value="'.$f1.'">'.$f1.'</option>';
												}
												?>
                                                </select>
                                                     
                                                </div>
												<?php if (isset($_POST["inpCantidad"])): ?>
													<?php for ($i=1; $i <= (int)$_POST["inpCantidad"]; $i++): ?>
														<div class="col-6">
		                                                    <input type="text" name="<?php echo "inpCampos".$i; ?>" id="<?php echo "inpCampos".$i; ?>" placeholder="<?php echo "Nombre de campo".$i; ?>" onkeypress="return longitud(this, 100) && validar(event,'ambos','áéíóú ')" />
		                                                </div>
														<div class="col-6">
															<select id="<?php echo "inpTipo".$i; ?>" name="<?php echo "inpTipo".$i; ?>">
																<option value="">- Tipo -</option>
																<option value="Letra y numero">- Letra y numero -</option>
																<option value="Textos">- Textos -</option>
																<option value="Numeros">- Numeros -</option>
																<option value="Imagen">- Imagen -</option>
															</select>
														</div>
													<?php endfor; ?>
												<?php endif; ?>
                                                
                                                
                                                <!--  <div class="row gtr-uniform">-->
                                                	
												<?php //if ($_SESSION["Campo0"] == "1"):
												
												if ( isset($_SESSION['Campo0']) ):
												 ?>
                                                    <div class="col-12">
                                                    <input  name="btnAgregar" type="submit" value="Agregar" class="primary" onclick="return guardar()" />
                                                    </div>
                                                    <?php if (!(isset($_POST["btnContinuar"]))): ?>
                                                    <div class="col-6" style="display:none">
		                                                <input name="btnContinuar" type="submit" value="Continuar" class="" onclick="return continuar()" />
		                                            </div>
                                                    
                                                <?php endif; ?>
												<?php endif; ?>
                                               <!-- </div>-->
                                            </div>
                                            
                                          
                                        </form>
                                    </section>
                                    <form method="post" action="ayudas.php"> 
                                        
                                    </form>
                                    
										<?php
										
										
                                        if ( isset($_POST['btnBuscar']) ){
											$ayuda	=	$_POST['inpBus1'];
											$estado	=	$_POST['inpBus2'];
											
											if($ayuda != ""){
												$FilNombre=" and concat(a.ayuda) like '".$ayuda."%'";
											}
											if($estado != ""){
												$FilEstado="and a.estatus='".$estado."'";
											}else{
												$FilEstado="";
											}
											$Instruccion =  "select a.*,d.departamento,ad.usuarios 
											from ayudas a,dep d , admin ad
											where
											a.idDep=d.id
											and a.admin=ad.id
											".$FilNombre." ".$FilEstado;
										}else{
											$Instruccion =  "select a.*,d.departamento ,ad.usuarios 
											from ayudas a,dep d , admin ad
											where 
											a.idDep=d.id 
											and a.admin=ad.id";	
										}
										$DatosBuscados = $objeto->Buscar_Instruccion($Instruccion);
                                        ?>

												<section align="center">
										<h2>Buscar</h2>
										<form method="post" action="ayudas.php">
											<div class="row gtr-uniform">			
                                                <div class="col-5 col-12-xsmall">
													<input type="text" name="inpBus1" id="inpBus1" placeholder="Ayuda" value="<?php echo $_POST["inpBus1"]; ?>" />
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
    														<td>Nombre Ayuda</td>
                                                            <td>Agregado Por</td>
                                                            <td>Departamento</td>
															<td>Estatus</td>
                                                            <td>Acciones</td>
    													</tr>
    												</thead>
    												<tbody>
														<?php foreach ($DatosBuscados as $renglon){ ?>
											            <tr>
															<td><?php echo $renglon[0]; ?></td>
											              	<td><?php echo $renglon[1]; ?></td>
															<td><?php echo $renglon["usuarios"]; ?></td>
											              	<td><?php echo $renglon["departamento"]; ?></td>
															<td><?php echo $renglon[7]; ?></td>
											              	<td>
                                                            
											              	 
															<?php if ( $renglon[7] == "Activo" and $renglon[0] != "1" ){ ?>
																<button type="button" style="background-color:#F00 !important; color:#FFF !important;"><a href="ayudas.php?idDesactivar=<?php echo $renglon[0]; ?>">Desactivar</a></button>
															<?php } ?>
															<?php if ( $renglon[7] != "Activo" ){ ?>
																<button type="button"  style="background-color:#008040 !important; color:#FFF !important;"><a href="ayudas.php?idActivar=<?php echo $renglon[0]; ?>">Activar</a></button>
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
	 nom = document.getElementById('inpAyuda')
	 ape = document.getElementById('inpDep')
	 use = document.getElementById('inpCantidad')
	// con = document.getElementById('inpConAg')

	 if ( sinEspacios(nom.value) == "" ) {
	 	nom.focus()
		alert("Llene el campo de ayuda.")
		return false
	 }
	 else if ( sinEspacios(ape.value) == "" ) {
	 	ape.focus()
		alert("Seleccione el departamento.")
		return false
	 }
	 else if ( sinEspacios(use.value) == "" ) {
	 	use.focus()
		alert("Seleccione la cantidad.")
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
