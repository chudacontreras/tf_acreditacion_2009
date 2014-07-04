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
		          <br>Resultado de la Comercializacion
		          <br>
			   </font>
			 </font>
		</span>
		</font>
	</strong>
  </div>
  
  <?php
  include("ControlaBD.php");
  $con   = new ControlaBD();
  $idcon = $con->conectarSBD();
  $sel_bd= $con->select_BD("tf_comercializacion");
  
  $nomb=$_GET["q"];
  $rif=$_GET["rif"];
  $numcont=$_GET["Cont"]; 
  
  $resul= $con->ejecutar("SELECT stand,productos,total,costo FROM contrato WHERE numero='$numcont'",$idcon);
 $fila = mysql_fetch_array($resul);
	
$fecha=date("d-m-Y", mktime(0, 0, 0, date("m") , date("d"), date("Y")));
			function fechaes($fecha) {
  return implode("/", array_reverse( preg_split("/\D/", $fecha) ) );
}
	

?>
<?php 
echo'<FORM METHOD="get" action="ubicastan.php" name="formato">
  <table width=550 border=0 align=center>
    <!--DWLayoutTable-->
  <tr><td width="53" height="44">
  </td>
    <td width="160"></td>
    <td width="1">&nbsp;</td>
    <td width="20">&nbsp;</td>
    <td width="49">&nbsp;</td>
    <td width="13">&nbsp;</td>
    <td width="162">&nbsp;</td>
    <td width="58">&nbsp;</td>
    <!--DWLayoutTable-->
  <tr>
		<td height="21">&nbsp;</td>
		<td valign="top">Fecha</td>
		<td>&nbsp;</td>
		<td valign="top"><input name="Fec" id="Fec" value="'.$fecha.'" type="text" style="WIDTH: 80px; HEIGHT: 21px" disabled=disabled/> 
					</td>
	<td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
        </tr>
  <tr>
  		<td height="24"></td>
		<td valign="top">N. de Contrato</td>
		<td>&nbsp;</td>
		<td colspan="3" valign="top"><input type=hidden name="Cont" id="Cont" value="'.$_GET['Cont'].'">
			<input name="Cont" id="Cont" value="'.$_GET['Cont'].'" type="text" style="WIDTH: 80px; HEIGHT: 21px" disabled=disabled/> 
		</td>
	
	    
        <td></td>
        <td></td>
        </tr>
  <tr>
    <td height="37"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    </tr>
  
  
   <tr>
   		<td height="21">&nbsp;</td>
		<td valign="top">Rif/Cedula</td>
		<td colspan="3" valign="top"><input type=hidden name="Rif" id="Rif" value="'.$rif.'">
			<input name="Rif" id="Rif" value="'.$rif.'" type="text" style="WIDTH: 80px; HEIGHT: 21px" disabled=disabled/> 
		</td>
	<td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
        </tr>
    <tr>
			<td height="21">&nbsp;</td>
	<td valign="top">Empresa</td>
	    <td colspan="5" valign="top"><input type=hidden name="Nom" id="Nom" value="'.$_GET['q'].'">
					<input name="Nom" id="Nom" value="'.$_GET['q'].'" type="text" style="WIDTH: 400px; HEIGHT: 21px" disabled=disabled/>
        		</td>
        <td>&nbsp;</td>
        </tr>
<tr>
		<td height="21">&nbsp;</td>
				<td valign="top">Direccion</td>
				<td colspan="5" valign="top">
			     <input type=hidden name="Dir" id="Dir" value="'.$_GET['Dir'].'">
					<input name="Dir" id="Dir" value="'.$_GET['Dir'].'" type="text" style="WIDTH: 400px; HEIGHT: 21px" disabled=disabled/>				</td>
                <td>&nbsp;</td>
            </tr>
			<tr>
					<td height="21"></td>
				<td valign="top">Productos</td>
				<td colspan="5" valign="top"><input name="Pro" id="Pro" type="text" value="'.$fila[productos].'" style="WIDTH: 400px; HEIGHT: 21px"/> 
                 </td>
		        <td>&nbsp;</td>
			</tr>
			<tr>
			  <td height="21"></td>
			  <td valign="top">Stand</td>
			  <td colspan="5" valign="top">
					<input name="Sta" id="Sta" type="text" value="'.$fila[stand].'" style="WIDTH: 400px; HEIGHT: 21px" disabled=disabled/>
                 </td>
	          <td></td>
            </tr>
			
			<tr>
			  <td height="13"></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
			  <td></td>
            </tr>
  </table>
  <table>
    <!--DWLayoutTable-->
     <tr>
	<td width="296" height="21">&nbsp;</td>
	<td width="98" valign="top">Valor del Stand</td>
	<td width="90" valign="top"><input name="Cos" id="Cos" type="text" value="'.$fila[costo].'" style="WIDTH: 100px; HEIGHT: 21px" disabled=disabled/>	</td>
	 </tr>
	<tr>
	   	<td height="40">&nbsp;</td>
	    <td valign="top">Total a Cancelar</td>
	<td valign="top" ><input name="Tot" id="Tot" type="text" value="'.$fila[total].'" style="WIDTH: 100px; HEIGHT: 21px" disabled=disabled/>	</td>
	</tr>

  </table>
  
  <table border="1" align=center>
   <tr>
     <td colspan="4" align="center">Forma de Pago</td>
  </tr>
  
  <tr>
  <td valign="middle"><input type="radio" name="cheq" value="Cheque">Cheque<br>
      <input type="radio" name="bauc" value="Baucher">Baucher</td>
  <td>N&uacute;mero <br> <input type="text" name="nro" id="nro" size="10"></td>
  <td>Banco <br> <input type="text" name="ban" id="ban" size="10"></td>
  <td>Monto <br> <input type="text" name="mon" id="mon" size="10"></td>
  </tr>
  <tr>
	  <td height="21" colspan="4" valign="top">
		<tr>
			 <input type=hidden name="tipo" id="tipo" value="1">
	         <td height=35 colspan=4 valign=top align=center>
             <input name=button type=submit value="Modificar Stand">
	    </td>
	    </tr>
    	 </td>
	   </tr>
  </table>
  </FORM>';
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
