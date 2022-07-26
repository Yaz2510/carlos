<?php
error_reporting(1);
session_start();
//echo password_hash("123", PASSWORD_DEFAULT, array("cost"=>15));
if ( isset($_SESSION["Campo0"]) ) {
	header("location: usuarios.php");
}
require("Conexion.php");
$objeto = new Conexion();

if ( isset($_POST["btnIniciar"]) ) {
	$Tabla[0] = "admin";

	$Usuario = utf8_decode( htmlspecialchars( addslashes( $_POST['user'] ) ) );
	$Contrasena = utf8_decode( htmlspecialchars( addslashes( $_POST['pass'] ) ) );

	$CampoUsuario[0] = "usuarios";
	$CampoContrasena[0] = "contrasena";

	$TotalCampos[0] = 4;

	$CampoEstatus[0] = "estatus";
	$ValorActivo[0] = "Activo";
	$Resultado = "";
	for ($i=0; $i < count($Tabla); $i++)
	{
		$Instruccion[$i] = "SELECT * FROM ".$Tabla[$i]." WHERE ".$CampoUsuario[$i]." = '".$Usuario."' AND ".$CampoEstatus[$i]." = '".$ValorActivo[$i]."'";

		$var = $objeto->Buscar_Instruccion($Instruccion[$i]);

		if ( count($var) != 0 )
		{
			
			foreach ($var as $key )
			{
				if( password_verify( $Contrasena, $key[ $CampoContrasena[$i] ] ) )
				{
					
					$_SESSION['usuario_id']=$key[0];
					
					$_SESSION["Privilegio"] = $Tabla[$i];
					for ($y=0; $y < $TotalCampos[$i]; $y++)
					{
						$Campo = "Campo".strval($y);
						$_SESSION[$Campo] = $key[$y];
					}
					$Resultado = "Correcto";
					$i = count($Tabla);
				}
				else
				{
					$Resultado = "Contraseña";
					$i = count($Tabla);
				}
			}
		}
		else
		{
			$Instruccion[$i] = "SELECT * FROM ".$Tabla[$i]." WHERE ".$CampoUsuario[$i]." = '".$Usuario."'";

			$var = $objeto->Buscar_Instruccion($Instruccion[$i]);
			if ( count($var) != 0 )
			{
			 
				$Resultado = "Inactivo";
				$i = count($Tabla);
			}
		}
	}
	if ( $Resultado == "Inactivo" ) {
		echo '<script type="text/javascript">alert("Usuario inactivo")</script>';
	}
	elseif ( $Resultado == "Contraseña" ) {
		echo '<script type="text/javascript">alert("Contraseña incorrecta")</script>';
	}
	elseif ( $Resultado == "Correcto" ) {
		header("Location: usuarios.php");
	}
	else {
		echo '<script type="text/javascript">alert("Usuario sin registrar")</script>';
	}
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
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header" class="alt">
						<span class="logo"><img src="images/logo.svg" alt="" /></span>
						<h1>Presidencia de Nava</h1>
					</header>
					<section align="center">
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<div class="row gtr-uniform">
								<div class="col-6">
									<input type="text" name="user" id="user" placeholder="usuario" onkeypress="return longitud(this, 100) && validar(event,'ambos','áéíóú ')" />
								</div>
								<div class="col-6">
									<input type="password" name="pass" id="pass" placeholder="Contraseña" onkeypress="return longitud(this, 100) && validar(event,'ambos','áéíóú ')" />
								</div>

								<div class="col-12">
									<input name="btnIniciar" type="submit" value="Iniciar" class="primary" onclick="return inicio()" />
								</div>

							</div>
						</form>
					</section>

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
	const inicio = () => {
		user = document.getElementById('user')
		pass = document.getElementById('pass')
		if ( sinEspacios(user.value) == "" )
		{
			alert("Llene el campo de usuario")
			user.focus()
			return false;
		}
		else if ( sinEspacios(pass.value) == "" )
		{
			alert("Llene el campo de contraseña")
			pass.focus()
			return false;
		}
	}
</script>
