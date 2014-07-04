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
      var Rif = document.formu.Rif.value; 
      var Nom = document.formu.Nom.value; 
	  var Dir = document.formu.Dir.value; 
	  var Tlf = document.formu.Tlf.value; 
	  var Cant = document.formu.Cant.value; 
      	  
      if(Rif==""){
         alert("Ingrese una C&eacute;dula/Rif Valido");
		 return false;
      }
	   if(Nom==""){
         alert("Ingrese un Nombre Valido");
		 return false;
      }
	   if(Dir==""){
         alert("Ingrese una Direcci&oacute;n Valida");
		 return false;
      }
	  if(Tlf==""){
         alert("Ingrese un Tel&eacute;fono Valido");
		 return false;
      }
	  if((isNaN(Cant)==true) || (Cant=="")){
         alert("Ingrese una Cantidad Valida");
		 return false;
      }
     
	  return true;
}
function Calcular()
   {
    
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
		          <br>Venta de Abonos
		          <br>
			   </font>
			 </font>
		</span>
		</font>
	</strong>
  </div>
   

<table align="center" cellspacing="2" cellpadding="2" border="0" class="texto">
  <!--DWLayoutTable-->
  <FORM METHOD="GET" action="guaventaabono.php" name="formu" onSubmit="return Validar()">         
			<tr>
			    <td width="162">C&eacute;dula:/Rif:&nbsp;</td>
				 <td width="302">
				<SELECT NAME="Nac" id="Nac" SIZE="0">
				<OPTION>V
				<OPTION>E
				<OPTION>J
				<OPTION>G
				</SELECT> -
			    <INPUT type="Text" name=Rif id="Rif"  style="WIDTH: 100px; HEIGHT: 22px"> 	
								
				</td>
			</tr>
			
			<tr>
			    <td>Nombre:&nbsp;</td>
			    <td>
		      <input name="Nom" type="text" id="Nom"  style="WIDTH: 290px; HEIGHT: 22px" />
				</td>
			</tr>
		    <tr>
				<td>Direcci&oacute;n:&nbsp;</td>
				<td>
		        <input name="Dir" type="text" id="Dir"  style="WIDTH: 290px; HEIGHT: 22px" />
				</td>
			</tr>
			  <tr>
				<td>Telefono:&nbsp;</td>
				<td>
		        <input name="Tlf" type="text" id="Tlf"  style="WIDTH: 290px; HEIGHT: 22px" />
				</td>
			</tr>
			 <tr>
				<td>Cantidad:&nbsp;</td>
				<td>
		        <input name="Cant" type="text" id="Cant"  style="WIDTH: 290px; HEIGHT: 22px" />
				</td>
			</tr>
			<tr>
			  <td height="28" colspan="2" valign="top" align="center">
                <input name="button" type="submit" value="Vender">
				</td>
		    </tr>	
	</form>
  </table>

	

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


