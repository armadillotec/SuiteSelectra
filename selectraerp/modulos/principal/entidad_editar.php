<?php
include("../../libs/php/clases/banco.php");
$banco = new Banco();

if(isset($_POST["aceptar"])){


$instruccion = "UPDATE entidades set
`descripcion` = '".$_POST["descripcion"]."' WHERE cod_entidad = ".$_POST["cod_entidad"];
$banco->Execute2($instruccion);
header("Location: ?opt_menu=".$_POST["opt_menu"]."&opt_seccion=".$_POST["opt_seccion"]."&pagina=".$_POST["pagina"]);
exit;
}


if(isset($_GET["cod"])){
$campos = $banco->ObtenerFilasBySqlSelect("select * from entidades  WHERE cod_entidad = ".$_GET["cod"]);
$smarty->assign("datos_banco",$campos);
}

?>