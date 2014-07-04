<?php
session_start();
if (array_key_exists('login',$_SESSION)){
/*INICIO: FUNCION QUE GENERA CONTRASE�A DE USUARIO*/
function GeneradorClavesFaciles($longitud) {

$key=""; // la clave que se generar�

$vocales='aeiou'; 
$numero_de_vocales=strlen($vocales);
$consonantes='bcdfgjklmnpqrstwxyz'; 
$numero_de_consonantes=strlen($consonantes);

while ($longitud>0) {
// Con is_int averiguamos si es un �numero entero, par o impar y lanzamos una vocal o consonante
	if (!is_int($longitud/2)) { 
	   $key=$key.substr($consonantes,rand(0,$numero_de_consonantes-1),1);
	  }else { 
		$key=$key.substr($vocales,rand(0,$numero_de_vocales-1),1);
	  }
	$longitud=$longitud-1;
}

return $key;
} 
/*FIN: FUNCION QUE GENERA CONTRASE�A DE USUARIO*/


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
    include("util.php"); 		// INCLUDE PARA LLAMAR A UNA PAGINA
	include("ControlaBD.php"); // INCLUDE PARA LA CONEXION A LA BASE DE DATO

/*INICIO: CONEXION A LA BD*/
	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");
/*FIN: CONEXION A LA BD*/
	
		$fecha   = " ";    
		$contra   = " ";
		$empre   = " ";
		$produc = " ";
		$stand    = " ";
		$cost    = " ";
		$total    = " ";

	    $fecha = $_GET["Fec"];
        $direc = $_GET["Dir"];
	    $empre = $_GET["Rif"];
	    $produc = $_GET["Pro"];
		$ramo = $_GET["Ram"];
	    $stand = $_GET["Sta"];
	    $cost = $_GET["Cos"];
	    $total = $_GET["Tot"];
	    $contra = $_GET["Cont"];
	    $ubica = $_GET["Ubi"];
	    $costo = $_GET["Cot"];
        $ncheque = $_GET["nro"];
	    $banco = $_GET["ban"];
	    $mont = $_GET["mon"];
		$catego = $_GET["Cate"];
		$tipoacr = $_GET["tipoac"];
		$totalacre=$_GET["contad"];
		$totalmax=$_GET["maxacreadi"];
		
		/*INICIO: VALIDAR MONTO */
			if ($mont==$total){
		       $pago=3;
		    }elseif ($mont<$total){
		       $pago=1;
		    }elseif  ($mont>$total){
 	           js_redireccion("error.php?msn=El Monto pagado es mayor a la Deuda"); //ENVIA A LA PAG. ERRO.PHP
			   exit;
            }
		/*FIN: VALIDAR MONTO */
		/*INICIO: VALIDAR VALOR ACREDITACIONES*/
		$contador=0;
		$totalregis=0;
		$resulcate= $con->ejecutar("SELECT codtacr,codcateg FROM tipacr WHERE codcateg='".$_GET["Cate"]."'",$idcon);
		    //RECORRE Y CUENTA PARA VALIDAR
		while ($fila = mysql_fetch_array($resulcate)) {
		  $totalregis=$totalregis+$tipoacr[$contador];
	      $contador=$contador+1;
		}
		if ($totalregis==0){
		  js_redireccion("error.php?msn=Debe Registrar cantidad de Acreditaciones");
		  exit;
		}elseif ($totalregis>$totalacre){
		  js_redireccion("error.php?msn=Las Acreditaciones superan el Maximo");
		  exit;
		}
		/*FIN: VALIDAR VALOR ACREDITACIONES */
		
	
		
  	  $result= $con->ejecutar("SELECT * FROM contrato WHERE numero='$contra'",$idcon);
	  $num_rows=mysql_num_rows($result);
 	  $row=mysql_fetch_array($result);
	  if ($num_rows==0)
	  {
	        $sireten='';
	  /*INICIO= RETENCIONES*/
		   if ($_GET["monIVA"]!=''){
		      $strtraniva = "INSERT INTO transacciones VALUES('$contra','$pago','RETENCION IVA','-','$fecha','".$_GET["monIVA"]."')";
		      $resultraniva = $con->ejecutar($strtraniva,$idcon);
			  $miva=$_GET["monIVA"];
		      $resta=$total-$mont-$miva;
			  $sireten='IVA';
		   }
		
		   if ($_GET["monISLR"]!=''){
		      $strtranislr = "INSERT INTO transacciones VALUES('$contra','$pago','RETENCION ISLR','-','$fecha','".$_GET["monISLR"]."')";
		      $resultranislr = $con->ejecutar($strtranislr,$idcon);
		      if ($sireten='IVA'){
			      $mislr=$_GET["monISLR"];
		          $resta=$resta-$mislr;
			 	  $sireten='ISLR';
			  }else{
			      $mislr=$_GET["monISLR"];
			      $resta=$total-$mont-$mislr;
			 	  $sireten='ISLR';
			  }
		   }
		   
		if ($sireten==''){
			if ($pago==3){
			     $resta=0;
			}else{
			   $resta=$total-$mont;
			}
		}
		
		/*FIN: RETENCIONES*/
			/*INICIO: VALIDAR NUMERO DE VOUCHER*/
	    $resultChe= $con->ejecutar("SELECT * FROM transacciones WHERE nrocheque='$ncheque'",$idcon);
  	    $num_cheque=mysql_num_rows($resultChe);
	    if ($num_cheque == 1){
            js_redireccion("error.php?msn=N&uacute;mero de Cheque Invalido");
		    exit;
		}
		/*FIN: VALIDAR NUMERO DE CHEQUE*/
		
		$strsql = "INSERT INTO contrato VALUES('$Rif','$contra','$fecha','$produc','$stand','$total','$resta','$pago','$ramo','$totalacre','$totalmax','0','0','$usuario')";
		$resultbusq = $con->ejecutar($strsql,$idcon);

		$strtran = "INSERT INTO transacciones VALUES('$contra','$pago','$ncheque','$banco','$fecha','$mont')";
		$resultran = $con->ejecutar($strtran,$idcon);
		
			
		// INICIO: MODIFICAR EL STAND COMO VENDIDO
		$separar_cadena = explode(',',$stand);
	    $cantidadventa=count($separar_cadena);		
		for($i=0;$i<count($separar_cadena); $i++)
		{
		
			$resu= $con->ejecutar("SELECT status FROM stand WHERE codstand='$separar_cadena[$i]'",$idcon);
			$num_rows=mysql_num_rows($resu);
			$row=mysql_fetch_array($resu);
			if ($num_rows==1)
			{
				   $str = "UPDATE stand SET status='vendido' WHERE  codstand='$separar_cadena[$i]'";
				   $result = $con->ejecutar($str,$idcon);
			}
		
		}
		// FIN: MODIFICAR EL STAND COMO VENDIDO
		
		/*INICIO:GENERA CLAVE DE USUARIO*/
		$Usuempresa=$_GET["Rif"];
		$buscar= $con->ejecutar("SELECT rifemp,clave FROM login WHERE usuario='$Usuempresa'",$idcon);
		$num_buscar=mysql_num_rows($buscar);
		$row_buscar=mysql_fetch_array($buscar);
		
		if ($num_buscar==0){
		   $Claempresa=GeneradorClavesFaciles(8);
		   $strsql = "INSERT INTO login (usuario,clave,codtipo,nombre,rifemp) VALUES('$Usuempresa','$Claempresa','10','".$_GET['Nom']."','$Usuempresa')";
		   $resultbusq = $con->ejecutar($strsql,$idcon);
		 }else{
			$Claempresa=$row_buscar[clave];
		 }
	
	    /*FIN: GENERA CLAVE DE USUARIO*/
		
		/*INICIO: MODULO DE GUARDAR NUMERO DE ACREDITACIONES (TIPO ACRED.) */
		$contador=0;
		  	$resulcate2= $con->ejecutar("SELECT codtacr,codcateg FROM tipacr WHERE codcateg='".$_GET["Cate"]."'",$idcon);
			//RECORRE PARA INSERTAR LOS DISTINTOS DE 0
			while ($fila2 = mysql_fetch_array($resulcate2)) {
			   if ($tipoacr[$contador]!=0 || $tipoacr[$contador]!="" ){
			      $resulCanti= $con->ejecutar("SELECT * FROM cantacredita",$idcon);
			 	  $cantidad = mysql_num_rows($resulCanti);
				  $nume=$cantidad+1;
			      $stracre = "INSERT INTO cantacredita VALUES('$nume','$contra','$fila2[codtacr]','$tipoacr[$contador]','$catego')";
				  $resulacre = $con->ejecutar($stracre,$idcon);
				 }
			   $contador=$contador+1;
		
			}
		
      /*FIN: MODULO DE GUARDAR NUMERO DE ACREDITACIONES (TIPO ACRED.) */

	
	    // INICIO: OBTENER DESCRIPCION Y TOTAL METROS CUADRADOS
		$resu1= $con->ejecutar("SELECT metros,descrip FROM ubicacion WHERE codubi='$ubica'",$idcon);
		$row=mysql_fetch_array($resu1);
		$descrip=$row['descrip'];
		$areatotal=$row['metros']*$cantidadventa;
	    // FIN: OBTENER DESCRIPCION Y TOTAL METROS CUADRADOS

		
		if (!$resultbusq) {
			die('Error al Insertar:'. mysql_error());
		}else{
		   echo '<div align="center">
           <strong>
	          <font face="Arial, Helvetica, sans-serif">
		       <span>
		         <font size="4">
			       <font color="#FF6600">
		             <br>El Registro insertado exitosamente....
		             <br>
			       </font>
			    </font>
		     </span>
		    </font>
	      </strong>
         </div>';	
		}
	}else{
	// CONTRATO YA EXISTE
	     /*INICIO: ENVIAR CLAVE DE USUARIO REGISTRADO PARA REPORTE*/
		$Usuempresa=$_GET["Rif"];
		$buscar= $con->ejecutar("SELECT rifemp,clave FROM login WHERE usuario='$Usuempresa'",$idcon);
		$num_buscar=mysql_num_rows($buscar);
		$row_buscar=mysql_fetch_array($buscar);
		
		if ($num_buscar==1){
			$Claempresa=$row_buscar[clave];
		 }
	
	    /*FIN: ENVIAR CLAVE DE USUARIO REGISTRADO PARA REPORTE*/

		   echo '<div align="center">
           <strong>
	          <font face="Arial, Helvetica, sans-serif">
		       <span>
		         <font size="4">
			       <font color="#FF6600">
		             <br>Contrato Registrado....
		             <br>
			       </font>
			    </font>
		     </span>
		    </font>
	      </strong>
         </div>';	
		}
	
	
	  echo "<FORM METHOD='GET' action='recibo.php' name='formato'>
            <table align='center'>
		     <tr>
		      <td>
			  <input type=hidden name='Des' id='Des' value='$descrip'>
			  <input type=hidden name='Are' id='Are' value='$areatotal'>
			  <input type=hidden name='Tot' id='Tot' value='".$_GET["Tot"]."'>
			  <input type=hidden name='Sta' id='Sta' value='".$_GET["Sta"]."'>
			  <input type=hidden name='Dir' id='Dir' value='".$_GET["Dir"]."'>
			  <input type=hidden name='Fec' id='Fec' value='".$_GET["fecha"]."'> 
			  <input type=hidden name='Nom' id='Nom' value='".$_GET["Nom"]."'>
			  <input type=hidden name='Rif' id='Rif' value='".$_GET["Rif"]."'>
			  <input type=hidden name='Pro' id='Pro' value='".$_GET["Pro"]."'>
		      <input type=hidden name='Ram' id='Ram' value='".$_GET["Ram"]."'>
			  <input type=hidden name='No' id='No' value='".$_GET["Cont"]."'>

  		      <input type=hidden name='Usu' id='Usu' value='$Usuempresa'>
			  <input type=hidden name='Cla' id='Cla' value='$Claempresa'>
			  
			  <input type=hidden name='Ubi' id='Ubi' value='$ubica'>
			  
			  <input type=hidden name='NroB' id='NroB' value='$ncheque'>
			  <input type=hidden name='Ba' id='Ba' value='$banco'>
			  <input type=hidden name='MoB' id='MoB' value='$mont'>
              <input name=button type=submit value='Ver Recibo'>
					
		      </td>
			 
		         </tr>
		   </table>		   
		   
	   </form>";


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