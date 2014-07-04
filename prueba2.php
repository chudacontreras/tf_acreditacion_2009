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
           var Nro = document.formato.nro.value; 
           var Ban  = document.formato.ban.value;
		   var Mon   = document.formato.mon.value;
		   var total = document.formato.Tot.value;
		   var acredi= document.formato.tipoac;
		  // var resultado = Mon < total; 
           if ((isNaN(Nro)==true) || (Nro == ''))
           {
                   alert("N&uacute;mero de deposito no V&aacute;lido");
                   return false;
           }
		   
		   if (Ban == '')
           {
                   alert("Nombre del Banco no V&aacute;lido");
                   return false;
           }
          if((isNaN(Mon)==true) || (Mon=="")){
              alert("Monto no V&aacute;lido");
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
		          <br>Resultado de la Comercializaci&oacute;n
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
  
  $costo=$_GET["ckbox"];
  $cedula=$_GET["Rif"];
  $catego=$_GET["Cate"];
  
  $resul= $con->ejecutar("SELECT nombre,direccion FROM empresa WHERE rif='$cedula'",$idcon);
  $fila = mysql_fetch_array($resul);
 // $iva=$fila[retensoriva];

	if (array_key_exists('ckbox', $_GET))
	{
	$cant=1;
		$ckbox=$_GET["ckbox"][0];
		for ($i=1; $i<count($_GET["ckbox"]); $i++)
		{
			 $ckbox.=",".$_GET["ckbox"][$i];
			 $cant=$cant+1;
		} 
	}

	$cost=$_GET["Cot"];

    include("util.php");
    if ($cant==0){
	 js_redireccion("error.php?msn=Debe seleccionar un Stand");
    }
//	$multiplica=$cost*$cant;

	

?>
  <FORM METHOD="GET" action="guardarcontra.php" name="formato" onSubmit="return comprobar()">
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
		<td valign="top"><?php
			echo "<input name='Fec' id='Fec' value='".$_GET["fecha"]."' type='text' style='WIDTH: 80px; HEIGHT: 21px' readonly='yes'/>"; 
			?>		</td>
	<td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
        </tr>
  <tr>
  		<td height="24"></td>
		<td valign="top">N. de Contrato</td>
		<td>&nbsp;</td>
		<td colspan="3" valign="top"><?php
			echo "<input name='Cont' id='Cont' value='".$_GET["Cont"]."' type='text' style='WIDTH: 80px; HEIGHT: 21px' readonly='yes'/>"; 
			?>		</td>
	
	    
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
		<td colspan="3" valign="top"><?php
			echo "<input name='Rif' id='Rif' value='".$_GET["Rif"]."' type='text' style='WIDTH: 80px; HEIGHT: 21px' readonly='yes'/>"; 
			?>		</td>
	<td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
        </tr>
    <tr>
			<td height="21">&nbsp;</td>
	<td valign="top">Empresa</td>
	    <td colspan="5" valign="top"><?php
                    echo "<input name='Nom' id='Nom' value='".$_GET["Nom"]."' type='text' style='WIDTH: 400px; HEIGHT: 21px' readonly='yes'/>"; 
                    ?>		</td>
        <td>&nbsp;</td>
        </tr>
<tr>
		<td height="21">&nbsp;</td>
				<td valign="top">Direccion</td>
				<td colspan="5" valign="top">
			      <?php
                    echo "<input name='Dir' id='Dir' value='".$_GET["Dir"]."' type='text' style='WIDTH: 400px; HEIGHT: 21px' readonly='yes'/>"; 
                 ?>				</td>
                <td>&nbsp;</td>
            </tr>
			<tr>
					<td height="21"></td>
				<td valign="top">Productos</td>
				<td colspan="5" valign="top"><?php
                    echo "<input name='Pro' id='Pro' type='text' value='".$_GET["produc"]."' style='WIDTH: 400px; HEIGHT: 21px' readonly='yes'/>"; 
                 ?>			  </td>
		        <td>&nbsp;</td>
			</tr>
			<tr>
				<td height="21"></td>
				<td valign="top">Ramo</td>
				<td colspan="5" valign="top"><?php
                    echo "<input name='Ram' id='Ram' type='text' value='".$_GET["Ram"]."' style='WIDTH: 400px; HEIGHT: 21px' readonly='yes'/>"; 
                 ?>			  </td>
		        <td>&nbsp;</td>
			</tr>
			<tr>
				<td height="21"></td>
				<td valign="top">Categoria</td>
				<td colspan="5" valign="top"><?php
				  $resulcate= $con->ejecutar("SELECT descrip FROM categoria WHERE codcate='".$_GET["Cate"]."'",$idcon);
                  $fila = mysql_fetch_array($resulcate);

                    echo "<input type=hidden name='Cate' id='Cate' value='".$_GET["Cate"]."'>
					<input name='Cate1' id='Cate1' type='text' value='$fila[descrip]' style='WIDTH: 400px; HEIGHT: 21px' readonly='yes'/>"; 
                 ?>			  </td>
		        <td>&nbsp;</td>
			</tr>
			<tr>
			  <td height="21"></td>
			  <td valign="top">Stand</td>
			  <td colspan="5" valign="top"><?php
                    echo "<input type=hidden name='Cot' id='Cot' value='".$_GET["Cot"]."'>
					<input type=hidden name='Ubi' id='Ubi' value='".$_GET["Ubi"]."'>
					<input type=hidden name='Sta' id='Sta' value='$ckbox'>
					<textarea rows='1' readonly='readonly' cols='46'>$ckbox</textarea>"; 
                 ?>	
	          <td>
			  </td>
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
	<?php 
	   // $multiplica=0;
	    $separar_cadena = explode(',',$ckbox);
		$cantidadventa=count($separar_cadena);
		$totalacredi=0;   
		$maxacredi=0;    		
		for($i=0;$i<count($separar_cadena); $i++){
		
		$resu= $con->ejecutar("SELECT costo,codubi FROM stand WHERE codstand='$separar_cadena[$i]'",$idcon);
			$num_rows=mysql_num_rows($resu);
			$row=mysql_fetch_array($resu);
			if ($row[costo]!=0){ //para cuando el stand tiene un precio distinto al de su ubicacion
			     $resulCosto= $con->ejecutar("SELECT costo,preventa,fechainicio,fechafin,nroacredi,maxacred FROM ubicacion WHERE codubi='$row[codubi]'",$idcon);
				 $fila0 = mysql_fetch_array($resulCosto);
			
			      //PARA  RETENSOR DE IVA EN EL CASO QUE EL STAND TENGA UN PRECIO DISTINTO AL DE SU UBICACION
				/*  if ($iva==1){
				     $x=$row[costo]/1.09; //x es precio sin iva
					 $z=$row[costo]-$x;
					 $costoiva=$x+($z*0.75);
					 $multiplica=$multiplica+$costoiva;
				  }else{*/
				     $multiplica=$multiplica+$row[costo];
				//  }
				  
			}else
			{
				$resulCosto= $con->ejecutar("SELECT costo,preventa,fechainicio,fechafin,nroacredi,maxacred FROM ubicacion WHERE codubi='$row[codubi]'",$idcon);
				$fila0 = mysql_fetch_array($resulCosto);
			
			    $fecha=date("Y-m-d", mktime(0, 0, 0, date("m") , date("d"), date("Y")));
			    if (($fecha>=$fila0[2]) and ($fecha<=$fila0[3]))
				{
			       $valor=$fila0[1];
				}
				else
				{
   				  $valor=$fila0[0];
			    }
			/*	//PARA RETENSOR DE IVA EN EL CASO DE QUE TOME EL PRECIO DE LA UBICACION
				  if ($iva==1){
				     $x=$valor/1.09; //x es precio sin iva
					 $z=$valor-$x;
					 $costoiva=$x+($z*0.75);
					 $multiplica=$multiplica+$costoiva;
				  }else{*/
				     $multiplica=$multiplica+$valor;
				//  }
	  }
			$totalacredi=$totalacredi+$fila0[nroacredi];
			$maxacredi=$maxacredi+$fila0[maxacred];
			$totalmulti=$multiplica;
			
			 echo "<td><input type=hidden name=maxacreadi id=maxacreadi value='$maxacredi'></td>"; 
		}
		echo "
		<tr>
		 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		 <td>Acreditaciones Disponibles</td>
		 <td><input type=text name=contad id=contad value='$totalacredi' readonly='yes' style='WIDTH: 100px; HEIGHT: 21px'></td></tr>"; 
       ?>
	<tr>
	   	<td height="40">&nbsp;</td>
	    <td valign="top">&nbsp;&nbsp;&nbsp; Total a Cancelar</td>
	<td valign="top" ><?php 
	 $monto = number_format($multiplica,2,',','.');
	echo "<input type=hidden name=Tot id=Tot value='$totalmulti'>";
	echo"<input name='To2t' id='To2t' type='text' value='$monto' style='WIDTH: 100px; HEIGHT: 21px' readonly='yes'/>"; 
	
	if ($iva==1){
	     echo" Total con 75% sobre el iva";
	}
         ?>	
		 </td>
	</tr>
 </table>
  <table border="0" align=center>
    <tr>
     <td colspan="15" align="center"><strong>Cantidad de Acreditaciones</strong></td>
  </tr>
  
  <tr>
      <td>&nbsp;</td>
  <td>&nbsp;</td>
 
 <?php
 $contador=0;
 $resulcate= $con->ejecutar("SELECT codtacr,descrip,codcateg FROM tipacr WHERE codcateg='".$_GET["Cate"]."'",$idcon);
				
		while ($fila = mysql_fetch_array($resulcate)) {
		   echo "<tr>";
		   echo "<td>$fila[descrip]</td>";
		   echo "<td><input type=text name=tipoac[$contador] id=tipoac[$contador]></td>"; 
		   echo "</tr>";
           $contador=$contador+1;
		}
         $contador=$contador-1;

?>
<td>&nbsp;</td>
  <td>&nbsp;</td>
  </table>
 <table border="1" align=center>
 <tr><td>
   <table border="0" align=center>
   <tr>
     <td colspan="15" align="center"><strong>Forma de Pago</strong></td>
  </tr>
  
  <tr>

	  <td>Nro Deposito <br> <input type="text" name="nro" id="nro" size="15"></td>
	  <td>Banco <br> <input type="text" name="ban" id="ban" size="15"></td>
	  <td>Monto <br> <input type="text" name="mon" id="mon" size="15"></td>
  </tr>
  <tr>
  <td>Retencion <br> <input type="text" name="reten" id="reten" size="15" value="RETENCION" readonly="yes"></td>
  <td>Reten IVA <br> <input type="text" name="monIVA" id="monIVA" size="15"></td>
	   </tr>
<tr>
  <td>Retencion <br> <input type="text" name="reten" id="reten" size="15" value="RETENCION" readonly="yes"></td>
  <td>Reten ISLR <br> <input type="text" name="monISLR" id="monISLR" size="15"></td>
	   </tr>
	    <tr>
	   <td>&nbsp;</td>	
	  </tr>
 <tr>
	 <td height="21" colspan="15" valign="top" align=center><?php
	    $ced=$_GET["prueba2"];
		$pru=$fila[0];
         echo "<input name=button type=submit value='Guardar'>";
           ?>
		 </td>
	  </tr>
  </table>
 </tr></td> </table>  
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