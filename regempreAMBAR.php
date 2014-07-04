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

    $nacionalidad = $_GET["Nac"];
    $cedula = $_GET["Rif"];
    $nombre = $_GET["Nom"];
    $direccion = $_GET["Dir"];
    $telefono = $_GET["Tel"];
  	  $repre = $_GET["NomRep"];
      $cedrepre = $_GET["CedRep"];
      $contrato = $_GET["Cont"];
      $regis = $_GET["Regis"];
      $fecregis = $_GET["a"].'-'.$_GET["mes"].'-'.$_GET["dia"];
	  $tomo = $_GET["Tom"];
      $cargo = $_GET["Car"];
	  $cate = $_GET["Cate"];
	  $iva=$_GET["IVA"];
 
 if ($iva==''){
 $iva=0;
 }else{
 $iva=1;
 }
	echo"esto es $iva <br>";
	$dato=$cedula; //Concatenar tipo con numero  	
	$result= $con->ejecutar("SELECT * FROM empresa WHERE rif='$dato'",$idcon);
	$num_rows=mysql_num_rows($result);
	$row=mysql_fetch_array($result);
	
	
	if ($num_rows==1){
	echo '<div align="center">
      <strong>
	    <font face="Arial, Helvetica, sans-serif">
		   <span>
		     <font size="4">
			   <font color="#FF6600">
		          <br>La Empresa ya Existe....
		          <br>
			   </font>
			 </font>
		</span>
		</font>
	</strong>
  </div>';
	}
	else{
	if ($nacionalidad=='G' or $nacionalidad=='J'){

	    $strsql = "INSERT INTO empresa VALUES('$dato','$nombre','$direccion','$telefono','$repre','$cedrepre','registro','$regis','$fecregis','$tomo','$cargo',$cate,$iva)";
		$resultbusq = $con->ejecutar($strsql,$idcon);
	   }
	   else{
	 $strsql = "INSERT INTO empresa (rif,nombre,direccion,telf,categoria,retensoriva) VALUES('$dato','$nombre','$direccion','$telefono',$cate,$iva)";
	 $resultbusq = $con->ejecutar($strsql,$idcon);
	   }
		if (!$resultbusq) {
			die('Error al Insertar:'. mysql_error());
		}else{
		//$dato=urlencode($dato); //union de nac. con cedula o rif
		//$nombre=urlencode($nombre);
		//$direccion=urlencode($direccion);
			echo '<div align="center">
      <strong>
	    <font face="Arial, Helvetica, sans-serif">
		   <span>
		     <font size="4">
			   <font color="#FF6600">
		          <br>La Empresa registrada Existosamente....
		          <br>
			   </font>
			 </font>
		</span>
		</font>
	</strong>
  </div>';
		echo  '
			<FORM METHOD="GET" action="contrato.php">
				<table align="center" cellspacing="2" cellpadding="2" border="0" class="texto">
				<input name="Rif" type="hidden" id="Rif" value="'.$dato.'"/>
				<input name="Dir" type="hidden" id="Dir" value="'.$direccion.'"/>
				<input name="Nom" type="hidden" id="Nom" value="'.$nombre.'"/>
				<input name="Cate" type="hidden" id="Cate" value="'.$cate.'"/>
				<input name="IVA" type="hidden" id="IVA" value="'.$iva.'"/>
				<tr>
				<td>
				<td><input name="button" type="submit" value="Generar Contrato"></td>
				</td>
				</tr>
				</table>
				</form>';
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