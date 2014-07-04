<?php
session_start();
if (array_key_exists('login',$_SESSION)){

?>
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
<title>.::Imprimir Acreditaciones ::.</title>
<link href="styles.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="window.print()">

<?PHP
	//echo "SELECT * FROM acreditado where ".$campo."=".$valor;
	$result= $con->ejecutar("SELECT * FROM acreditado where ".$_SESSION['campo']."='".$_SESSION['valor']."' and estatus = 1" ,$idcon);
		$num_rows=mysql_num_rows($result);
		if ($num_rows <= 0){
			//js_redireccion("error.php?msn=No se Encontraron Registros.....");exit;
		}else{	
	while ($row=mysql_fetch_array($result)) {
		$result2= $con->ejecutar("SELECT * FROM tipacr WHERE codtacr = ".$row['tipacr'] ,$idcon);
		$row2=mysql_fetch_array($result2);
   /*INICIO: ACTUALIZAR LA TABLA acreditado*/
       $hoy = date("Y-m-d");
       $strStatus = "UPDATE acreditado SET estatus='2',fecha_i='$hoy' WHERE ".$_SESSION['campo']."='".$_SESSION['valor']."'";
	   $resimpre = $con->ejecutar($strStatus,$idcon);
   /*FIN ACTUALIZAR LA TABLA acreditado*/
   
   /*INICIO: INSERTA EN LA TABLA accesoacr*/
       $desde=$row2[desde];
	   $hasta=$row2[hasta];
	   $codigoa=$row[cod_b];
	   $strAcceso = "INSERT INTO accesoacr (codigo,desde,hasta) VALUES('$codigoa','$desde','$hasta')";
	   $resulAcceso = $con->ejecutar($strAcceso,$idcon);
   /*FIN INSERTA EN LA TABLA accesoacr*/
	
?>

	<div align="center" style="width:50mm; height:85mm; font-family:Arial, Helvetica, sans-serif; font-size:9px; background: url(<?PHP echo $_SESSION['color']; ?>); vertical-align:middle">
		  <!--img src='Imagenes/acre1.gif'--><br><br><br><br>
		  <img src=<?php echo $row['foto']  ?> width="100" height="100" vspace="10" hspace="50" border="1"><br>
		  <?PHP ///
		    echo "<strong>".$row['nombre'].'</strong><br>';
			echo "<strong>".$row['cedula'] .'</strong><br>';
			echo "<font size='2'><strong>".$row2['descrip'].'</strong></font><br><br>';
	        echo "<img src='barcode.php?code=".$row['cod_b']."' width='120' height='50'>";
			//echo "<img src='Imagenes/avedt.gif'<br>";
		  ?>		  
	</div>
<?PHP		
	}
	}
?>
<?PHP
///////////////////////////////////////////////////////////////////////
//////////////IMPRIME LAS ACREDITACIONES ROTATIVAS/////////////////////
///////////////////////////////////////////////////////////////////////
	$result= $con->ejecutar("SELECT * FROM acrrot where rif ='".$_SESSION['valor']."' and estatus = 1" ,$idcon);
	while ($row=mysql_fetch_array($result)) {
		$result2= $con->ejecutar("SELECT * FROM tipacr WHERE codtacr = ".$row['tipacr'] ,$idcon);
		$row2=mysql_fetch_array($result2);
	  /*INICIO: ACTUALIZAR LA TABLA acreditado*/
       $hoy = date("Y-m-d");
       $strStatus = "UPDATE acrrot SET estatus='2' WHERE rif ='".$_SESSION['valor']."'";
	   $resimpre = $con->ejecutar($strStatus,$idcon);
      /*FIN ACTUALIZAR LA TABLA acreditado*/
   
      /*INICIO: INSERTA EN LA TABLA accesoacr*/
       $desde=$row2[desde];
	   $hasta=$row2[hasta];
	   $codigob=$row[cod_b];
	   $strAcceso = "INSERT INTO accesoacr (codigo,desde,hasta) VALUES('$codigob','$desde','$hasta')";
	   $resulAcceso = $con->ejecutar($strAcceso,$idcon);
     /*FIN INSERTA EN LA TABLA accesoacr*/
?>

	<div align="center" style="width:50mm; height:85mm; font-family:Arial, Helvetica, sans-serif; font-size:9px; background: url(Imagenes/rotativo.jpg); vertical-align:middle">
		 <table border="0" style="height:85mm">
		 <tr>
		 <td width="50%">&nbsp;</td>
		 <td valign="middle" align="center">
		  <?PHP
			$g = strlen($row['cod_v']);
			$c_v = $row['cod_v'];
			while ($g<3)
			{
			  $c_v = "0".$c_v;
			  $g++;
			}			  
		  echo "<font size='4'><strong>".$row2['descrip'].'</strong></font><br>';
		  echo "<font size='4'><strong>".$c_v .'</strong></font><br>';
		  echo "<img src='barcode.php?code=".$row['cod_b']."' width='110' height='50'>";
		  ?>
		  </td>
		  </tr>
		  </table>
	</div>
<?PHP
	}
?>
</body>
</html>
<?php
 }else
{
    Header ("location: index.php"); 
}
?>
