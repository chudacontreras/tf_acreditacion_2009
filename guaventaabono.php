<?php
session_start();
if (array_key_exists('login',$_SESSION)){

?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="text.css" type="text/css">
</head>

<body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr> 
    <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="D00C0C">
        <tr bgcolor="#FF6600"> 
          <td bgcolor="#FFFFFF"></td>
        </tr>
      </table>	</td>
  </tr>
  <tr> 
  <tr>
    <td height="3" colspan="2" bgcolor="#000000"><img src="images/spacer.gif" width="1" height="3"></td>
  </tr>
  <tr> 
	<td colspan="2">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="75%" height="19" align="left" bgcolor="#FF6600">
				<font color="#FFFFFF" size="1" face="Verdana, Arial, Helvetica, sans-serif">
				&nbsp;&nbsp;<strong>Bienvenido Sr(a) <? echo $_SESSION["usuario"] ?></strong>
				</font>	
			</td>
			<td width="25%" align="right" bgcolor="#FF6600">
				<font color="#FFFFFF" size="1" face="Verdana, Arial, Helvetica, sans-serif">
				<? echo date("d / m / Y"); ?>&nbsp;&nbsp;
				</font>
			</td>		
		</tr>	
		</table>
	</td>
  </tr>  
  <tr>
  <td height="600px" width="206" bgcolor="#E5E5E5">
  	<? include("menu.php"); ?>	
  </td>
  <td height="600px" bgcolor="#DADADA">
  <div class="tabConte" id="tabConte">
  
  <?php
	include("ControlaBD.php");

	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");
 
	$nac = $_GET["Nac"];
	$rif=$_GET["Rif"];
	$nom = $_GET["Nom"];
	$dir = $_GET["Dir"];
	$telf = $_GET["Tlf"];
	$cant = $_GET["Cant"];
		
	$union=$nac.$rif;

 // $preven = $_GET["Pre"];
//	$result= $con->ejecutar("SELECT * FROM ubicacion WHERE codubi='$ubica'",$idcon);
//	$num_rows=mysql_num_rows($result);
//	$row=mysql_fetch_array($result);

//	  if ($num_rows==1){
      $fecha=date("Y-m-d", mktime(0, 0, 0, date("m") , date("d"), date("Y")));

	  $strsql = "INSERT INTO abono (rif,nombre,direccion,telf,fecha,cant) VALUES ('$union','$nom','$dir','$telf','$fecha','$cant')";
      $resultbusq = $con->ejecutar($strsql,$idcon);
	  
		if (!$result) {
			die('Error al Insertar:'. mysql_error());
		}else{
	
	echo '<div align="center">
      <strong>
	    <font face="Arial, Helvetica, sans-serif">
		   <span>
		     <font size="4">
			   <font color="#FF6600">
		          <br>Venta Realizada Existosamente....
		          <br>
			   </font>
			 </font>
		</span>
		</font>
	</strong>
  </div>';
			}
//	}
?>
  
  
  </div>
  </td>
  </tr>
  
  
  <tr> 
    <td height="19" colspan="2" align="center" bgcolor="#FF6600"><font color="#FFFFFF" size="1" face="Verdana, Arial, Helvetica, sans-serif">&copy;2009 Gobernacion del Estado Lara<br>
Desarrollado por la Dirección de Informatica (Unidad de Diseño y Desarro</font></td>
  </tr>
  <tr>
    <td height="3" colspan="2" bgcolor="#000000"><img src="images/spacer.gif" width="1" height="3"></td>
  </tr>
</table>
</body>
</html>
<?php
 }else
{
    Header ("location: index.php"); 
}
?>
