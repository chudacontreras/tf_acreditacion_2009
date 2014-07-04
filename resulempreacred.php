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
		          <br>Consultar Empresas o Comisiones
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
				if ($_GET["Rif"]!=""){ //busca por numero de cedula o rif
				$resulEmpnom= $con->ejecutar("SELECT nombre,direccion,rif FROM empresa WHERE rif='$rif'",$idcon);
				$num_rows=mysql_num_rows($resulEmpnom);
				$entro=1;

				}elseif (($emp!="") and ($entro==0)){ //busca por nombre de la empresa o comision si la cedula esta en blanco
				     $resulEmpnom= $con->ejecutar("SELECT nombre,direccion,rif FROM empresa WHERE nombre LIKE '%$emp%'",$idcon);
				     $num_rows=mysql_num_rows($resulEmpnom);
				}
              if ($num_rows>=1){ //EXISTE LA EMPRESA 
			        echo '<form  name="formulario" action="resulregisacre.php" METHOD="GET"> 	
				           <table align="center" cellspacing="2" cellpadding="2" border="0" class="texto">
						      <tr>
								<td colspan=3 align="center">
						      </tr>
						     <tr bgcolor="#E5E5E5">
								<th width=80>&nbsp;</th>
								<th width=150>Rif/Ced. del Repre</th>
								<th width=250>Empresa</th>
						     </tr>';
					
					while ($fila = mysql_fetch_array($resulEmpnom)) {
						echo "<tr>";
						echo "<td width=80><input type='Radio' name='Emp' id='Emp' VALUE=$fila[rif] onclick='HacerAccion()'></td>";
						echo "<td align=center width=150>$fila[rif]</td>";
						echo "<td align=center width=250>$fila[nombre]</td>";
					}// Fin del While interno
		          echo"
				<tr>&nbsp;</tr>
				<tr>&nbsp;</tr>
	
					<tr>
					<td>
						<input type=hidden name='rif' id='rif' VALUE=$rif >
					</td>
			
				   <td colspan=2 align='center'><input type='submit' name='hacer' value='Ver contrato o Registro' ></td>
					</tr>";
		      }else{ //la empresa no existe
					  echo '<div align="center">
					  <strong>
						<font face="Arial, Helvetica, sans-serif">
						   <span>
							 <font size="3">
							   <font color="#FF6600">
								  <br>La Empresa no Existe....
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

