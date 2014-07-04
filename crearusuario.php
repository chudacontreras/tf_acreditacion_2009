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
<div align="center">
      <strong>
	    <font face="Arial, Helvetica, sans-serif">
		   <span>
		     <font size="4">
			   <font color="#FF6600">
		          <br>
		          Crear Usuarios <br>
			   </font>
			 </font>
		</span>
		</font>
	</strong>
  </div>
   <FORM METHOD="get"  action="guardarusu.php" name="formulario">
 <?php

	include("ControlaBD.php");

	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");
	?>
<table align="center" cellspacing="2" cellpadding="2" border="0" class="texto">
  <!--DWLayoutTable-->
           
	<!--	<tr>
			    <td width="162">C&eacute;dula:&nbsp;</td>
				 <td width="302">
				<SELECT NAME="Nac" id="Nac" SIZE="0">
				<OPTION>V
				<OPTION>E
				</SELECT> -
			    <INPUT type="Text" name="Ced" id="Ced"  style="WIDTH: 100px; HEIGHT: 22px"> 	
								
				</td>
			</tr>-->
			
			<tr>
			    <td>Nombre y Apellido:&nbsp;</td>
			    <td>
		      <input name="Nom" type="text" id="Nom"  style="WIDTH: 290px; HEIGHT: 22px" />
				</td>
			</tr>
			<tr>
			    <td>Tipo de Usuario:&nbsp;</td>
			    <td>
		        <?php
				    $result= $con->ejecutar("SELECT codigo,descripcion FROM tusuario",$idcon);
					if ($row = mysql_fetch_array($result)){ 
                        echo '<select name= "Cod" id="Cod" style="WIDTH: 290px; HEIGHT: 22px" >';
                      do {
                       echo '<option >'.$row["descripcion"].'</option>';
                      } while ($row = mysql_fetch_array($result)); 
                       echo '</select>';
					}
		        ?>
				</td>
				</tr>
			<tr>
			    <td>Login:&nbsp;</td>
			    <td>
		      <input name="Usu" type="text" id="Usu"  style="WIDTH: 290px; HEIGHT: 22px" />
				</td>
			</tr>
			<tr>
			    <td>Clave:&nbsp;</td>
			    <td>
		      <input name="Cla" type="password" id="Cla"  style="WIDTH: 290px; HEIGHT: 22px" />
				</td>
			</tr>
			 <td height="21" colspan="3" valign="top">
					<tr>
			         <td height=35 colspan=4 valign=top align=center>
                     <input name="boton" type=submit value='Crear'>
				    </td>
		          </tr>
  </table>

	
</form>
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


