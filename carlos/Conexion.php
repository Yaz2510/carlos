<?PHP
class Conexion{

	public function getConection ()	{
			$usr  = "root";         //Usuario
			$pwd  = "";      //Contraseña
			$host = "localhost";    //Host
			$db   = "nava";     //Base de Datos

	     	 try {
			       $conexion = new PDO("mysql:host=$host;dbname=$db;",$usr,$pwd);
		           }
		        catch(PDOException $e){
					try {
						$usr  = "";         //Usuario
						$pwd  = "";      //Contraseña
						$host = "";    //Host
						$db   = "";     //Base de Datos

						$conexion = new PDO("mysql:host=$host;dbname=$db;",$usr,$pwd);
					}
					catch(PDOException $e){
					    echo "Failed to get DB handle: " . $e->getMessage();
						exit;
						}
	            }
	        return $conexion;

	}

	public function Buscar_Instruccion($consulta_sql)
	{
			# code...
			$conexion = $this->getConection();
	        $rows = array();
			$query=$conexion->prepare($consulta_sql);
			if(!$query)
			{
	         	return "Error al mostrar";
	        }
			else
			{
	        	$query->execute();
	        	while ($result = $query->fetch())
				{
	            	$rows[] = $result;
	          	}
	            return $rows;
	        }
	}

	public function Insertar($tabla, $datos, $campos)
	{
		$conexion = $this->getConection();
		for ($i=0; $i < count($datos); $i++) {
        	if ($datos[$i] != '') {
				if ( $i == 0 ) {
	        		$dato = "'".$datos[$i]."'";
	        	}
				else {
					$dato .= ", '".$datos[$i]."'";
				}
				if ( $i == 0 ) {
	        		$campo = $campos[$i];
	        	}
				else {
					$campo .= ", ".$campos[$i];
				}
        	}
        }
		$sql = "INSERT INTO ".$tabla." (".$campo.") VALUES(".$dato.")";
        $query = $conexion->prepare($sql);
		$x=0;
		foreach($datos as $elemento)
		{
           	$query->bindValue(':'.$x,$elemento);
			$x++;
		}
        if(!$query)
		{
  			return null;
        }
		else
		{
        	$query->execute();
			return $conexion->lastInsertId();
        }
	}

}


?>
