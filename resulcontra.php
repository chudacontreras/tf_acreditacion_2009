<?php
session_start();
if (array_key_exists('login',$_SESSION)){
  include("util.php");
  if (!$_GET["Emp"]){
	 js_redireccion("error.php?msn=Debe seleccionar una Empresa");
  }
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
		          <br>Consultar Contrato
		          <br>
			   </font>
			 </font>
		</span>
		</font>
	</strong>
  </div>
<?php
  $rif=$_GET["Nac"].$_GET["Rif"];
  $emp=$_GET["Emp"];
  
  
include("ControlaBD.php");

			    $con   = new ControlaBD();
				$idcon = $con->conectarSBD();
				$sel_bd= $con->select_BD("tf_comercializacion");
				$entro=0;
				
 echo '<form  name="formulario" action="puente.php" METHOD="GET"> 	
				<table align="center" cellspacing="2" cellpadding="2" border="0" class="texto">
						   <tr>
								<td colspan=7 align="center">
								</tr>
						<tr bgcolor="#E5E5E5">
								<th width=20>&nbsp;</th>
								<th width=80>Contrato</th>
								<th width=150>Stand</th>
								<th width=50>Status</th>
								<th width=120>Resta</th>
								<th width=120>Total</th>
							</tr>';
	
   		 $resulCont= $con->ejecutar("SELECT numero,fecha,stand,total,resta,Statu FROM contrato WHERE rif='$emp' and Statu!='4' and numero like '%FB07%'",$idcon);
		 $num_rows=mysql_num_rows($resulCont);
		   if ($num_rows>=1){
					while ($fila = mysql_fetch_array($resulCont)) {
						echo "<tr>";
						echo "<td width=20><input type='Radio' name='Cont' id='Cont' VALUE=$fila[numero] onclick='HacerAccion()'></td>";
						echo "<td align=center width=80>$fila[numero]</td>";
						echo "<td align=center width=150>$fila[stand]</td>";
						
					if ($fila[Statu]=='3'){
					   $sta='Cancelado';
					}elseif ($fila[Statu]=='1') {
					   $sta='Inicial';
					}elseif ($fila[Statu]=='2') {
					   $sta='Abono';
					}
						echo "<td align=center width=50>$sta</td>";
						$val = number_format($fila[resta],2,',','.'); 
						echo "<td align=center width=120>$val</td>";
						$val = number_format($fila[total],2,',','.'); 
						echo "<td align=center width=120>$val</td>";
						echo "<td><input type='hidden' name='Cont2' id='Cont2' VALUE=$fila[numero]></td>";
						echo "<td><input type='hidden' name='tota' id='tota' VALUE=$fila[total]></td>";
						
					}// Fin del While interno
		//ojo aqui va el boton de acreditaciones adicionales
		echo" 
				<tr>&nbsp;</tr>
				<tr>&nbsp;</tr>
				<tr>&nbsp;</tr>
				<tr>&nbsp;</tr>
				<tr>&nbsp;</tr>
				<tr>&nbsp;</tr>
	
		<tr>
		<td>
			<input type=hidden name='rif' id='rif' VALUE=$emp >
		</td>

	   <td colspan=7 align='center'><input type='submit' name='test' value='Ver Pagos' >
				                
									
		</td>
		
		</tr>";
//		    <input type='submit' name='test' value='Acreditaciones Adicionales'>
//		<input type='submit' name='test' value='Eliminar'>
		}else{
		
		echo '<div align="center">
      <strong>
	    <font face="Arial, Helvetica, sans-serif">
		   <span>
		     <font size="4">
			   <font color="#FF6600">
		          <br>La Empresa no tiene Contratos Activos....
		          <br>
			   </font>
			 </font>
		</span>
		</font>
	</strong>
  </div>';
		
		}
			
	echo'</table>
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
