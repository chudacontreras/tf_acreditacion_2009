<?php
include("util.php");
session_start();
if (array_key_exists('login',$_SESSION)){

/*************************************************
       GENERAR ACREDITACIONES ROTATIVAS
*************************************************/
// funcion para generar el codigo de barras
function randomText($length) {
    $pattern = "1234567890";
    for($i=0;$i<$length;$i++) {
      $key .= $pattern{rand(0,35)};
    }
    return $key;
}

include("ControlaBD.php");
	$rif=$_SESSION['rif'];
	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");
	
// Consulto cantaacredita y traigo todas las rotativas	
$result= $con->ejecutar("SELECT * FROM cantacredita where tipoacre >= 100" ,$idcon);
while ($row=mysql_fetch_array($result)) {
	$result10= $con->ejecutar("SELECT rif FROM contrato where numero = '".$row['nrocontrato']."'" ,$idcon);
	$row10=mysql_fetch_array($result10);
	$rif = $row10['rif']; 
	// consulto en acrrot para saber cuantas estan registradas
	if ($result2= $con->ejecutar("SELECT * FROM acrrot where contrato = '".$row['nrocontrato']."' and tipacr = ".$row['tipoacre']." ORDER BY cod_v desc" ,$idcon)){
		$cant = mysql_num_rows($result2);
		$row2=mysql_fetch_array($result2);
		$cod_v = $row2['cod_v'];
		$cod_id = $row2['id'];	
	}else{
	    $cant = 0;
		$cod_v = 0;
		$cod_id = 0;
	}	
	echo $cant." < ".$row['cant']."<br>";
	if ($cant < $row['cant']){ // comparo en numero de registradas contra la cantidad a registrar
		$x = $row['cant'] - $cant;
		for ($i = 0; $i < $x; $i++){
			$cod_id++; $cod_v++;

		$f = strlen($cod_id);
		$c_id = $cod_id;
		while ($f<5)
		{
		  $c_id = "0".$c_id;
		  $f++;
		} 
		
		$g = strlen($cod_v);
		$c_v = $cod_v;
		while ($g<3)
		{
		  $c_v = "0".$c_v;
		  $g++;
		}		
	   	
		$cod_b = 'R'.$c_id.rand(100, 500).$c_v;
		$contrato = $row['nrocontrato'];
		$tipo = $row['tipoacre'];	
		//echo "insert into acrrot (cod_b, cod_v, contrato, tipacr, estatus) values ('$cod_b', $cod_v, '$contrato', $tipo, 0)<br><br>";			
		$guarda = $con->ejecutar("insert into acrrot (cod_b, cod_v, contrato, tipacr, estatus,rif) values ('$cod_b', $cod_v, '$contrato', $tipo, 1, '$rif')" ,$idcon);	
		}// fin del for
	}// fin de la condicion ($cant < $row['cant'])
	}// fin del while

	js_redireccion("error.php?msn=Acreditaciones Rotativas creadas con �xito....");

}else
{
    Header ("location: index.php"); 
}
?>
