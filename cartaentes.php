<?php
session_start();
if (array_key_exists('login',$_SESSION)){
?>
<?
require('fpdf.php');

class PDF extends FPDF
{
//Cabecera de p�gina
function Header()
{
	//Logo
	$this->Image('cortulara.jpg',10,10,30);
	$this->Image('gobernacion.jpg',180,8,15);
	//Arial bold 15
	$this->SetFont('Arial','IB',10);
	//Movernos a la derecha
	$this->Cell(80);
	//T�tulo
	$this->Cell(30,10,'Rep&uacute;blica Bolivariana de Venezuela',0,0,'C');
	//Salto de l�nea
	$this->Ln(5);
	$this->Cell(190,10,'Gobernaci&oacute;n del Estado Lara',0,0,'C');
	$this->Ln(5);
	$this->Cell(190,10,'Cabudare - Estado Lara',0,0,'C');
	$this->Ln(5);
	$this->Cell(190,10,'Corporaci&oacute;n de Turismo de Barquisimeto',0,0,'C');
	$this->Ln(5);
	$this->Cell(190,10,'CORTULAR',0,0,'C');
	$this->Ln(10);
}

//Pie de p�gina
function Footer()
{
	//Posici�n: a 1,5 cm del final
	$this->SetY(-15);
	//Arial italic 8
	$this->SetFont('Arial','I',6);
	//N�mero de p�gina
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

//Cargar los datos
function LoadData($file)
{
	//Leer las l�neas del fichero
	$lines=file($file);
	$data=array();
	foreach($lines as $line)
		$data[]=explode(';',chop($line));
	return $data;
}

//Tabla simple
function BasicTable($header)
{
	//Cabecera
	foreach($header as $col)
		$this->Cell(40,7,$col,1);
	$this->Ln();
}

//Una tabla m�s completa
function ImprovedTable($header)
{
	//Anchuras de las columnas
	$w=array(10,40,20,40,25,20,20);
	//Cabeceras
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C');
	$this->Ln();
	//Datos

}
function PrintChapter($num,$title,$file)
{
	//A�adir cap�tulo
	$this->AddPage();
	$this->ChapterTitle(2,$title);
	$this->ChapterBody($file);
}


//Tabla coloreada
function FancyTable($header)
{

    $nume=$_GET["Num"];
	$this->SetFont('Arial','IB',10);
	$this->Cell(190,10,'No. REGISTRO '.$nume,0,0,'C');
	$this->Ln(10);


    include("ControlaBD.php");
   
	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");
	
	$this->SetFont('Arial','IB',10);
	$this->Ln(20);

	//Colores, ancho de l�nea y fuente en negrita
	$this->SetFillColor(255,255,255);
	$this->SetTextColor(0,0,0);
	$this->SetDrawColor(128,0,0);
	$this->SetLineWidth(.2);
	$this->SetFont('Arial','B',8);
	
	
	//Cabecera
	$w=array(20,40,40,30,30);
	
	$this->SetFont('Arial','',9);
	$this->Cell(30,10,'Sres.',0,0,'C');
	$this->Ln(5);
   
	$this->Cell(50,10,$_GET["Nom"],0,0,'C');
	$this->Ln(5);
	$this->Cell(40,10,'Presente.-',0,0,'C');
	$this->Ln(5);
	$this->Ln(10);
	
	$this->SetFont('Arial','',8);
	
	// INICIO PARA DEFINIR LA CARTA A ENVIAR
	$resulcateA= $con->ejecutar("SELECT codtacr,codcateg,descrip FROM tipacr WHERE codcateg='".$_GET["Cate"]."' and codtacr<100",$idcon);
	$entro1=0;
	while ($filaA = mysql_fetch_array($resulcateA)) {
	   $resultipoA= $con->ejecutar("SELECT cant FROM cantacredita WHERE nrocontrato='".$_GET["Num"]."' and tipoacre=$filaA[codtacr]",$idcon);
       $num_rowsA=mysql_num_rows($resultipoA);
	   if($num_rowsA>=1){
	     $A=$num_rowsA;
		}
	}

	$resulcateB= $con->ejecutar("SELECT codtacr,codcateg,descrip FROM tipacr WHERE codcateg='".$_GET["Cate"]."' and codtacr>=100",$idcon);
	//RECORRE PARA INSERTAR LOS DISTINTOS DE 0
	while ($filaB = mysql_fetch_array($resulcateB)) {
	   $resultipoB= $con->ejecutar("SELECT cant FROM cantacredita WHERE nrocontrato='".$_GET["Num"]."' and tipoacre='$filaB[codtacr]'",$idcon);
	   $num_rowsB=mysql_num_rows($resultipoB);
	   if($num_rowsB>=1){
	     $B=$num_rowsB;
		}

	}
	
	// $A cantidad de acreditaciones personalizadas
	// $B cantidad de acreditaciones rotativas
	if ($A>=1 && $B>=1){   //tiene los dos tipos de acreditaciones
	  $file = fopen('clave1.txt',"r");
	  $buffer = fread($file,filesize('clave1.txt'));
	  $txt=$buffer;
	  fclose($file);
	  $this->MultiCell(0,5,$txt);
	  $this->Ln(5);
	  $this->Cell(20,10,'Login',0,0,'C');
	  $this->Cell(30,10,':'.'   '.$_GET["Usu"],0,0,'C');
	  $this->Ln(5);
	  $this->Cell(20,10,'Password',0,0,'C');
	  $this->Cell(30,10,':   '.$_GET["Cla"],0,0,'C');
	  $this->Ln(10);
	  $file2 = fopen('clave2RP.txt',"r");
	  $buffer2 = fread($file2,filesize('clave2RP.txt'));
	  $txt2=$buffer2;
	  $this->MultiCell(0,5,$txt2);
	  fclose($file2);
	}elseif($A>=1 && $B==0){   //tiene solo acreditaciones personalizadas
	  $file = fopen('clave1.txt',"r");
	  $buffer = fread($file,filesize('clave1.txt'));
	  $txt=$buffer;
	  $this->MultiCell(0,5,$txt);
	  $this->Ln(5);
	  $this->Cell(20,10,'Login',0,0,'C');
	  $this->Cell(30,10,':'.'   '.$_GET["Usu"],0,0,'C');
	  $this->Ln(5);
	  $this->Cell(20,10,'Password',0,0,'C');
	  $this->Cell(30,10,':   '.$_GET["Cla"],0,0,'C');
	  $this->Ln(10);
	  $file2 = fopen('clave2.txt',"r");
	  $buffer2 = fread($file2,filesize('clave2.txt'));
	  $txt2=$buffer2;
	  $this->MultiCell(0,5,$txt2);
  	  fclose($file);
	  fclose($file2);
	}elseif($A==0 && $B>=1){  //tiene solo acreditaciones rotativas
	  $file = fopen('claveR.txt',"r");
	  $buffer = fread($file,filesize('claveR.txt'));
	  $txt=$buffer;
	  	  $this->MultiCell(0,5,$txt);
	  fclose($file);
	} 


	// FIN PARA DEFINIR LA CARTA A ENVIAR
	
	
	$this->Ln(10);
	$this->Cell(60,10,'Total de Credenciales Disponibles'.' :'.' '.$_GET["Toacre"],0,0,'C');
	$this->Ln();
	/*INICIO: MODULO DE GUARDAR NUMERO DE ACREDITACIONES (TIPO ACRED.) */

	$resulcate2= $con->ejecutar("SELECT codtacr,codcateg,descrip FROM tipacr WHERE codcateg='".$_GET["Cate"]."'",$idcon);
	$entro1=0;
	//RECORRE PARA INSERTAR LOS DISTINTOS DE 0
	while ($fila2 = mysql_fetch_array($resulcate2)) {
	   $resultipo= $con->ejecutar("SELECT cant FROM cantacredita WHERE nrocontrato='".$_GET["Num"]."' and tipoacre='$fila2[codtacr]' and tipoacre<100",$idcon);
	   $fila3 = mysql_fetch_array($resultipo);
	    $num_rows=mysql_num_rows($resultipo);
		if ($num_rows>=1 && $entro1==0){
		   	$this->Cell(60,10,'CREDENCIALES PERSONALIZADAS',0,0,'C');
			$this->Ln(6);
			$entro1=1;
		}
	   if  ($fila3[cant]!='' or $fila3[cant]!=0 ){
          $this->Cell(50,10,$fila2[descrip],0,0,'C');
	      $this->Cell(10,10,':   '.$fila3[cant],0,0,'C');
		  $this->Ln(5);
		}
	}
	$entro=0;
	$resulcate3= $con->ejecutar("SELECT codtacr,codcateg,descrip FROM tipacr WHERE codcateg='".$_GET["Cate"]."'",$idcon);
	//RECORRE PARA INSERTAR LOS DISTINTOS DE 0
	while ($fila3 = mysql_fetch_array($resulcate3)) {
	   $resultipo3= $con->ejecutar("SELECT cant FROM cantacredita WHERE nrocontrato='".$_GET["Num"]."' and tipoacre='$fila3[codtacr]' and tipoacre>=100",$idcon);
	   $fila4 = mysql_fetch_array($resultipo3);
	    $num_rows3=mysql_num_rows($resultipo3);
		if ($num_rows3>=1 && $entro==0){
		   	$this->Cell(50,10,'CREDENCIALES ROTATIVAS',0,0,'C');
			$this->Ln(6);
			$entro=1;
		}
	   if  ($fila4[cant]!='' or $fila4[cant]!=0 ){
          $this->Cell(50,10,$fila3[descrip],0,0,'C');
	      $this->Cell(10,10,':   '.$fila4[cant],0,0,'C');
		  $this->Ln(5);
		}
	}

		
    /*FIN: MODULO DE GUARDAR NUMERO DE ACREDITACIONES (TIPO ACRED.) */
	
	$this->Ln(20);
	$this->Cell(50,10,'Se despide Cordialmente,',0,0,'C');
	$this->Ln(10);
	$this->SetFont('Arial','B',8);
    $this->Cell(50,10,'Comisi&oacute;n de Acreditaci&oacute;n',0,0,'C');
	
		}
	}

$pdf=new PDF();
$header=array('','Pabellon','Stand','Costo','Mts');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',8);
$pdf->FancyTable($header);

$pdf->Output('CARTA_ENTES.pdf','I'); //para que muestre la opcion de descargar el reporte

?>
<?php
 }else
{
    Header ("location: index.php"); 
}
?>