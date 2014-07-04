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
  <?php
	include("util.php");
	include("ControlaBD.php");
	

	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");
	
	$tipoacr = $_GET["tipoac"];
	$tipoacrR = $_GET["tipoacR"];
	$contra=$_GET["Contra"];
	$catego=$_GET["CodCate"];
	
	/*INICIO: VALIDAR VALOR ACREDITACIONES*/
		$contador=0;
		$totalregis=0;
		//primero valida si ingreso personalizadas si registro no valida rotativas de lo contrario valida rotativas
		$resulcate= $con->ejecutar("SELECT codtacr, codcateg FROM tipacr WHERE codcateg='".$_GET["CodCate"]."' and codtacr<100",$idcon);
		    //RECORRE Y CUENTA PARA VALIDAR
		while ($fila = mysql_fetch_array($resulcate)) {
		  $totalregis=$totalregis+$tipoacr[$contador];
	      $contador=$contador+1;
		}
	   //valida si registro ROTATIVA
		     $contador2=0;
		    $totalregis2=0;
			//primero valida si ingreso personalizadas si registro no valida rotativas de lo contrario valida rotativas
			$resulcate2= $con->ejecutar("SELECT codtacr, codcateg FROM tipacr WHERE codcateg='".$_GET["CodCate"]."' and codtacr<100",$idcon);
				//RECORRE Y CUENTA PARA VALIDAR
			while ($fila2 = mysql_fetch_array($resulcate2)) {
			  $totalregis2=$totalregis2+$tipoacrR[$contador2];
			  $contador2=$contador2+1;
			}
					
	 if ($totalregis==0 && $totalregis2==0){		   
       js_redireccion("error.php?msn=Debe Registrar cantidad de Acreditaciones");
	   exit;
	 }
	 
	 //total de acreditaciones registradas
    $Tregistro=$totalregis+$totalregis2;
		
	/*FIN: VALIDAR VALOR ACREDITACIONES */
	
	//AGREGAR AL CONTRATO TOTAL DE ACREDITACIONES ADICIONALES
	
    //busca cuantas acreditaciones tienes registradas en contrato
	    $strbuscar0= $con->ejecutar("SELECT acreadici, totalacred FROM contrato  WHERE  numero='$contra'",$idcon);
		$fila0 = mysql_fetch_array($strbuscar0);
		$sumaadici=$Tregistro+$fila0[acreadici]; //suma el total tipeado con el total registrado en la tabla contrato
	 	$totalacredi=$Tregistro+$fila0[totalacred]; //suma el total tipeado con el total registrado en la tabla contrato
	//modifica la tabla contrato las acreditaciones adicionales
		$str = "UPDATE contrato SET acreadici='$sumaadici', totalacred='$totalacredi' WHERE  numero='$contra'";
		$result = $con->ejecutar($str,$idcon);
	
	if (!$result) {
			die('Error al Insertar:'. mysql_error());
	}else{
			//ACREDITACIONES PERSONALIZADAS
			$contador=0;
			//recorre los tipos de acreditaciones pertenecientes a la categoria
			$resulcate2= $con->ejecutar("SELECT codtacr, codcateg FROM tipacr WHERE codcateg='".$_GET["CodCate"]."'  and codtacr<100",$idcon);
			while ($fila2 = mysql_fetch_array($resulcate2)) {
			   //si es distinto de cero
			   if ($tipoacr[$contador] != 0){
			       //busca en la tabla de cantacredita si ese contrato tiene registrados ese tipo de acreditacion si existe MODIFICA sino INCLUYE  
			       $strbuscar= $con->ejecutar("SELECT cant FROM cantacredita  WHERE  nrocontrato='$contra' and tipoacre='$fila2[codtacr]' and codcate='$catego'",$idcon);
				   $fila3 = mysql_fetch_array($strbuscar);
				   $num_buscar=mysql_num_rows($strbuscar);
				   if ($num_buscar==1){ //EXISTE
	                  $suma=$tipoacr[$contador]+$fila3[cant];
					  //MODIFICA LA CANTIDAS
	 	              $stracre = "UPDATE cantacredita SET cant='$suma' WHERE  nrocontrato='$contra' and tipoacre='$fila2[codtacr]' and codcate='$catego' ";
		              $result = $con->ejecutar($stracre,$idcon);
					}else{ //NO EXISTE
					  //INCLUYE EL TIPO DE ACREDITACION PARA ESE CONTRATO 
					  $resulCanti= $con->ejecutar("SELECT * FROM cantacredita",$idcon);
			 	      $cantidad = mysql_num_rows($resulCanti);
				      $nume=$cantidad+1;
					  $stracre = "INSERT INTO cantacredita VALUES('$nume','$contra','$fila2[codtacr]','$tipoacr[$contador]','$catego')";
				      $result = $con->ejecutar($stracre,$idcon);
					}
				}
				$contador=$contador+1;
		  }
			  //ACREDITACIONES ROTATIVAS
			  	$contadorR=0;
				//recorre los tipos de acreditaciones pertenecientes a la categoria
				$resulcate2R= $con->ejecutar("SELECT codtacr, codcateg FROM tipacr WHERE codcateg='".$_GET["CodCate"]."' and codtacr<=100",$idcon);
				while ($fila2R = mysql_fetch_array($resulcate2R)) {
				   //si es distinto de cero
				   if ($tipoacrR[$contadorR] != 0){
					   //busca en la tabla de cantacredita si ese contrato tiene registrados ese tipo de acreditacion si existe MODIFICA sino INCLUYE  
					   $strbuscarR= $con->ejecutar("SELECT cant FROM cantacredita  WHERE  nrocontrato='$contra' and tipoacre='$fila2R[codtacr]' and codcate='$catego'",$idcon);
					   $fila3R = mysql_fetch_array($strbuscarR);
					   $num_buscarR=mysql_num_rows($strbuscarR);
					   if ($num_buscarR==1){ //EXISTE
						  $sumaR=$tipoacrR[$contadorR]+$fila3R[cant];
						  //MODIFICA LA CANTIDAS
						  $stracreR = "UPDATE cantacredita SET cant='$sumaR' WHERE  nrocontrato='$contra' and tipoacre='$fila2R[codtacr]' and codcate='$catego' ";
						  $resultR = $con->ejecutar($stracreR,$idcon);
						}else{ //NO EXISTE
						  //INCLUYE EL TIPO DE ACREDITACION PARA ESE CONTRATO 
						  $resulCantiR= $con->ejecutar("SELECT * FROM cantacredita",$idcon);
						  $cantidadR = mysql_num_rows($resulCantiR);
						  $numeR=$cantidadR+1;
						  $stracreR = "INSERT INTO cantacredita VALUES('$nume','$contra','$fila2R[codtacr]','$tipoacrR[$contador]','$catego')";
						  $resultR = $con->ejecutar($stracreR,$idcon);
						}
					}
					   $contadorR=$contadorR+1;	   
				
			}
			if (!$result && !$resultR ) {
					die('Error al Insertar:'. mysql_error());
			}else{
			 js_redireccion("error.php?msn=Acreditaciones Adicionales Creadas con Exito");
			 exit;
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
