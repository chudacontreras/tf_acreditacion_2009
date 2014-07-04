<?php 
  if($codigo == "imp")   
    {
    include 'class.ezpdf.php';
    $pdf =& new Cezpdf();
    //$imagen ="barcode.png";
		if($out=="png")
		   {
			 $imagen ="barcode.png";
			 $pdf->addPngFromFile($imagen,10,740,100);
			 }
    if($out=="gif")
		  {
			$imagen ="barcode.gif";
			$pdf->ezImage($imagen);
			}
		if($out=="jpg")
		  {
			 $imagen ="barcode.jpg";
			 $pdf->addJpegFromFile($imagen,10,740,100);
			 }
		$pdf->selectFont('/fonts/Helvetica');
		$pdf->addText(10,800,9,"Imagen: $out");
		//$pdf->addImage($imagen,10,700,100);
    $pdf->ezStream();
    exit;
   }
	if ($codigo=="gen" and $out=="pdf")
	   {
		 printf("<META HTTP-EQUIV='Refresh' CONTENT='3; URL=pdfbar.php?codigo=$valor&codificacion=$codif'>");
		 }
 ?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title>Php CodeBAr</title>
<link rel="stylesheet" type="text/css" href="esti.css" />
<meta name="GENERATOR" content="Quanta Plus">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
</head>
<?php require("php-barcode.php");?> 
<body>
<form action="genera.php?codigo=gen" method="POST" name="generabarcode">
<table border="0" cellspacing="0" cellpadding="2" class="estilotabla">
<tr><td colspan="2" class="estilocelda"><center><b>Generador de c�digo de barras</b></center></td></tr>
 <tr>
  <td width="10" width="30%">Valor: </td>
  <td width="100"><input type="text" name="valor" size="20" id="campo"  maxlength="20"/></td>
 </tr>
 <tr>
  <td width="10" width="30%">Codificaci�n:</td>
  <td width="100"><select name="codif" id="solid_line">
	<option >ANY</option>    
  <option>EAN</option>
  <option>UPC</option>     
  <option>ISBN</option>    
  <option>39</option>      
  <option>128</option>     
  <option>128C</option>   
  <option>128B</option>   
  <option>I25</option>     
  <option>128RAW</option> 
  <option>CBR</option>     
  <option>MSI</option>     
  <option>PLS</option>
	<option>93</option>    
	</select></td>
 </tr>
 <tr>
  <td width="10">Escala:</td>
  <td width="100"><input type="text" name='esc' size="5" id="campo" maxlength="2"/></td>
 </tr>
 <tr>
  <td width="10">Salida:</td>
  <td width="100"><select name="out" id="solid_line">
	<option>png</option>
	<option>gif</option>
	<option>jpg</option>
	<option>pdf</option>
	</select></td>
 </tr>
<tr><td colspan="2"><font color="#0000ff"><textarea  name="info"  rows="12" cols="50" readonly="readonly" id="punte_line">
 ANY    choose best-fit (default)
 EAN    8 or 13 EAN-Code
 UPC    12-digit EAN 
 ISBN   isbn numbers (still EAN-13) 
 39     code 39 
 128    code 128 (a,b,c: autoselection) 
 128C   code 128 (compact form for digits)
 128B   code 128, full printable ascii 
 I25    interleaved 2 of 5 (only digits) 
 128RAW Raw code 128 (by Leonid A. Broukhis)
 CBR    Codabar (by Leonid A. Broukhis) 
 MSI    MSI (by Leonid A. Broukhis) 
 PLS    Plessey (by Leonid A. Broukhis)
</textarea></b></font></td></tr> 
<tr><td colspan="2"><center><input type="submit" value="generar código" name="B1" id="boton"></center></td></tr>

<?php 
  if(($codigo == "gen")and(($out=="jpg")or($out=="png")))
	  {
     echo "<tr><td colspan='2'><b>Valor:&nbsp;</b>$valor, <b>Codificacion:&nbsp;</b>$codif</td></tr>\n" ;
     echo "<tr><td colspan='2'><b>Escala:&nbsp;</b>$esc, <b>Salida:&nbsp;</b>$out</td></tr>\n" ;
     echo "	<tr><td colspan='2'>\n" ;
     $img="barcode.php?code=$valor&encoding=$codif&scale=$esc&mode=$out";
     echo "<img src='$img' alt=\"barcode\">" ;
		 $out="barcode".".$out";
     echo "	</td></tr>\n" ;
		 echo "<tr><td colspan='2'><center><a href='genera.php?codigo=imp&out=$out' target='_blank'>Imprimir</a><center></td></tr>" ;
    }
?> 
</table>
</form>
</body>
</html>
