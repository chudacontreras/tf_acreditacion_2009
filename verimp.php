<?php
session_start();
if (array_key_exists('login',$_SESSION)){

 
require("php-barcode.php");
include("ControlaBD.php");
include("util.php");
	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");

if ($_POST['valor'] == ''){js_redireccion("error.php?msn=El campo valor no puede estar en blanco");exit;}

$_SESSION['valor'] = $_POST['valor'];
$_SESSION['campo'] = $_POST['campo'];
if ($_POST['color'] == 'on'){
	$_SESSION['color'] = 'Imagenes/acre.jpg';
}else{
	$_SESSION['color'] = 'Imagenes/acreBN.jpg';
}	

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::.Imprimir.::</title>
<link href="styles.css" rel="stylesheet" type="text/css">
</head>
<body>

<?PHP
	if ($_POST['tipo'] == 0){

	//echo "SELECT * FROM acreditado where ".$campo."=".$valor;
	$result= $con->ejecutar("SELECT * FROM acreditado where ".$_SESSION['campo']."='".$_SESSION['valor']."' and estatus = 1" ,$idcon);
		$num_rows=mysql_num_rows($result);
		
		if ($num_rows <= 0){
			js_redireccion("error.php?msn=No se Encontraron Registros.....");exit;
		}else{	
	while ($row=mysql_fetch_array($result)) {
		$result2= $con->ejecutar("SELECT * FROM tipacr WHERE codtacr = ".$row['tipacr'] ,$idcon);
		$row2=mysql_fetch_array($result2);	
	
		$result3= $con->ejecutar("SELECT * FROM empresa WHERE rif = '".$row['rif']."'",$idcon);
		$row3=mysql_fetch_array($result3);
		$empresa = 	strtoupper($row3['nombre']);
			
?>

	<div align="center" style="width:50mm; height:85mm; font-family:Arial, Helvetica, sans-serif; font-size:9px; background: url(<?PHP echo $_SESSION['color']; ?>); vertical-align:middle">
		  <!--img src='Imagenes/acre1.gif'--><br><br><br><br>
		  <img src=<?php echo $row['foto']  ?> width="80" height="80" vspace="10" hspace="50" border="1"><br>
		  <?PHP ///
		    echo "<strong>".$row['nombre'].'</strong><br>';
			echo "<strong>".$row['cedula'] .'</strong><br>';
			echo "<font size='2'><strong>".$row2['descrip'].'</strong></font><br>';
			echo "<font>".$empresa.'</font><br><br>';			
	        echo "<img src='barcode.php?code=".$row['cod_b']."' width='120' height='50'>";
			//echo "<img src='Imagenes/avedt.gif'<br>";
		  ?>		  
	</div>
<?PHP		
	}
	}
?>
<?PHP
	}elseif($_POST['tipo'] == 1){
///////////////////////////////////////////////////////////////////////
//////////////IMPRIME LAS ACREDITACIONES ROTATIVAS/////////////////////
///////////////////////////////////////////////////////////////////////
	$result= $con->ejecutar("SELECT * FROM acrrot where rif ='".$_SESSION['valor']."' and estatus = 1" ,$idcon);
	while ($row=mysql_fetch_array($result)) {
		$result2= $con->ejecutar("SELECT * FROM tipacr WHERE codtacr = ".$row['tipacr'] ,$idcon);
		$row2=mysql_fetch_array($result2);

		$result3= $con->ejecutar("SELECT * FROM empresa WHERE rif = '".$row['rif']."'",$idcon);
		$row3=mysql_fetch_array($result3);
		$empresa = 	strtoupper($row3['nombre']);		
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
		  echo "<font size='2'>".$empresa.'</font><br>';
		  echo "<font size='4'><strong>".$c_v .'</strong></font><br>';
		  echo "<img src='barcode.php?code=".$row['cod_b']."' width='110' height='50'><br>";
		  ?>
		  </td>
		  </tr>
		  </table>
	</div>
<?PHP
	}}
?>
<form name="forma">
	<input type="button" value="IMPRIMIR" onClick="javascript:window.open('imprime.php', 'x', 'width=300', 'height=1300', 'scrollbars=yes')"> 
</form>
</body>
</html>

<?php
 }else
{
    Header ("location: index.php"); 
}
?>
