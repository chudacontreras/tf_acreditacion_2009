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
      var Sta = document.formulario.Sta.value; 
      var Cos = document.formulario.Cos.value; 

	  
      if(Sta==""){
         alert("C&oacute;digo del Stand no debe estar en Blanco");
		 return false;
      }
	  if((isNaN(parseFloat(Cos))==true) || (Cos=="")){
         alert("Ingrese un Costo Valido");
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
		          <br>Modificar Stand
		          <br>
			   </font>
			 </font>
		</span>
		</font>
	</strong>
  </div>
   <FORM METHOD="GET" action="guarcostosta.php" name="formulario" onSubmit="return Validar()">
  <?php

	include("ControlaBD.php");

	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");
	?>
<table align="center" cellspacing="2" cellpadding="2" border="0" class="texto">
		 <tr>
				<td>C&oacute;digo del Stand:&nbsp;</td>
				<td>
				<?php echo '<input name="Sta" type="text" id="Sta"  style="WIDTH: 200px; HEIGHT: 22px" value="'.$row['cant'].'" />'; ?>
				</td>
		</tr>
		<tr>
				<td>Costo:&nbsp;</td>
				<td>
				<?php echo '<input name="Cos" type="text" id="Cos"  style="WIDTH: 200px; HEIGHT: 22px" value="'.$row['metros'].'" />'; ?>
				</td>
		</tr>
			<tr>
			    <td width="162">Status:&nbsp;</td>
				 <td width="302">
				<SELECT NAME="Blo" id="Blo" SIZE="0">
				<OPTION value=Activo>Activo
				<OPTION value=Bloqueado>Bloquear
				</SELECT>								
				</td>
			</tr>
		 <td height="21" colspan="3" valign="top"><?php
				     echo "
					<tr>
			         <td height=35 colspan=4 valign=top align=center>
                     <input name=button type=submit value='Guardar'>
				    </td>
		          </tr>";
                 ?>
		  </td>
		</table>
		 <font face="Arial, Helvetica, sans-serif" size="1" color="#FF6600">
		<center><label>Nota: Escriba los C&oacute;digo de los Stand separados por coma (,).</label></center>
		<center><label>Nota: Un Stand Vendido no cambiar los precios.</label></center>
        </font>
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

