<script language="JavaScript">

function doPrint(theForm) {
var i;
for(i=0; i<theForm.elements.length ; i++) {
// Agregar en esta lista de condiciones
// todos aquellos tipos de Input que se quieren ocultar
if( (theForm.elements[i].type == "submit") ||
(theForm.elements[i].type == "reset") ||
(theForm.elements[i].type == "button") )
theForm.elements[i].style.visibility = 'hidden';
}
window.print();

for(i=0; i<theForm.elements.length ; i++) {
if( (theForm.elements[i].type == "submit") ||
(theForm.elements[i].type == "reset") ||
(theForm.elements[i].type == "button") )
theForm.elements[i].style.visibility = 'visible';
}
} 
</script>
<?php
require("php-barcode.php");
/*
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

*/
	include("ControlaBD.php");

	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::.Imprimir.::</title>
<meta name="description" content="CAPTCHA con PHP: ejemplo para demostrar la creacion de Captcha con PHP." />
<link href="styles.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="window.print()">

<?PHP
	    $cantidad=$_GET['cant'];
	    $result= $con->ejecutar("SELECT * FROM abono where status='0' LIMIT $cantidad " ,$idcon);
		$num_rows=mysql_num_rows($result);
		if ($num_rows <= 0){
			js_redireccion("error.php?msn=No se Encontraron Registros.....");exit;
		}elseif ($num_rows < $cantidad){
			js_redireccion("error.php?msn=Solo hay $num_rows Abono Registrado.....");exit;
		}else{	
	while ($row=mysql_fetch_array($result)) {
	   $strStatus = "UPDATE abono SET status='1' WHERE codigo='".$row['codigo']."'";
	   $resimpre = $con->ejecutar($strStatus,$idcon);
	   $strAcceso = "INSERT INTO accesoabono (codigo) VALUES('".$row['codigo']."')";
	   $resulAcceso = $con->ejecutar($strAcceso,$idcon);
?>
<div align="center" style="width:85mm; height:52mm; font-family:Arial, Helvetica, sans-serif; font-size:9px; background: url(Imagenes/Abono.jpg); vertical-align:middle">
		  <!--img src='Imagienes/acre1.gif'--><br>
		  <font style="font-size:15px; font-style:normal; font-family:Arial, Helvetica, sans-serif"><strong>
		  <i>Abono</i></strong></font><br>
		  <font style="font-size:10px; font-style:normal; font-family:Arial, Helvetica, sans-serif"><strong>
		  XXXV Feria Internacional de Barquisimeto</strong></font><br><br>
		  <table width="100%" border="0">
		  <tr>
		  <td width="50%" align="justify">
		  <font style="font-size:8px; font-style:normal; font-family:Arial, Helvetica, sans-serif">
		  * Valido para una sola entrada por d&iacute;a desde el 13 al 23 de Septiembre de 2.007<br><br>
		  * CORTUBAR no se hace responsable en caso de extravio<br><br>
		  * Arena Plaza Ferial, Av. Libertador, Barquisimeto - Lara</font>
		  </td>
		  <td align="center">
		  <?PHP ///
		  	echo "<font size='2'><strong>Bs. 180.000</strong></font>";
			echo "<br><br><img src='barcode.php?code=".$row['codigo']."' width='120' height='50'><br>";
			echo "<font size='1'><strong>".$row['id'].'</strong></font>';
			//echo "<img src='Imagenes/avedt.gif'<br>";
		  ?>
		  </td>
		  </tr>
		  </table>
	</div>

<?PHP
		}
		}
?>
</body>
</html>

