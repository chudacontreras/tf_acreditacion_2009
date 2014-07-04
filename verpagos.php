<?php
session_start();
if (array_key_exists('login',$_SESSION)){
  include("ControlaBD.php");
  include("util.php");
    $cont=$_GET["cont"];
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
		          <br>Pagos Realizados
		          <br>
			   </font>
			 </font>
		</span>
		</font>
	</strong>
  </div>
<?php
 //$cont=$_POST["Cont"];
  //$total=$_POST["tota"];
  $cont=$_GET["cont"];
  //$total=$_GET["total"];

			    $con   = new ControlaBD();
				$idcon = $con->conectarSBD();
				$sel_bd= $con->select_BD("tf_comercializacion");

echo '<form  name="formulario" METHOD="GET" action="puente.php"> 	
<table align="center" cellspacing="2" cellpadding="2" border="0" class="texto">
	       <tr bgcolor="#E5E5E5">
				<th width=80>Status</th>
				<th width=100>No. del Cheque</th>
				<th width=100>Banco</th>
				<th width=100>Fecha</th>
				<th width=100>Monto</th>
			</tr>';
     	 $resul= $con->ejecutar("SELECT total FROM contrato WHERE numero='$cont'",$idcon);
		 $row=mysql_fetch_array($resul);
		 $total=$row[total];
	
   		 $resulCont= $con->ejecutar("SELECT codstatus,nrocheque,banco,fecha,monto FROM transacciones WHERE nrocontrato='$cont'",$idcon);
		 $num_rows=mysql_num_rows($resulCont);
		 $acum=0;
					while ($fila = mysql_fetch_array($resulCont)) {
				   if ($fila[codstatus]=='3') {
					   $sta='Cancelado';
					}elseif ($fila[codstatus]=='2') {
					   $sta='Abono';
					}
					elseif ($fila[codstatus]=='1') {
					   $sta='Inicial';
					}
						echo "<tr>";
					echo "<td width=80>$sta</td>";
						echo "<td align=center width=100>$fila[nrocheque]</td>";
						echo "<td align=center width=100>$fila[banco]</td>";
						echo "<td align=center width=100>$fila[fecha]</td>";
						$acum=$acum+$fila[monto];
						$val = number_format($fila[monto],2,',','.'); 
					    echo "<td align=center width=100>$val</td>";
						echo "<td><input type='hidden' name='Cont' id='Cont' VALUE='$cont'>
						<input type='hidden' name='tot' id='tot' VALUE='$total'></td>
							<input type='hidden' name='acum' id='acum' VALUE='$acum'></td>";
						
					}
					if ($acum<$total){
					  	echo"
							<tr>&nbsp;</tr>
							<tr>&nbsp;</tr>
							<tr>&nbsp;</tr>
							<tr>&nbsp;</tr>
							<tr>&nbsp;</tr>
							<tr>&nbsp;</tr>
	
							<tr>
							  <td colspan=7 align='center'><input type='submit' name='test' value='Realizar Pago' >
							  </td>
							</tr>";
					}
					echo"<tr>
						  <td colspan=3 align='center'>
							  <input type='submit' name='test' value='Ver Anexo A'>
						  </td>

							  <td colspan=2 align='center'>
							  <input type='submit' name='test' value='Ver Recibo'>
							  </td>
							</tr>";
		echo"
		<tr>
		<td>
				<input type=hidden name='rif' id='rif' VALUE=$rif >
		</td>

	</tr>";
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
