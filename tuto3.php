<?php
session_start();
if (array_key_exists('login',$_SESSION)){

?>
<?php
require('fpdf.php');

class PDF extends FPDF
{
function Header()
{
	//Logo
	$nume=$_GET["No"];
	$this->Image('gobernacion.jpg',10,8,15);
	$this->Image('gobernacion.jpg',180,8,15);
	//Arial bold 15
	$this->SetFont('Arial','IB',10);
	//Movernos a la derecha
	$this->Cell(80);
	//T�tulo
	$this->Cell(30,10,'Rep&uacute;blica Bolivariana de Venezuela',0,0,'C');
	//Salto de l�nea
	$this->Ln(5);
	$this->Cell(190,10,'Gobernaci&oacute; del Estado Lara',0,0,'C');
	$this->Ln(5);
	$this->Cell(190,10,'Cabudare - Estado Lara',0,0,'C');
	$this->Ln(5);
	$this->Cell(190,10,'Corporaci&oacute;n de Turismo del Estado Lara',0,0,'C');
	$this->Ln(5);
	$this->Cell(190,10,'CORTULARA.',0,0,'C');
	$this->Ln(10);
	$this->Cell(190,10,'CONTRATO No. '.$nume,0,0,'C');
	$this->Ln(20);
}

function Footer()
{
	//Posici�n a 1,5 cm del final
	$this->SetY(-15);
	//Arial it�lica 8
	$this->SetFont('Arial','I',8);
	//Color del texto en gris
	$this->SetTextColor(128);
	//N�mero de p�gina
	$this->Cell(0,10,'P&aacute;gina '.$this->PageNo(),0,0,'C');
}

function ChapterTitle($num,$label)
{
	//Arial 12
	$this->SetFont('Arial','',12);
	//Color de fondo
	$this->SetFillColor(200,220,255);
	//T�tulo
	//Salto de l�nea
	$this->Ln(4);
}

function ChapterBody($file)
{
$nomrespo=$_GET["Nom"];
$cedrespo=$_GET["Rif"];
/**********Nombre***********/
$file = fopen('parte1.txt',"r");
$buffer = fread($file,filesize('parte1.txt'));
fclose($file);
/**********Cedula o RIF**********/
$file2 = fopen('parteb.txt',"r");
$buffer2 = fread($file2,filesize('parteb.txt'));
fclose($file2);
/***********Direccion***********/
/*$file3 = fopen('partec.txt',"r");
$buffer3 = fread($file3,filesize('partec.txt'));
fclose($file3);*/
/**********Stand************/
/*$file4 = fopen('parted.txt',"r");
$buffer4 = fread($file4,filesize('parted.txt'));
fclose($file4);*/
/*********Area Total*************/
/*$file5 = fopen('partee.txt',"r");
$buffer5 = fread($file5,filesize('partee.txt'));
fclose($file5);*/
/*****Productos*****************/
/*$file6 = fopen('partef.txt',"r");
$buffer6 = fread($file6,filesize('partef.txt'));
fclose($file6);*/
/*********Total*************/
/*$file7 = fopen('parteg.txt',"r");
$buffer7 = fread($file6,filesize('parteg.txt'));
fclose($file7);*/
/**********************/
$txt=$buffer.' '.$nomrespo.$buffer2.' '.$cedrespo;
	//Leemos el fichero
	/*$f=fopen($file,'r');
	$txt=fread($f,filesize($file));
	fclose($f);*/
	//Times 12
	$this->SetFont('Times','',12);
	//Imprimimos el texto justificado
	$this->MultiCell(0,5,$txt);
	//Salto de l�nea
	$this->Ln();
	//Cita en it�lica
	$this->SetFont('','I');
	$this->Cell(0,5,'');
}

function PrintChapter($num,$title,$file)
{
	$this->AddPage();
	$this->ChapterTitle($num,$title);
	$this->ChapterBody($file);
}
}

$pdf=new PDF();
$pdf->PrintChapter(1,'','partea.txt');
$pdf->Output();
?>
<?php
 }else
{
    Header ("location: index.php"); 
}
?>