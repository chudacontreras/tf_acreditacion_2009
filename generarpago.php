<?php
session_start();
if (array_key_exists('login',$_SESSION)){

?>

<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="text.css" type="text/css">
<script language="javascript">
   function comprobar()
   {
           var Nro = document.formulario.nro.value; 
           var Ban = document.formulario.ban.value;
		   var Mon = document.formulario.mon.value;
		   var Tot = document.formulario.tot.value;
		   var Acum = document.formulario.acum.value;
             
           if (Nro == '')
           {
                   alert("N&uacute;mero de deposito no V&aacute;lido");
                   return false;
           }
		   
		   if (Ban == '')
           {
                   alert("Nombre del Banco no V&aacute;lido");
                   return false;
           }
		   if((isNaN(parseFloat(Mon))==true) || (Mon=="")){
              alert("Monto no V&aacute;lido");
		      return false;
           }
		   if(Mon!= ''){
              resta=Tot-Acum;
			  if(Mon>resta){
			     alert("El monto es mayor a la deuda");
		      return false;
			  }
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
		          <br>Realizar Pago
		          <br>
			   </font>
			 </font>
		</span>
		</font>
	</strong>
  </div>
<?php
 $cont=$_GET["Cont"];
 $tot=$_GET["tot"];
 $acum=$_GET["acum"];
 

include("ControlaBD.php");

$con   = new ControlaBD();
$idcon = $con->conectarSBD();
$sel_bd= $con->select_BD("tf_comercializacion");

echo '<form  name="formulario" METHOD="GET" action="guardarpagos.php" onSubmit="return comprobar()"> 	
<table align="center" cellspacing="2" cellpadding="2" border="0" class="texto">
   <tr>
&nbsp;
  </tr>
  
  <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>N&uacute;mero <br> <input type="text" name="nro" id="nro" size="10"></td>
      <td>Banco <br> <input type="text" name="ban" id="ban" size="10"></td>
      <td>Monto <br> <input type="text" name="mon" id="mon" size="10"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>	 
  </tr>
	 <tr>
	   <td>&nbsp;</td>	
	  </tr>
 <tr>
	 <td height="21" colspan="15" valign="top" align=center>
	 <input type="hidden" name="Cont" id="Cont" VALUE='.$cont.'>
	 	 <input type="hidden" name="tot" id="tot" VALUE='.$tot.'>
		 <input type="hidden" name="acum" id="acum" VALUE='.$acum.'>
          <input name=button type=submit value="Guardar">
     </td>
  </tr>
  </table>
		</form>';
		

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