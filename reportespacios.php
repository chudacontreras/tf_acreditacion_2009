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
	$this->Cell(30,10,'REPORTE DE ESPACIOS COMERCIALIZADOS',0,0,'C');
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
	$w=array(40,20,85,45);
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
	$w=array(10,65,40,40,30);
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
	$sel_bd= $con->select_BD("tf_comercializacion");
	//CONOCER CANTIDAD CONTRATADA Y CANTIDAD POR CONTRATAR
	$acuntotal=0;
	$resulUbi= $con->ejecutar("SELECT * FROM ubicacion",$idcon);
	while ($fila = mysql_fetch_array($resulUbi)) {
	   $multiplica=0;
	    $this->Cell($w[0],6,$fila[codubi],1,'L');
        $this->Cell($w[1],6,$fila[descrip],1,'L');
		//CONSULTA DE STAND VENDIDOS O CONTRATADOS
		$resulStanV= $con->ejecutar("SELECT status,codstand,costo FROM Stand WHERE codubi='$fila[codubi]' and status='vendido'",$idcon);
		$vendidos=mysql_num_rows($resulStanV);
		$this->Cell($w[2],6,$vendidos,1,'L');
		//CONSULTA DE STAND ACTIVOS
		$resulStanA= $con->ejecutar("SELECT status FROM Stand WHERE codubi='$fila[codubi]' and status='Activo'",$idcon);
		$sinvender=mysql_num_rows($resulStanA);
		$this->Cell($w[3],6,$sinvender,1,'L');
			
	//	$resultotal= $con->ejecutar("SELECT status,codstand,costo FROM Stand WHERE codubi='$fila[codubi]' and status='vendido'",$idcon);
		//$NOVENDI=mysql_num_rows($resultotal);
		
		while ($BS = mysql_fetch_array($resulStanV)) {
			//if ($vendidos==0){
			 //$multiplica=0;
			//}else{
		
		    $resulContra= $con->ejecutar("SELECT stand,rif,fecha FROM contrato where stand like '%$BS[codstand]%' ",$idcon);
			$fila0 = mysql_fetch_array($resulContra);
			$SIHAY=mysql_num_rows($resulContra);
			if ($SIHAY>=1)
			{
		     $fecha=$fila0[fecha];
						
			//PARA CONOCER LA EMPRESA SI ES AGENTE RETENSOR O NO
			$resulEmpre= $con->ejecutar("SELECT retensoriva FROM empresa WHERE rif='$fila0[rif]'",$idcon);
			$reten= mysql_fetch_array($resulEmpre);
					
			if ($BS[costo]!=0){ //si el stand tiene precio distinto al ubicacion
			      
						   //PARA  RETENSOR DE IVA EN EL CASO QUE EL STAND TENGA UN PRECIO DISTINTO AL DE SU UBICACION
				  if ($reten[retensoriva]==1){
					 $x=$BS[costo]/1.09; //x es precio sin iva
					 $z=$BS[costo]-$x;
					 $costoiva=$x+($z*0.75);
					 $multiplica=$multiplica+$costoiva;
				  }else{
					 $multiplica=$multiplica+$BS[costo];
				  }
				  
			}else{
					$resulCosto= $con->ejecutar("SELECT costo,preventa,fechainicio,fechafin,nroacredi,maxacred FROM ubicacion WHERE codubi='$fila[codubi]'",$idcon);
					$fila2 = mysql_fetch_array($resulCosto);
						
						  
					if (($fecha>=$fila2[2]) and ($fecha<=$fila2[3]))
					{
					   $valor=$fila2[1];
					}
					else
					{
					  $valor=$fila2[0];
					}
							//PARA RETENSOR DE IVA EN EL CASO DE QUE TOME EL PRECIO DE LA UBICACION
					  if ($reten[retensoriva]==1){
						 $x=$valor/1.09; //x es precio sin iva
						 $z=$valor-$x;
						 $costoiva=$x+($z*0.75);
						 $multiplica=$multiplica+$costoiva;
					  }else{
						 $multiplica=$multiplica+$valor;
					  }
				  }
				  }
				//  	$tot = number_format($multiplica,2,',','.'); 
				  //	$this->Cell($w[3],6,$tot,1,'L');
					//	$this->Ln();
	    } //while interno de stand
	//	}
	$acuntotal=$acuntotal+$multiplica;
			$tot = number_format($multiplica,2,',','.'); 
		$this->Cell($w[4],6,$tot,1,'L');
		$this->Ln();
		
	} 
    $this->Cell($w[0],6,' ',1,'L');
	 $this->Cell($w[1],6,' ',1,'L');
	 $this->Cell($w[2],6,' ',1,'L');
	 $this->Cell($w[3],6,'Total Comercializado',1,'L');
 	$totalco = number_format($acuntotal,2,',','.'); 
	 $this->Cell($w[4],6,$totalco,1,'L');
}

    
}



$pdf=new PDF();
$header=array('N.','PABELLONES','CANT. CONTRATADA','CANT. POR CONTRATAR','BS. CONTRATADOS');
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


