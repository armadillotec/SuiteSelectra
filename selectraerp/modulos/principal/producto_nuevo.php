<?php

include("../../libs/php/clases/producto.php");
include("../../libs/php/clases/correlativos.php");
include("../../../menu_sistemas/lib/common.php");

$productos = new Producto();
$correlativos = new Correlativos();
$campos_almacen = $productos->ObtenerFilasBySqlSelect("SELECT * FROM almacen");
$smarty->assign("campos_almacen", $campos_almacen);
$almacenes2 = $productos->ObtenerFilasBySqlSelect("
    SELECT descripcion, '0' as cantidad
    FROM almacen
    LEFT JOIN item_existencia_almacen ON (id_item = almacen.cod_almacen)");

if (isset($_POST["aceptar"])) {
    $productos->BeginTrans();
    $nro_producto = $correlativos->getUltimoCorrelativo("cod_producto", 1, "si", "P");# Originalmente $nro_producto era el valor guardado en BD para el campo `item`.`cod_item`
    $_POST["iva"] = $_POST["monto_exento"] == 0 ? $_POST["iva"] : 0;
    $instruccion = "
        INSERT INTO `item`(
        `cod_item`, `codigo_barras`, `costo_actual`, `descripcion1`, `descripcion2`, `descripcion3`, `referencia`,
        `codigo_fabricante`, `precio1`, `utilidad1`, `coniva1`, `precio2`, `utilidad2`,
        `coniva2`, `precio3`, `utilidad3`, `coniva3`, `existencia_min`,
        `existencia_max`, `monto_exento`, `iva`,
        `cod_departamento`, `cod_grupo`, `cod_linea`,
        `estatus`,`usuario_creacion`, `fecha_creacion`, `cod_item_forma`,unidad_empaque, cantidad, seriales,garantia, tipo_item, tipo_prod,
        costo_promedio, costo_anterior, cuenta_contable1, cuenta_contable2)
        VALUES(
        '{$_POST["cod_item"]}', '{$_POST["cod_barras"]}', '{$_POST["costo_actual"]}', '{$_POST["descripcion1"]}',
        '{$_POST["descripcion2"]}', '" . $_POST["descripcion3"] . "', '" . $_POST["referencia"] . "', '" . $_POST["codigo_fabricante"] . "',
        '" . $_POST["precio_1"] . "', '" . $_POST["utilidad1"] . "', '" . $_POST["coniva1"] . "', '" . $_POST["precio_2"] . "',
        '" . $_POST["utilidad2"] . "', '" . $_POST["coniva2"] . "', '" . $_POST["precio_3"] . "', '" . $_POST["utilidad3"] . "',
        '" . $_POST["coniva3"] . "', '" . $_POST["existencia_min"] . "',  '" . $_POST["existencia_max"] . "', '" . $_POST["monto_exento"] . "',
        '" . $_POST["iva"] . "', '" . $_POST["cod_departamento"] . "', '" . $_POST["cod_grupo"] . "', '" . $_POST["cod_linea"] . "',
        '" . $_POST["estatus"] . "', '" . $login->getUsuario() . "', CURRENT_TIMESTAMP, 1, '" . $_POST["empaque"] . "',
        '" . $_POST["unidad_empaque"] . "', '" . $_POST["serial"] . "', '" . $_POST["garantia"] . "', '" . $_POST["tipo_producto"] . "', '" . $_POST["tipo"] . "',
        '" . $_POST["costo_promedio"] . "', '" . $_POST["costo_anterior"] . "', '" . $_POST["cuenta_contable1"] . "', '" . $_POST["cuenta_contable2"] . "'
        );";
    $productos->ExecuteTrans($instruccion);
    if ($productos->errorTransaccion == 1) {
        Msg::setMessage("<span style=\"color:#62875f;\">Producto Generado Exitosamente con en Nro. " . $nro_producto . "</span>");
    }
    if ($productos->errorTransaccion == 0) {
        Msg::setMessage("<span style=\"color:red;\">Error al tratar de crear el producto.</span>");
    }
    $nro_producto = $correlativos->getUltimoCorrelativo("cod_producto", 1, "no", "");
    $productos->ExecuteTrans("UPDATE correlativos SET contador = '{$nro_producto}' WHERE campo = 'cod_producto'");
    $productos->CommitTrans($productos->errorTransaccion);

    $i = 1;
    $codigo = $_POST['id' . $i];
    while ($codigo != '') {
        if ($_POST['id' . $i] != '') {
            $query = "INSERT INTO productos_kit VALUES (LAST_INSERT_ID(),'" . $_POST['item' . $i] . "','" . $_POST['cantidad' . $i] . "');";
            $productos->ExecuteTrans($query);
        }
        $codigo = $_POST['id' . $i];
        $i++;
    }
    header("Location: ?opt_menu=" . $_POST["opt_menu"] . "&opt_seccion=" . $_POST["opt_seccion"]);
    exit;
}

$lista_impuestos = $productos->ObtenerFilasBySqlSelect("SELECT descripcion FROM tipo_impuesto ORDER BY descripcion;");
/*$arraySelectOutPut = "";
foreach ($lista_impuestos as $key_impuestos => $item) {
    //$arraySelectOption[] = $item["cod_tipo_impuesto"];
    $arraySelectOutPut[] = $item["descripcion"];
}
$smarty->assign("key_impuestos", $key_impuestos);*/
$smarty->assign("lista_impuestos", $lista_impuestos);
/*$smarty->assign("option_values_impuestos", $arraySelectOption);
$smarty->assign("option_output_impuestos", $arraySelectOutPut);*/

$smarty->assign("nro_productoOLD", $correlativos->getUltimoCorrelativo("cod_producto", 0, "si", "P"));
$smarty->assign("nro_productoNEW", $correlativos->getUltimoCorrelativo("cod_producto", 1, "si", "P"));

$ultimocodigo = $productos->ObtenerFilasBySqlSelect("SELECT cod_item FROM item WHERE cod_item_forma = 1 ORDER BY id_item DESC LIMIT 0,1");
$smarty->assign("ultimo_codigo", $ultimocodigo);

$arraySelectOption = "";
$arraySelectoutPut = "";
// Cargando departamentos en combo select
$campos_comunes = $productos->ObtenerFilasBySqlSelect("SELECT * FROM departamentos");
foreach ($campos_comunes as $key => $item) {
    $arraySelectOption[] = $item["descripcion"];
    $arraySelectOutPut[] = $item["cod_departamento"];
}
$smarty->assign("option_values_departamentos", $arraySelectOption);
$smarty->assign("option_output_departamentos", $arraySelectOutPut);

// Cargando grupo en combo select
$arraySelectOption = "";
$arraySelectoutPut = "";
$campos_comunes = $productos->ObtenerFilasBySqlSelect("SELECT * FROM grupo");
foreach ($campos_comunes as $key => $item) {
    $arraySelectOption[] = $item["descripcion"];
    $arraySelectoutPut[] = $item["cod_grupo"];
}
$smarty->assign("option_values_grupo", $arraySelectOption);
$smarty->assign("option_output_grupo", $arraySelectoutPut);

// Cargando Linea en combo select
$arraySelectOption = "";
$arraySelectoutPut = "";
$campos_comunes = $productos->ObtenerFilasBySqlSelect("SELECT * FROM linea");
foreach ($campos_comunes as $key => $item) {
    $arraySelectOption[] = $item["descripcion"];
    $arraySelectoutPut[] = $item["cod_linea"];
}
$smarty->assign("option_values_linea", $arraySelectOption);
$smarty->assign("option_output_linea", $arraySelectoutPut);

//Cargar % I.V.A de la tabla de parametros generales.
$parametros_generales = $productos->ObtenerFilasBySqlSelect("SELECT * FROM parametros_generales");
$smarty->assign("parametros_generales", $parametros_generales);

//Cargar Almacenes
$almacenes = $productos->ObtenerFilasBySqlSelect("SELECT * FROM almacen");
$smarty->assign("almacenes", $almacenes);

$smarty->assign("almacenes2", $almacenes2);
//$smarty->assign("prueba",$almacenes2[0]['descripcion']);
// CONSULTA DE CUENTAS CONTABLES
$global = new bd(SELECTRA_CONF_PYME);
$sentencia = "SELECT * FROM nomempresa WHERE bd = '{$_SESSION['EmpresaFacturacion']}';";
$contabilidad = $global->query($sentencia);
$fila = $contabilidad->fetch_assoc();

$valueSELECT = "";
$outputSELECT = "";
$contabilidad = $productos->ObtenerFilasBySqlSelect("SELECT * FROM {$fila['bd_contabilidad']}.cwconcue WHERE Tipo='P';");
foreach ($contabilidad as $key => $cuenta) {
    $valueSELECT[] = $cuenta["Cuenta"];
    $outputSELECT[] = $cuenta["Cuenta"] . " - " . $cuenta["Descrip"];
}
$smarty->assign("option_values_cuenta", $valueSELECT);
$smarty->assign("option_output_cuenta", $outputSELECT);


$valueSELECT = "";
$outputSELECT = "";
$parametros_generales = $productos->ObtenerFilasBySqlSelect("SELECT porcentaje_impuesto_principal, iva_a, iva_b, iva_c, (SELECT iva FROM item WHERE id_item = '{$_GET["cod"]}') AS iva FROM parametros_generales;");
$parametros_generales_array = array($parametros_generales[0]['porcentaje_impuesto_principal'], $parametros_generales[0]['iva_a'], $parametros_generales[0]['iva_b'], $parametros_generales[0]['iva_c']);
foreach ($parametros_generales_array as $params) {
    $outputSELECT[] = $valueSELECT[] = $params;
}
$smarty->assign("option_values_porcentaje_impuesto_principal", $valueSELECT);
$smarty->assign("option_output_porcentaje_impuesto_principal", $outputSELECT);
$smarty->assign("option_selected_porcentaje_impuesto_principal", $parametros_generales[0]['iva']);

$valueSELECT = "";
$outputSELECT = "";
$tipo_array = array("Activo Fijo"=>0, "Consumo"=>1, "Venta"=>2, "Otro"=>3);

foreach ($tipo_array as $key => $params) {
    $outputSELECT[] = $key;
    $valueSELECT[] = $params;
}
$smarty->assign("option_values_tipo", $valueSELECT);
$smarty->assign("option_output_tipo", $outputSELECT);
$smarty->assign("option_selected_tipo", $parametros_generales[0]['iva']);
?>
