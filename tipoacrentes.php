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
    <td height="3" colspan="2" bgcolor="#000000"></td>
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
		          <br>Cantidad de Acreditaciones
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
 ?>
  <FORM METHOD="GET" action="guardarentes.php" name="formato">
   <table border="0" align=center>

  <tr>
      <td>&nbsp;</td>
  <td>&nbsp;</td>
 
 <?php
 $contador=0;
 //MUESTA LOS TIPOS DE ACREDITACIONES MENORES DE 100 QUE SON LOS PERSONALIZADOS
 $resulcate= $con->ejecutar("SELECT codtacr,descrip,codcateg FROM tipacr WHERE codcateg='".$_GET["Cate"]."' and codtacr<100 ",$idcon);
		 echo "<tr><td colspan=2><strong>ACREDITACIONES PERSONALIZADAS</strong></td></tr><tr><td>&nbsp;</td></tr>";		
		while ($fila = mysql_fetch_array($resulcate)) {
		   echo "<tr>";
		   echo "<td>$fila[descrip]</td>";
		   echo "<td><input type=text name=tipoac[$contador] id=tipoac[$contador]></td>"; 
		   echo "</tr>";
           $contador=$contador+1;
		}
         $contador=$contador-1;
echo"<tr><td>&nbsp;</td></tr>";
 //MUESTA LOS TIPOS DE ACREDITACIONES MAYORES O IGUALES A 100 QUE SON LOS ROTATIVOS
 $contador2=0;
$resulcate2= $con->ejecutar("SELECT codtacr,descrip,codcateg FROM tipacr WHERE codcateg='".$_GET["Cate"]."' and codtacr<=100 ",$idcon);		 
		echo "<tr><td colspan=2><strong>ACREDITACIONES ROTATIVAS</strong></td></tr><tr><td>&nbsp;</td></tr>";		
		while ($fila2 = mysql_fetch_array($resulcate2)) {
		   echo "<tr>";
		   echo "<td>$fila2[descrip]</td>";
		   echo "<td><input type=text name=tipoacR[$contador2] id=tipoacR[$contador2]></td>"; 
		   echo "</tr>";
           $contador2=$contador2+1;
		}
         $contador2=$contador2-1;
		
?>
<tr>
	 <td height="21" colspan="15" valign="top" align=center><?php
	    $ced=$_GET["prueba2"];
		$pru=$fila[0];
         echo "<input name=button type=submit value='Guardar'>";
		 echo "<input type=hidden name='Cate' id='Cate' value='".$_GET["Cate"]."'>";
		 echo "<input type=hidden name='Nom' id='Nom' value='".$_GET["Nom"]."'>";
		 echo "<input type=hidden name='Num' id='Num' value='".$_GET["Num"]."'>";
		 echo "<input type=hidden name='Telf' id='Telf' value='".$_GET["Telf"]."'>";
		 echo "<input type=hidden name='Nac' id='Nac' value='".$_GET["Nac"]."'>";
		 echo "<input type=hidden name='Ced' id='Ced' value='".$_GET["Ced"]."'>";
		  echo "<input type=hidden name='Comi' id='Comi' value='".$_GET["Comi"]."'>";
		  echo "<input type=hidden name='Usu' id='Usu' value='".$_GET["Usu"]."'>";
           ?>
		 </td>
	  </tr>
<td>&nbsp;</td>
  <td>&nbsp;</td>
  </table> 
  </FORM>
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
