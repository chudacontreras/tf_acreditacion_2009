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
	if ($_GET["boton"]=="Crear"){
	
		if (array_key_exists('Nac', $_GET)) 
			$Nac = $_GET["Nac"];
			
		if (array_key_exists('Ced', $_GET)) 
			$Ced = $_GET["Ced"];
		
		if (array_key_exists('Usu', $_GET)) 
			$Usu = $_GET["Usu"];
			
		if (array_key_exists('Cla', $_GET)) 
			$Cla = $_GET["Cla"];
			
		if (array_key_exists('Nom', $_GET))     
			$Nom = $_GET["Nom"];
		
		if (array_key_exists('Cod', $_GET))     
			$Cod = $_GET["Cod"];
		
		$uni=$Nac.$Ced;
		
		$result= $con->ejecutar("SELECT codigo FROM tusuario WHERE descripcion='$Cod'",$idcon);
		$row=mysql_fetch_array($result);
		
		
		$strsql = "INSERT INTO login (usuario,clave,codtipo,nombre) VALUES('$Usu','$Cla','$row[codigo]','$Nom')";
		$resultbusq = $con->ejecutar($strsql,$idcon);
		if (!$strsql) {
			die('Error al Insertar:'. mysql_error());
		}else{
			echo '<div align="center">
      <strong>
	    <font face="Arial, Helvetica, sans-serif">
		   <span>
		     <font size="4">
			   <font color="#FF6600">
		          <br>El Usario Registrado exitosamente....
		          <br>
			   </font>
			 </font>
		</span>
		</font>
	</strong>
  </div>';
	
	
	}
	}
	
	if ($_GET["boton"]=="Cambiar"){
	
		$Claa = $_GET["Claa"];
		$Clab = $_GET["Clab"];
		$Clac = $_GET["Clac"];
		
	$result= $con->ejecutar("SELECT clave FROM login WHERE usuario='".$_SESSION['login']."'",$idcon);
	$fila  = mysql_fetch_array($result);

	//echo "$fila[clave]";
	//echo $_SESSION['login'];
		if ($fila[clave]==$Claa){
			
	    $str = "UPDATE login SET clave='$Clab' WHERE usuario='".$_SESSION['login']."'";
		$result = $con->ejecutar($str,$idcon);
	
		if (!$result) {
			die('Error al Insertar:'. mysql_error());
		}else{
			echo '<div align="center">
      <strong>
	    <font face="Arial, Helvetica, sans-serif">
		   <span>
		     <font size="4">
			   <font color="#FF6600">
		          <br>Clave Modificada exitosamente....
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
		     <font size="4">
			   <font color="#FF6600">
		          <br>Clave Actual Incorrecta....
		          <br>
			   </font>
			 </font>
		</span>
		</font>
	</strong>
  </div>';	
	}
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