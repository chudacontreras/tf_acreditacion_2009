<?php
	include("ControlaBD.php");

	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CAPTCHA con PHP</title>
<meta name="description" content="CAPTCHA con PHP: ejemplo para demostrar la creacion de Captcha con PHP." />
<link href="styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<?PHP
	$result= $con->ejecutar("SELECT * FROM acreditado" ,$idcon);
	while ($row=mysql_fetch_array($result)) {
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">
    <div style="width:54mm; height:86mm; background:#CCCCCC">
		  <img src=<?php echo $row['foto']  ?> width="100" height="100" vspace="10" hspace="50"><br>
		  <?PHP
		    echo $row['nombre'].'<br>'; 
			echo $row['cedula'].'<br>';
			echo '<font '.$row['cod_b'].'<br>';
//////codigo de barras			
require("php-barcode.php");

function getvar($name){
    global $_GET, $_POST;
    if (isset($_GET[$name])) return $_GET[$name];
    else if (isset($_POST[$name])) return $_POST[$name];
    else return false;
}

if (get_magic_quotes_gpc()){
    $code=stripslashes(getvar('code'));
} else {
    $code=getvar('code');
}
if (!$code) $code='b';

barcode_print($code,getvar('encoding'),getvar('scale'),getvar('mode'));	

///// hasta aqui codigo de barras		
		  ?>
	</div>
	</td>
  </tr>

</table>
<?PHP
	}
?>
</body>
</html>
