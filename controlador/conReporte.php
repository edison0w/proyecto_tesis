<?php

require __DIR__ . "/../modelo/clsSocio.php";
require __DIR__ . "/../modelo/clsTerreno.php";
require __DIR__ . "/../modelo/clsAsignarCultivo.php";
require('../recursos/pdf/fpdf.php');

class PDF extends FPDF {

    function Header() {
        $this->Image('../recursos/img/jurechgis.png', 10, 8, 25);
        // Select Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(80);
        // Framed title
        $this->Cell(30, 10, 'Junta General de Riego Chambo - Guano', 0, 0, 'C');
        // Line break
        $this->Ln(20);
    }

    function Footer() {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
//        $this->SetFont('Arial', 'I', 8);
//        $this->Cell(0, 0, "-----------", 0, 0, "C");
//        $this->Ln();
//        $this->Cell(0, 0, "Firma", 0, 0, "C");
        //Número de página
        $this->Cell(0, 5, 'Pag. ' . $this->PageNo() . '/{nb}', 0, 0, 'R');
    }

}

if ($_POST['operacion'] == "pdf") {

    if ($_POST['txtJunta'] == "" || $_POST['txtJunta'] == -1) {
        $j = "!= -1";
    } else {
        $j = "= " . $_POST['txtJunta'];
    }

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(80);
    $pdf->Cell(30, 10, "Lista de Socios ", 0, 0, "C");
    $pdf->Ln();
    $pdf->SetFont('Arial', '', 10);
    // TABLA DE DATOS
    $w = array(28, 90, 30, 40);
    // Cabeceras
    $header = array('Cédula', 'Nombres', 'Teléfono', 'Persona');
    for ($i = 0; $i < count($header); $i++)
        $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
    $pdf->Ln();
    // Datos
    $objSocio = new clsSocio();
    $data = $objSocio->buscarXCodigoJunta($j);
    foreach ($data as $row) {
        $pdf->Cell($w[0], 6, $row[1], 'LR', 0, 'C');
        $pdf->Cell($w[1], 6, '  ' . $row[2], 'LR');
        $pdf->Cell($w[2], 6, '    ' . $row[7], 'LR');
        $pdf->Cell($w[3], 6, $row[17], 'LR', 0, 'C');
        $pdf->Ln();
    }
    // Línea de cierre
    $pdf->Cell(array_sum($w), 0, '', 'T');

    $pdf->Output();
}

if ($_POST['operacion'] == "pdfSocio") {

    $cod = $_POST['txtCodSocio'];
    $altura = 6;
    $ancho = 20;
    $espacio = 90;
    $ancho2 = 25;

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(80);
    $pdf->Cell(30, 10, "Información General", 0, 0, "C");
    $pdf->Ln();


    // Datos
    $objSocio = new clsSocio();
    $objSocio->setCodigo($cod);
    $objSocio->buscarXCodigo();
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell($ancho, $altura, "Cédula  ");
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell($espacio, $altura, $objSocio->getCi());

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell($ancho2, $altura, "Estado Civil  ");
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell($ancho, $altura, $objSocio->getEstado_civil());

    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell($ancho, $altura, "Nombres  ");
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell($espacio, $altura, $objSocio->getApellido());

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell($ancho2, $altura, "Conyuge  ");
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell($ancho, $altura, $objSocio->getNombre_conyuge());

    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell($ancho, $altura, "Dirección  ");
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell($espacio, $altura, $objSocio->getDireccion());

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell($ancho2, $altura, "Genero ");
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell($ancho, $altura, $objSocio->getGenero());

    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell($ancho, $altura, "Teléfono  ");
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell($espacio, $altura, $objSocio->getTelefono());

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell($ancho2, $altura, "Tipo Persona ");
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell($ancho, $altura, $objSocio->getTipo());

    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell($ancho, $altura, "Celular  ");
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell($ancho, $altura, $objSocio->getCelular());
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell($ancho, $altura, "Email  ");
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell($ancho, $altura, $objSocio->getEmail());
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell($ancho, $altura, "Terrenos");
    $pdf->Ln();
    $objTerreno = new clsTerreno();
    $data = $objTerreno->buscarXSocio($cod);
    //TABLA DE DATOS
    $w = array(30, 30, 35, 40, 40);
    // Cabeceras
    $header = array('Terreno', 'Area con Riego', 'Area Susp. Riego', 'Area No. Susp a Riego', 'Area Total');
    for ($i = 0; $i < count($header); $i++)
        $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
    $pdf->Ln();
    $pdf->SetFont('Arial', '', 10);
    foreach ($data as $row) {
        $pdf->Cell($w[0], 6, $row[0], 'LRBT', 0, 'C');
        $pdf->Cell($w[1], 6, $row[6], 'LRBT', 0, 'C');
        $pdf->Cell($w[2], 6, $row[7], 'LRBT', 0, 'C');
        $pdf->Cell($w[3], 6, $row[8], 'LRBT', 0, 'C');
        $pdf->Cell($w[3], 6, $row[12], 'LRBT', 0, 'C');
        $pdf->Ln();
        $cultivos = new clsAsignarCultivo();
        $cultivos = $cultivos->buscarXTerreno($row[0]);
        foreach ($cultivos as $fila) {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell($w[0], 6, "Cultivo", 0, 0, 'C');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell($w[1], 6, $fila[14], 0, 0, 'C');
            
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell($w[2], 6, "Area", 0, 0, 'C');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell($w[3], 6, $fila[4], 0, 0, 'C');
            
            $pdf->Ln();
        }
    }
    // Línea de cierre
    //$pdf->Cell(array_sum($w), 0, '', 'T');

    $pdf->Output();
}
