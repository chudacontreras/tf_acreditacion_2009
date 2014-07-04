<?php
session_start();
if (array_key_exists('login',$_SESSION)){
 include("util.php");
    $cont=$_GET["Cont"];
  if (!$cont){
	 js_redireccion("error.php?msn=Debe seleccionar un Contrato");
	 exit;
  }
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
		          <br>Acreditaciones Adicionales
		          <br>
			   </font>
			 </font>
		</span>
		</font>
	</strong>
  </div>
   <FORM METHOD="GET" action="guardaradicionales.php" name="formulario">
  <?php

	include("ControlaBD.php");

	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");
	?>
   <table align="center" cellspacing="2" cellpadding="2" border="0" class="texto">
		   <tr>
				<td>Categoria</td>
			    <td valign="top"><?php
				    //Busca el contrato y retorna el rif de la empresa o cedula del representante de la comision
				    $result= $con->ejecutar("SELECT rif,totalacred FROM contrato where numero='".$_GET[Cont]."'",$idcon);
					$row = mysql_fetch_array($result);
					
				    //Busca el rif de la empresa o cedula del representante de la comision y retorna el cod. de la categoria
					$resultempre= $con->ejecutar("SELECT categoria FROM empresa where rif='$row[rif]'",$idcon);
					$rowempre = mysql_fetch_array($resultempre);

				    //Busca el cod. de la categoria  y retorna la descripcion
					$resultcate= $con->ejecutar("SELECT descrip FROM categoria where codcate='".$rowempre[categoria]."'",$idcon);
					$rowcate = mysql_fetch_array($resultcate);
					
					echo '<input name="Cat" type="text" id="Cat"  style="WIDTH: 200px; HEIGHT: 22px" value="'.$rowcate['descrip'].'" readonly="yes" />';
					echo '<input name="CodCate" type="hidden" id="CodCate" value="'.$rowempre[categoria].'"/>';
					echo '<input name="Contra" type="hidden" id="Contra" value="'.$_GET[Cont].'"/>';
                        
		        ?>
				</td>
			</tr>
			
	<?php
	   echo "<tr>";
	   echo "<td>&nbsp;</td>";
	   echo "</tr>";
	   echo "<tr>";
	   echo "<td colspan=2 valign=top align=center>ACREDITACIONES DISPONIBLES</td>";
	   echo "</tr>";
	   echo "<tr>";
	   echo "<td>&nbsp;</td>";
	   echo "</tr>";
	   //muestra la acreditaciones q tiene registradas
   	    $resulcate1= $con->ejecutar("SELECT descrip,codtacr FROM tipacr WHERE codcateg='$rowempre[categoria]'",$idcon);
   		 while ($fila1 = mysql_fetch_array($resulcate1)) {
  	       $resulcanta= $con->ejecutar("SELECT cant FROM cantacredita WHERE nrocontrato='".$_GET["Cont"]."' and tipoacre='$fila1[codtacr]'",$idcon);
	       $cantidad = mysql_fetch_array($resulcanta);
	       $num_canti=mysql_num_rows($resulcanta);
		    if  ($cantidad[cant]!='' or $cantidad[cant]!=0 ){
			   echo "<tr>";
			   echo "<td>$fila1[descrip]</td>";
			   echo "<td colspan=2 valign=top align=center><input name='CodCate2' type='text' id='CodCate2' style='WIDTH: 200px; HEIGHT: 22px' value='$cantidad[cant]' readonly='yes'/></td>";
			   echo "</tr>";
		    }

	  }
		//muestra todos los tipo de acreditaciones por la categoria a la q pertenece y permite registrar cantidades adicionales
		// de personalizadas
		  echo "<tr>";
		   echo "<td>&nbsp;</td>";
		   echo "</tr>";
		   echo "<tr>";
		   echo "<td colspan=2 valign=top align=center>ACREDITACIONES ADICIONALES PERSONALIZADAS</td>";
   		   echo "</tr>";
	       echo "<tr>";
		   echo "<td>&nbsp;</td>";
   		   echo "</tr>";
        $resulcate= $con->ejecutar("SELECT codtacr,descrip,codcateg FROM tipacr WHERE codcateg='$rowempre[categoria]' and codtacr<100 ",$idcon);
		$contador=0;
		while ($fila = mysql_fetch_array($resulcate)) {
		   echo "<tr>";
		   echo "<td>$fila[descrip]</td>";
		   echo "<td><input type=text name=tipoac[$contador] id=tipoac[$contador] style='WIDTH: 200px; HEIGHT: 22px'></td>"; 
		   echo "</tr>";
           $contador=$contador+1;
		}
         $contador=$contador-1;
		 
		 //para acreditaciones Adicionales Rotativas
		 //muestra todos los tipo de acreditaciones por la categoria a la q pertenece y permite registrar cantidades adicionales
		// de personalizadas
		  echo "<tr>";
		   echo "<td>&nbsp;</td>";
		   echo "</tr>";
		   echo "<tr>";
		   echo "<td colspan=2 valign=top align=center>ACREDITACIONES ADICIONALES ROTATIVAS</td>";
   		   echo "</tr>";
	       echo "<tr>";
		   echo "<td>&nbsp;</td>";
   		   echo "</tr>";
        $resulcateR= $con->ejecutar("SELECT codtacr,descrip,codcateg FROM tipacr WHERE codcateg='$rowempre[categoria]' and codtacr>=100 ",$idcon);
		$contadorR=0;
		while ($filaR = mysql_fetch_array($resulcateR)) {
		   echo "<tr>";
		   echo "<td>$filaR[descrip]</td>";
		   echo "<td><input type=text name=tipoacR[$contadorR] id=tipoacR[$contadorR] style='WIDTH: 200px; HEIGHT: 22px'></td>"; 
		   echo "</tr>";
           $contadorR=$contadorR+1;
		}
         $contadorR=$contadorR-1;
		 ?>
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


