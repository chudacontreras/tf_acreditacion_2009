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
  <td height="600px" width="250px" bgcolor="#DADADA">
  <div class="tabConte" id="tabConte" style="height:550px; overflow:hidden">
   <a name="inicio">&nbsp;</a>
  <div align="center">
      <strong>
	    <font face="Arial, Helvetica, sans-serif" size="4" color="#FF6600">
		          <br>&Aacute;reas a Comercializar
		          <br>
		</font>
	</strong>
  </div>
    <FORM METHOD="GET" action="prueba2.php" name="formato">
  <table>
  <tr>
  <td><div style="border: 1px #0066FF; width: 500px; float: left; height:600px;	overflow:auto;">   
		
		 <table width=500 border=0 align=center>
		    <tr>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
			</tr>
			<tr bgcolor="#E5E5E5">
				<th width="200">Ubicaci&oacute;n</th>
				<th width="80">M&sup2; Aprox.</th>
				<th width="100">Costo</th>
				<th width="50">Disponible</th>
			</tr>
			<?php
		//	$pru=$_GET["Rif"];
		//	$prod=$_GET["Pro"];
		//	$ramo=$_GET["Ram"];
		//	$accion=$_GET["tipo"];
			//$Cont=$_GET["Cont"];
			//$Direc=$_GET["Dir"];
			//$empre=$_GET["Nom"];
		    //$catego=$_GET["Cate"];
				include("ControlaBD.php");
			    $con   = new ControlaBD();
				$idcon = $con->conectarSBD();
				$sel_bd= $con->select_BD("tf_comercializacion");

				$resulUbi= $con->ejecutar("SELECT * FROM ubicacion",$idcon);
					while ($fila = mysql_fetch_array($resulUbi)) {
						echo "<tr>";
						echo "<td width=200>$fila[1]</td>";
						echo "<td align=center width=50>$fila[2]</td>";
						$fecha=date("Y-m-d", mktime(0, 0, 0, date("m") , date("d"), date("Y")));
						if (($fecha>=$fila[6]) and ($fecha<=$fila[7])){
						    $valor=$fila[5];
							}else{
							$valor=$fila[4];
							}
							
						echo "<td align=center>$valor</td>";
						$ubica="$fila[0]";
						$resulStan= $con->ejecutar("SELECT status FROM stand WHERE codubi='$ubica' and status='Activo'",$idcon);
						$cant=mysql_num_rows($resulStan);
						echo "<td align=center>$cant</td>";
						$numer=$_GET["Cont"]; 
						//	echo "<td><INPUT TYPE=hidden NAME=Cont id=Cont VALUE=$numcont></td>"; 
						//	echo "<td><INPUT TYPE=hidden NAME=pru id=pru VALUE=$fila[0]></td>"; 
							echo "<td align=center><a href='#$ubica'>Vender</a></td>";
							//echo "<td align=center><a href='prueba.php?q=$fila[0]&amp;Rif=$pru&amp;Prod=$prod&amp;Ram=$ramo&amp;tipo=$accion&amp;Cont=$Cont&amp;Dir=$Direc&amp;Nom=$empre'>Vender</a>
						
						echo "</tr>";	
								
							}
							 echo "
			<tr>
			  <td height=35 colspan=8 valign=top align=center>
                <input name=button type=submit value='Realizar  Venta'>				
			  </td>
		    </tr>";	
				 
			?>
		</table>
  </div></td>
  </tr>
  <tr>
  <td>	
	<?	
	$resulargo= $con->ejecutar("SELECT * FROM ubicacion",$idcon);
	//$fila0 = mysql_fetch_array($resulargo);
	while ($fila = mysql_fetch_array($resulargo)) {
	$dato =  $fila[0];
	?>
	
	<table width=500 align="center" cellspacing="2" cellpadding="2" border="0" class="texto">
  <!--DWLayoutTable-->
			
			<?	$resulCosto= $con->ejecutar("SELECT costo,preventa,fechainicio,fechafin,descrip,codubi FROM ubicacion WHERE codubi='$dato'",$idcon);
			$fila0 = mysql_fetch_array($resulCosto);
			echo "<a name='$fila0[codubi]'> </a>";
			echo "<center><b><font face='Arial, Helvetica, sans-serif' size='4' color='#FF6600'>$fila0[descrip]</font></b></center>";
			?>  
           <tr bgcolor="#E5E5E5">
				<th width="100">Venta</th>
				<th width="100">Codigo de Stand</th>
			</tr>
		<?php

			$fecha=date("Y-m-d", mktime(0, 0, 0, date("m") , date("d"), date("Y")));
			if (($fecha>=$fila0[2]) and ($fecha<=$fila0[3])){
			    $valor=$fila0[1];
				}else{
   				$valor=$fila0[0];
			}
			//echo "<INPUT TYPE=hidden NAME=Cot id=Cot value='$valor'>"; 			
			 	
			$resulStan= $con->ejecutar("SELECT codstand,status FROM stand WHERE codubi='$dato' and status='Activo' ORDER BY codstand",$idcon);
				echo "<tr>";
				echo "<td colspan=2>";
				echo "<div style='border: 1px #0066FF; width: 530px; float: left; height:400px;	overflow:auto;'>";				
				echo "<table border='0' width='100%'>";
			$num_rows=mysql_num_rows($resulStan);
			if ($num_rows>0){				
					while ($fila = mysql_fetch_array($resulStan)) {
					   echo "<tr>";
					   echo "<td><input type=checkbox name=ckbox[] id=ckbox[] value=$fila[0]></td>"; 
					   echo "<td align=center>$fila[0]</td>";
					   echo "</tr>";
					}
			}else{
			 echo'			 
			<tr>
			  <td height=35 colspan=2 valign=top align=center>
			  <font face="Arial, Helvetica, sans-serif" size="2" color="#FF6600">
                <strong>No hay Stand Disponibles para la venta</strong>	
				</font>		
			  </td>
		    </tr>';
			}								
					echo "</table>";
				echo "</div>";	
				echo "</td>";
				echo "</tr>";						
			$num_rows=mysql_num_rows($resulStan);
			if ($num_rows>0){	
			 echo "
			<tr>
			  <td height=35 colspan=2 valign=top align=center>
                <input name=button type=submit value='Realizar  Venta'>				
			  </td>
		    </tr>";	
			}else{
			 echo "
			<tr>
			  <td height=35 colspan=2 valign=top align=center>
                &nbsp;			
			  </td>
		    </tr>";			
			}
			 echo "
			<tr>
			  <td height=35 colspan=2 valign=top align=center>
                <A href='#inicio'>Volver</a><br><br><br><br>			
			  </td>
		    </tr>";			
			 $resulContra= $con->ejecutar("SELECT * FROM contrato where numero like '%LTF09%'",$idcon);
			 
			 $canti = mysql_num_rows($resulContra);
			
          if ($accion==0){
    		if  ($canti==0){
			     $numcontra='LTF09'.'0001';
			 }
			else{
            
			$numero=$canti+1;
			$num=$numero;
			$cifra=4;
			$Cifra_num=strlen($num);
			$nuevonumero="";
			for($i=$Cifra_num;$i<$cifra;$i++){
				$nuevonumero.=0;
			
			}
			$nuevonumero.=$num;
			$numcontra='LTF09'.$nuevonumero;



			}
		}else
		{
		$numcontra=$_GET["Cont"];
		}
			
	}
		?>
	<?php
	$fecha=date("Y-m-d", mktime(0, 0, 0, date("m") , date("d"), date("Y")));
	echo "<INPUT TYPE=hidden NAME=produc id=produc value='".$_GET['Pro']."'>"; 	
	echo "<INPUT TYPE=hidden NAME=Ram id=Ram value='".$_GET['Ram']."'>";
	echo "<INPUT TYPE=hidden NAME=Cont id=Cont value='$numcontra'>"; 
	echo "<INPUT TYPE=hidden NAME=fecha id=fecha value='$fecha'>";
	echo "<INPUT TYPE=hidden NAME=Dir id=Dir value='".$_GET["Dir"]."'>"; 
	echo "<INPUT TYPE=hidden NAME=Nom id=Nom value='".$_GET["Nom"]."'>";
	echo "<INPUT TYPE=hidden NAME=Ubi id=Ubi value='$dato'>";
	echo "<INPUT TYPE=hidden NAME=Rif id=Rif value='".$_GET["Rif"]."'>";
	echo "<INPUT TYPE=hidden NAME=Cate id=Cate value='".$_GET["Cate"]."'>";
	?>
	</table>
</td>
  </tr>
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