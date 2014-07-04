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
	$this->Cell(30,10,'REPORTE DE CONTRATOS GENERADOS',0,0,'C');
	//Salto de l�nea
	$this->Ln(10);
   $ubica=$_POST["ubi"];
	$this->Cell(185,10,$ubica,0,0,'C');
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
	$w=array(20,20,40,45,20,20);
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
	$w=array(20,25,50,70,20);
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C',1);
	$this->Ln();
	//Restauraci�n de colores y fuentes
	$this->SetFillColor(224,235,255);
	$this->SetTextColor(0);
	$this->SetFont('');
	//Datos
	$fill=0;
	$ubica=$_POST["ubi"];
		
	include("ControlaBD.php");

	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");
	
	$resubi= $con->ejecutar("SELECT codubi,descrip FROM ubicacion WHERE descrip='$ubica'",$idcon);
	 $ubi = mysql_fetch_array($resubi);
	
	//$result= $con->ejecutar("SELECT numero,rif,stand,total FROM contrato WHERE ubica='$ubi[codubi]'",$idcon);
	$result= $con->ejecutar("SELECT numero,rif,stand,total,fecha FROM contrato",$idcon);
	
    while ($fila = mysql_fetch_array($result)) {
  //   $this->Cell($w[0],6,$fila[numero],1,'L');
	// $this->Cell($w[1],6,$fila[rif],1,'L');
	
	$resempre= $con->ejecutar("SELECT nombre FROM empresa WHERE rif='$fila[rif]'",$idcon);
	$empr = mysql_fetch_array($resempre);
	
	// $this->Cell($w[2],6,$empr[nombre],1,'L');
	 
	 	
	$separar_cadena = explode(',',$fila[stand]);
	$cantidadventa=count($separar_cadena);
	
	    $area=0;   		
	 for($i=0;$i<count($separar_cadena); $i++){
		   $this->Cell($w[0],6,$fila[numero],1,'L');
	       $this->Cell($w[1],6,$fila[rif],1,'L');
	       $this->Cell($w[2],6,$empr[nombre],1,'L');
		   $resu= $con->ejecutar("SELECT costo,codubi FROM stand WHERE codstand='$separar_cadena[$i]' and codubi='$ubi[codubi]' ",$idcon);
		   $num_rows=mysql_num_rows($resu);
		   $row=mysql_fetch_array($resu);
		   $resubi= $con->ejecutar("SELECT costo,preventa,fechainicio,fechafin,metros,descrip FROM ubicacion WHERE codubi='$ubi[codubi]'",$idcon);
	       $ubi = mysql_fetch_array($resubi);
	    // $area=$area+$ubi[metros];
		// $fecha=date("Y-m-d", mktime(0, 0, 0, date("m") , date("d"), date("Y")));
			if (($fila[fecha]>=$ubi[2]) and ($fila[fecha]<=$ubi[3])){
				$valor=$ubi[1];
			}else{
				$valor=$ubi[0];
			}
		//$this->Cell($w[0],6,'',0,'L');
		//	$this->Cell($w[1],6,$ubi[descrip],1,'L');
			$this->Cell($w[3],6,$separar_cadena[$i],1,'L');		
			if ($row[costo]!=0){
		 	$tot = number_format($row[costo],2,',','.'); 
       	     $this->Cell($w[4],6,$tot,1,'L');		
			}else{
		 	$tot = number_format($valor,2,',','.'); 
			 $this->Cell($w[4],6,$tot,1,'L');		
			}
			// $this->Cell($w[4],6,$ubi[4],1,'L');		
			$this->Ln();

	}
	
	 
	 
//$this->Cell($w[3],6,$ubi[descrip],1,'L');
	 $this->Cell($w[3],6,$fila[stand],1,'L');
	  $this->Cell($w[4],6,$fila[total],1,'L');
	 $this->Ln();
    }
}
}



$pdf=new PDF();
$header=array('N. Contrato','Cedula/Rif','Empresa','Stand','Total Bs.');
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