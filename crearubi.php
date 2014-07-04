<?php
session_start();
if (array_key_exists('login',$_SESSION)){
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="text.css" type="text/css">
<script language="JavaScript">
function ValidarUbica()
   {
      var Ubi = document.formu.Ubi.value; 
	  var Can = document.formu.Can.value; 
      var Met = document.formu.Met.value; 
	  var Cos = document.formu.Cos.value; 
      var Pre = document.formu.Pre.value; 
	  var Acre = document.formu.Acre.value; 
	  
      if(Ubi==""){
         alert("Ingrese una Ubicaci&oacute;n Valida");
		 return false;
      }
      if((isNaN(Can)==true) || (Can=="")){
         alert("Ingrese una Cantidad Valida");
		 return false;
      }
	  if((isNaN(parseFloat(Met))==true) || (Met=="")){
         alert("Ingrese una Cantidad en Metros Valida");
		 return false;
      }
	  if((isNaN(parseFloat(Cos))==true) || (Cos=="")){
         alert("Ingrese un Costo Valido");
		 return false;
      }
	  if((isNaN(parseFloat(Pre))==true) || (Pre=="")){
         alert("Ingrese un Precio de Pre-Venta Valido");
		 return false;
      }
	   if((isNaN(Acre)==true) || (Acre=="")){
         alert("Ingrese una Cantidad de Acreditaciones Valida");
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
		          <br>Crear Ubicaci&oacute;n a Comercializar
		          <br>
			   </font>
			 </font>
		</span>
		</font>
	</strong>
  </div>
   

<table align="center" cellspacing="2" cellpadding="2" border="0" class="texto">
  <!--DWLayoutTable-->
  <FORM METHOD="GET" action="guacrearubi.php" name="formu" onSubmit="return ValidarUbica()">         
			<tr>
			    <td>Ubicaci&oacute;n:&nbsp;</td>
			    <td>
		      <input name="Ubi" type="text" id="Ubi"  style="WIDTH: 220px; HEIGHT: 22px" />
				</td>
				</tr>
		 <tr>
				<td>Cantidad:&nbsp;</td>
				<td>
		        <input name="Can" type="text" id="Can"  style="WIDTH: 220px; HEIGHT: 22px">
				</td>
				</tr>
				<tr>
				<td>Metros:&nbsp;</td>
				<td>
                 <input name="Met" type="text" id="Met"  style="WIDTH: 220px; HEIGHT: 22px" >
				</td>
				</tr>
					<tr>
						<td>Costo:&nbsp;</td>
						<td>
		           <input name="Cos" type="text" id="Cos"  style="WIDTH: 220px; HEIGHT: 22px">
				</td>
				<tr>
				<td>Costo Pre-Venta:&nbsp;</td>
				<td>
				<input name="Pre" type="text" id="Pre"  style="WIDTH: 220px; HEIGHT: 22px">
				</td>
				</tr>
						<tr>
						<td>Fecha Inicio:&nbsp;</td>
						<td>

			<select name="dia" class="texto1" id="dia">
            <option>D&iacute;a</option>
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="26">26</option>
            <option value="27">27</option>
            <option value="28">28</option>
            <option value="29">29</option>
            <option value="30">30</option>
            <option value="31">31</option>
          </select>
		   <select name= "mes" id="mes" class="texto1" ><option>Mes</option>
            <option value="1">Enero</option>
            <option value="2">Febrero</option>
            <option value="3">Marzo</option>
            <option value="4">Abril</option>
            <option value="5">Mayo</option>
            <option value="6">Junio</option>
            <option value="7">Julio</option>
            <option value="8">Agosto</option>
            <option value="9">Septiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option></select>

	    <select name="a" class="texto1" id="a">
	   <option>A&ntilde;o</option>
            <option value="2007">2007</option>
            <option value="2008">2008</option>
            <option value="2009">2009</option>
          </select>
				</td>
					</tr>
					<tr>
						<td>Fecha Fin:&nbsp;</td>
						<td>
			<select name="idia" class="texto1" id="idia">
            <option>D&iacute;a</option>
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="26">26</option>
            <option value="27">27</option>
            <option value="28">28</option>
            <option value="29">29</option>
            <option value="30">30</option>
            <option value="31">31</option>
          </select>
		  <select name= "imes" id="imes" class="texto1" ><option>Mes</option>
            <option value="1">Enero</option>
            <option value="2">Febrero</option>
            <option value="3">Marzo</option>
            <option value="4">Abril</option>
            <option value="5">Mayo</option>
            <option value="6">Junio</option>
            <option value="7">Julio</option>
            <option value="8">Agosto</option>
            <option value="9">Septiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option></select>

		   <select name="ia" class="texto1" id="ia">
	   <option>A&ntilde;o</option>
            <option value="2007">2007</option>
            <option value="2008">2008</option>
            <option value="2009">2009</option>
          </select>
				</td>
					</tr>
				<tr>
			    <td>Nro. de Acreditados:&nbsp;</td>
			    <td>
		      <input name="Acre" type="text" id="Acre"  style="WIDTH: 220px; HEIGHT: 22px" />
				</td>
				</tr>
					 <td height="21" colspan="3" valign="top">
					<tr>
			         <td height=35 colspan=4 valign=top align=center>
                     <input name=button type=submit value='Guardar'>
				    </td>
		          </tr></form>
  </table>

	

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

