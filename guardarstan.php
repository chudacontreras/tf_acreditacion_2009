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
	
	    $ubica = $_GET["ubi"];
		
	    $desde = $_GET["des"];
		
	    $hasta = $_GET["has"];
	if ($hasta!=""){

	$result= $con->ejecutar("SELECT codubi,descrip FROM ubicacion WHERE codubi='$ubica'",$idcon);
	$row=mysql_fetch_array($result);
	$separar_cadena = explode(' ',$row[descrip]);
	$cantidadventa=count($separar_cadena)-1;
	$resp='0';
    for($i=$desde;$i<=$hasta; $i++){
	   $longitud = strlen($i);
	   if ($longitud==1){
	      $i='0'.$i;
	   }
	   $uni=$separar_cadena[$cantidadventa].$i;
	   $codigo=$row[codubi];
	   //echo "el codio es $codigo";
	   $strsql = "INSERT INTO stand (codstand,status,codubi) VALUES ('$uni','Activo','$codigo')";
	   $resultbusq = $con->ejecutar($strsql,$idcon);
	   $resp='1';
	}
	}else{
	$result= $con->ejecutar("SELECT codubi FROM ubicacion WHERE descrip='$ubica'",$idcon);
	$row=mysql_fetch_array($result);
	$separar_cadena = explode(' ',$ubica);
	$cantidadventa=count($separar_cadena)-1;
	$resp='0';
    //for($i=$desde;$i<=$hasta; $i++){
	   $longitud = strlen($desde);
	   if ($longitud==1){
	      $desde='0'.$desde;
	   }
	   $uni=$separar_cadena[$cantidadventa].$desde;
	   	   $codigo=$row[codubi];
	   $strsql = "INSERT INTO stand (codstand,status,codubi) VALUES ('$uni','Activo','$codigo')";
	   $resultbusq = $con->ejecutar($strsql,$idcon);
	   $resp='1';
	}
	
	if ($resp=='1'){
	echo '<div align="center">
      <strong>
	    <font face="Arial, Helvetica, sans-serif">
		   <span>
		     <font size="3">
			   <font color="#FF6600">
		          <br>Stand Creados exitosamente....
		          <br>
			   </font>
			 </font>
		</span>
		</font>
	</strong>
  </div>';
	
	}

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
