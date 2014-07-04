<?php
/*********************************************
	PAGINA PARA EL MANEJO DE BUSQUEDAS
*********************************************/
session_start();
include("ControlaBD.php");
include("util.php");
$con   = new ControlaBD();
$idcon = $con->conectarSBD();
$sel_bd= $con->select_BD("tf_comercializacion");

$rif = $_SESSION['rif'];
$nro = $_POST['nro'];
$boton = $_POST['boton'];
$ced = $_POST['Nac'].$_POST['ced'];

if ($_SESSION["tusu"] == 10){// si usuario es igual a internet busca solo por el rif correspondiente
	if ($boton == '<<'){//primero
		$result2= $con->ejecutar("SELECT id FROM acreditado where rif = '$rif' and estatus <> 0 ORDER BY id",$idcon);
		$row2 = mysql_fetch_array($result2);
		$nro = $row2['id'];	
	}elseif ($boton == '>>'){//ultimo
		$result2= $con->ejecutar("SELECT id FROM acreditado where rif = '$rif' and estatus <> 0 ORDER BY id DESC",$idcon);
		$row2 = mysql_fetch_array($result2);
		$nro = $row2['id'];		
	}elseif ($boton == '>'){//siguiente
		$result2= $con->ejecutar("SELECT id FROM acreditado where rif = '$rif' and id > $nro and estatus <> 0",$idcon);
		if ($row2 = mysql_fetch_array($result2)){
			$nro = $row2['id'];	}
	}elseif ($boton == '<'){//anterior
		$result2= $con->ejecutar("SELECT id FROM acreditado where rif = '$rif' and id < $nro and estatus <> 0  ORDER BY id DESC",$idcon);
		if ($row2 = mysql_fetch_array($result2)){
			$nro = $row2['id'];	}
	}elseif ($boton == 'Eliminar'){// ELimina Registros
		$result2= $con->ejecutar("DELETE FROM acreditado where id = $nro and estatus <> 0",$idcon);
		if (!$result2) {
			die('Error al Eliminar:'. mysql_error());
		}else{
		$result2= $con->ejecutar("SELECT id FROM acreditado where rif = '$rif' and estatus <> 0 ORDER BY id",$idcon);
		if ($row2 = mysql_fetch_array($result2)){
			$nro = $row2['id'];	}}
	}
	js_redireccion("consultacre.php?nro=".$nro);exit;
}else{// si usuario es distinto a internet busca todo
	if ($boton == '<<'){
		$result2= $con->ejecutar("SELECT id FROM acreditado where estatus <> 0 ORDER BY id",$idcon);
		$row2 = mysql_fetch_array($result2);
		$nro = $row2['id'];	
	}elseif ($boton == '>>'){
		$result2= $con->ejecutar("SELECT id FROM acreditado where estatus <> 0 ORDER BY id DESC",$idcon);
		$row2 = mysql_fetch_array($result2);
		$nro = $row2['id'];		
	}elseif ($boton == '>'){
		$result2= $con->ejecutar("SELECT id FROM acreditado where id > $nro and estatus <> 0",$idcon);
		if ($row2 = mysql_fetch_array($result2)){
			$nro = $row2['id'];	}
	}elseif ($boton == '<'){
		$result2= $con->ejecutar("SELECT id FROM acreditado where id < $nro and estatus <> 0  ORDER BY id DESC",$idcon);
		if ($row2 = mysql_fetch_array($result2)){
			$nro = $row2['id'];	}
	}elseif ($boton == 'Buscar'){
		$result2= $con->ejecutar("SELECT id FROM acreditado where cedula = '$ced' and estatus <> 0",$idcon);
		if ($row2 = mysql_fetch_array($result2)){
			$nro = $row2['id'];	}
	}
	js_redireccion("consultacre2.php?nro=".$nro);exit;
}

?>