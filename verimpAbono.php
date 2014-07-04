<?php
require("php-barcode.php");
include("ControlaBD.php");
include("util.php");
	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");

if ($_POST['cant'] == ''){js_redireccion("error.php?msn=Cantidad a Imprimir no puede estar en blanco");exit;}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::.Imprimir.::</title>
<meta name="description" content="CAPTCHA con PHP: ejemplo para demostrar la creacion de Captcha con PHP." />
<link href="styles.css" rel="stylesheet" type="text/css">
</head>
<body>

<?PHP

//SELECT * FROM abono LIMIT 50 OJO
        $cantidad=$_POST['cant'];
	    $result= $con->ejecutar("SELECT * FROM abono where status='0' LIMIT $cantidad " ,$idcon);
		$num_rows=mysql_num_rows($result);
		if ($num_rows <= 0){
			js_redireccion("error.php?msn=No se Encontraron Registros.....");exit;
		}elseif ($num_rows < $cantidad){
			js_redireccion("error.php?msn=Solo hay $num_rows Abono Registrado.....");exit;
		}else{	
	while ($row=mysql_fetch_array($result)) {
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
	}}
?>
<form name="forma">
    <?php 
    $cantidad=$_POST['cant'];
    echo"<input type='hidden' name='cant' id='cant' value='".$_POST['cant']."'>";
	
	?>
	<table>
	<tr>
	<br>
	<td width="30%" align="center">
	<input type="button" value="IMPRIMIR" onClick="javascript:window.open('imprimeAbono.php?cant=<?php echo $cantidad; ?>', 'x', 'width=350', 'height=300', 'scrollbars=NO')"> 
    </td>
	</tr>
	</table>
	
</form>
</body>
</html>
