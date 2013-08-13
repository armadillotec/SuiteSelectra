<?php

if (!isset($_SESSION)) {
    session_start();
}
require('fpdfselectra.php');

class PDF extends FPDFSelectra {

    function tHead($dpto) {
        $this->SetFont("Arial", "B", 9);
        $this->Cell(60, 7, "DEPARTAMENTO: " . strtoupper($dpto), 0, 0, 'C');
        $this->Ln();
        $this->Cell(15, 7, utf8_decode('Codigo'), 'LTB', 0, 'C');
        $this->Cell(30, 7, utf8_decode('Cod. Barras'), 'LTB', 0, 'C'); //
        $this->Cell(100, 7, utf8_decode('Descripcion'), 'LTB', 0, 'C');
        $this->Cell(20, 7, utf8_decode('Existencia'), 'LTB', 0, 'C');
        $this->Cell(20, 7, 'Conteo', 'LTBR', 0, 'C');
        $this->Ln();
    }

    function imprimir_datos(/* $nro_odp, $fila_odp, $moneda, $pdf */$dpto) {
        #echo $dpto["cod_departamento"]." - ".$dpto["descripcion"]."<br>";

        $cantidad_registros = 40;
        if (($cont + 3) > $cantidad_registros) {
            $this->Ln(60);
        }
        $this->tHead($dpto["descripcion"]);
        $conexion = conexion();
        $rs = query("SELECT * FROM item i, item_existencia_almacen a WHERE i.id_item = a.id_item AND i.cod_item_forma = 1 AND i.cod_departamento = '" . $dpto["cod_departamento"] . "' ORDER BY descripcion1", $conexion);
        $totalwhile = num_rows($rs);
        if ($totalwhile == 0) {
            $this->SetY(-75);
            $this->Cell(188, 7, 'No hay materiales', 0, 1, 'C');
        }

        $contar = 1;
        $cantidad_registros = 40; #27
        while ($totalwhile >= $contar) {
            $conexion = conexion();
            $row_rs = fetch_array($rs);
            $cont2 = $cont2 + 1;
            //$var_snc=$row_rs[4];
            $var_codigo = $row_rs['cod_item']; #0
            $var_cod_barras = $row_rs['codigo_barras'];
            $var_descrip = utf8_decode($row_rs['descripcion1']);
            $var_exi = number_format($row_rs['cantidad'], 0, ',', '.');
            $contador++;

            //$monto_3  = number_format($var_monto3,2,',','.');
            $this->SetFont("Arial", "I", 9);
            // llamado para hacer multilinea sin que haga salto de linea
            /*$this->SetWidths(array(15, 30, 100, 20, 20));
            $this->SetAligns(array('L', 'L', 'L', 'R', 'C'));
            $this->Setceldas(array(0, 0, 0, 0, 0));
            $this->Setancho(array(5, 5, 5, 5, 5));
            $this->Row(array($var_codigo, $var_cod_barras, $var_descrip, $var_exi, "_________"), 1);*/

            $this->Cell(15, 5, $var_codigo, 0, 0, 'L');
            $this->Cell(30, 5, $var_cod_barras, 0, 0, 'L');
            $this->Cell(100, 5, $var_descrip, 0, 0, 'L');
            $this->Cell(20, 5, $var_exi, 0, 0, 'R');
            $this->Cell(20, 5, '', 'B', 1);

            if ($cont == $cantidad_registros) {
                $this->Ln(80);
                #$this->Cell(60,7,"DEPARTAMENTO: ".strtoupper($dpto["descripcion"]),'C');
                $this->tHead($dpto["descripcion"]);
                $cont = 1;
            } else {
                $cont++;
            }
            $contar++;
        }//fin del while
    }

    //Pie de página
    function Footer() {
        //Posición: a  cm del final
        $this->SetY(-15);
        // fin
        $this->SetFont('Arial', 'I', 8);
        //Número de página
        $this->Cell(188, 5, utf8_decode('Pagina ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
        $this->SetFont('Arial', 'I', 8);
        $this->Ln();
        //$this->Cell(188,5,'Elaborado Por: '.$valor['usuario'],0,0,'L');
        //Número de página
        // $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

}

//Creación del objeto de la clase heredada
$pdf = new PDF();

$pdf->setTituloReporte('T O M A  D E  I N V E N T A R I O  F I S I C O');
$pdf->AliasNbPages();
#$pdf->AddPage();
$pdf->SetFont('Times', '', 12);

$conexion = conexion();

$tabla = "item";
$consulta = "select * from item where cod_item_forma=1";
$resultado = query($consulta, $conexion);
$codigo_snc = $_GET['codigo_snc'];

//$url="materiales_list";
//$modulo="Materiales";
//$titulos=array("Código","Descripción","Unidad","I.V.A.");
//$indices=array("0","1","2","13");
/*
  $Conn = conexion_conf();

  $var_sql = "select moneda,periodo from parametros";
  $rsu = query($var_sql, $Conn);
  $row_rsu = fetch_array($rsu);
  $moneda = $row_rsu['moneda'];
  $periodo = $row_rsu['periodo'];
  cerrar_conexion($Conn); */

$sql = "SELECT * FROM departamentos";
$rs = query($sql, $conexion);

while ($fila = fetch_array($rs)) {
    $pdf->AddPage();
    $pdf->imprimir_datos(/* $nro_odp, $fila_odp, $moneda, $pdf */$fila);
    #$pdf->SetAutoPageBreak(true);
    $fila = "";
}
#exit;
$pdf->Output();
?>