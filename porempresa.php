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
	$this->SetFont('Arial','B',8);
	//Movernos a la derecha
	$this->Cell(80);
	//T�tulo
	$this->Cell(30,10,'REPORTE DE EMPRESAS DEUDORAS',0,0,'C');
	$this->Ln();
	$this->Cell(190,10,date("d / m / Y"),0,0,'C');
	//Salto de l�nea
	$this->Ln(30);
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
	$w=array(40,20,40,45,20,20);
	//Cabeceras
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C');
	$this->Ln();
	//Datos

}

//Tabla coloreada
function FancyTable($header)
{
	//Colores, ancho de l�nea y fuente en negrita
	$this->SetFillColor(255,0,0);
	$this->SetTextColor(255);
	$this->SetDrawColor(128,0,0);
	$this->SetLineWidth(.3);
	$this->SetFont('','B');
	//Cabecera
	$w=array(18,20,85,25,25,25);
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C',1);
	$this->Ln();
	//Restauraci�n de colores y fuentes
	$this->SetFillColor(224,235,255);
	$this->SetTextColor(0);
	$this->SetFont('');
	//Datos
	$fill=0;
	
	include("ControlaBD.php");

	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("feria");
	$result= $con->ejecutar("SELECT numero,rif,Statu,resta,total FROM contrato WHERE Statu='1' or Statu='2' and numero like '%LTF09%' ",$idcon);
	
    while ($fila = mysql_fetch_array($result)) {
     $this->Cell($w[0],6,$fila[numero],1,'L');
	 $this->Cell($w[1],6,$fila[rif],1,'L');
	 	
	$resempre= $con->ejecutar("SELECT nombre FROM empresa WHERE rif='$fila[rif]'",$idcon);
	$empr = mysql_fetch_array($resempre);
	
	 $this->Cell($w[2],6,$empr[nombre],1,'L');
       /*if ($fila[Statu]=='1'){
	       $statu='Inicial';
	   }elseif ($fila[Statu]=='2'){
	       $statu='Abono';
	   } 
	 $this->Cell($w[3],6,$statu,1,'L');*/
	 $restransac= $con->ejecutar("SELECT sum(monto) as totaldepo FROM transacciones WHERE nrocontrato='$fila[numero]'",$idcon);
     $trans = mysql_fetch_array($restransac);
	 $acumdepo = number_format($trans[totaldepo],2,',','.'); 
     $this->Cell($w[3],6,$acumdepo,1,'L');
	
	 $resta = number_format($fila[resta],2,',','.'); 
	 $this->Cell($w[4],6,$resta,1,'L');
	 $acum=$acum+$fila[resta];
	 $totalbs = number_format($fila[total],2,',','.');
	 $this->Cell($w[5],6,$totalbs,1,'L');
	 $this->Ln();
    }
	$this->Cell($w[0],6,' ',1,'L');
	$this->Cell($w[1],6,' ',1,'L');
	$this->Cell($w[2],6,' ',1,'L');
	$this->Cell($w[3],6,' ',1,'L');
	$this->Cell($w[4],6,'Total a Cobrar :',1,'L');
	$acum = number_format($acum,2,',','.');
	$this->Cell($w[5],6,$acum,1,'L');
}
}



$pdf=new PDF();
$header=array('N. Contrato','Cedula/Rif','Empresa','Cancelado','Deuda','Total Bs.');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',8);
$pdf->FancyTable($header);
$pdf->Output('reporte_empresa.pdf','I'); //para que muestre la opcion de descargar el reporte

?>
<?php
 }else
{
    Header ("location: index.php"); 
}
?>

