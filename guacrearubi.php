<?php
session_start();
if (array_key_exists('login',$_SESSION)){
	include("ControlaBD.php");
    
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

	
	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");
	
	    $ubica = $_GET["Ubi"];
		    
	    $canti = $_GET["Can"];
     
	    $metros = $_GET["Met"];

	    $cost = $_GET["Cos"];
		$acre = $_GET["Acre"];
	   
	    $fini = $_GET["a"].'-'.$_GET["mes"].'-'.$_GET["dia"];
      
	    $ffin =	$_GET["ia"].'-'.$_GET["imes"].'-'.$_GET["idia"];
		
	    $preven = $_GET["Pre"];
		


	$result= $con->ejecutar("SELECT codubi FROM ubicacion WHERE descrip='$ubica'",$idcon);
	$row=mysql_fetch_array($result);
	$num_rows=mysql_num_rows($result);
	if ($num_rows==0){
	
	$result= $con->ejecutar("SELECT codubi FROM ubicacion",$idcon);
	$row=mysql_fetch_array($result);
	$num_rows=mysql_num_rows($result)+1;
        $strsql1 = "INSERT INTO ubicacion VALUES('$num_rows','$ubica','$canti','$metros','$cost','$preven','$fini','$ffin','$acre','$acre')";
	    $resultbusq = $con->ejecutar($strsql1,$idcon);
	   
	   	if (!$result) {
			die('Error al Insertar:'. mysql_error());
		}else{
			echo '<div align="center">
      <strong>
	    <font face="Arial, Helvetica, sans-serif">
		   <span>
		     <font size="4">
			   <font color="#FF6600">
		          <br>Ubicaci&oacute;n Creada Existosamente....
		          <br>
			   </font>
			 </font>
		</span>
		</font>
	</strong>
  </div>';
			}
	
	}else{
	echo '<div align="center">
      <strong>
	    <font face="Arial, Helvetica, sans-serif">
		   <span>
		     <font size="3">
			   <font color="#FF6600">
		          <br>Ubicaci&oacute;n ya Existe....
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
