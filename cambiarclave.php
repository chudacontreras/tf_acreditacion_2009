<?php
session_start();
if (array_key_exists('login',$_SESSION)){

?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="text.css" type="text/css">
<script language="JavaScript">
function Validar()
   {
      var a = document.formulario.Claa.value; 
	  var b = document.formulario.Clab.value; 
   	  var c = document.formulario.Clac.value;
	     
      if(a==""){
         alert("Ingrese una Clave actual Valida");
		 return false;
      }
	   if(b==""){
         alert("Ingrese una Nueva Clave Valida");
		 return false;
      }
	  if(c==""){
         alert("Ingrese una Confirmaci�n Valida");
		 return false;
      }
	  if (!b==c){
	     alert("Clave Nueva y la confirmaci&oacute;n no Coinciden ");
		 return false;
	  }
     
	  return true;
}
</script>
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
		          <br>Cambiar Clave
		          <br>
			   </font>
			 </font>
		</span>
		</font>
	</strong>
  </div>
   <FORM METHOD="get"  action="guardarusu.php" name="formulario" onSubmit="return Validar()">
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
			    <td>Clave Actual:&nbsp;</td>
			    <td>
		      <input name="Claa" type="password" maxlength="8"  id="Claa"  style="WIDTH: 290px; HEIGHT: 22px" />
				</td>
			</tr>
			
			<tr>
			    <td>Nueva Clave:&nbsp;</td>
			    <td>
		      <input name="Clab" type="password" maxlength="8" id="Clab"  style="WIDTH: 290px; HEIGHT: 22px" />
				</td>
			</tr>
			<tr>
			    <td>Confirmar Clave:&nbsp;</td>
			    <td>
		      <input name="Clac" type="password" maxlength="8" id="Clac"  style="WIDTH: 290px; HEIGHT: 22px" />
				</td>
			</tr>
			 <td height="21" colspan="3" valign="top">
					<tr>
			         <td height=35 colspan=4 valign=top align=center>
                     <input name="boton" type=submit value='Cambiar'>
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



