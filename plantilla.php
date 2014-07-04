<?php
session_start();
if ($_SESSION["valor"] != "true") {
 Header ("location: index.php"); 
 }
?>
<html>
<head>
<title></title>
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
  
  <td height="600px" bgcolor="#DADADA" valign="middle">
    <table width="100%" height="500px" border="0">

	<tr>
		<td align="center">
		<?php
		if ($_SESSION["tusu"] == 10 || $_SESSION["tusu"] == 1){
			echo '<img src="Imagenes/Bien.gif">';
		}
		elseif ($_SESSION["tusu"] == 2 || $_SESSION["tusu"] == 3){
			echo '<img src="Imagenes/Acre.gif">';
		}	
		elseif ($_SESSION["tusu"] == 4 || $_SESSION["tusu"] == 5){
			echo '<img src="Imagenes/Abon.gif">';
		}	
		elseif ($_SESSION["tusu"] == 6 || $_SESSION["tusu"] == 7){
			echo '<img src="Imagenes/Comer.gif">';
		}				
		?>	
		</td>
	</tr>
	</table>
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
