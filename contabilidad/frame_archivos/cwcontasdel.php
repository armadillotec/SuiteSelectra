<?php
require_once 'lib/common.php';
include ("header.php");
$conexion=conexion();
//echo $conexion;
$pagina = @$_GET['pagina'];

$url="cwcontaslist";
$modulo="Tipos de Asientos";
$tabla="cwcontas";
$titulos=array("Descripción");
$indices=array("1");

if(isset($_POST['aceptar'])){
	
	$consulta="DELETE FROM ".$tabla." where cod_tipo=".$_POST["codigo"];
	//echo $consulta;
//exit(0);
	$resultado=query($consulta,$conexion) or die("no se actualizo el movimiento");
	
	cerrar_conexion($conexion);
	$pagina=@$_POST['pagina'];
	echo "<SCRIPT language=\"JavaScript\" type=\"text/javascript\">
	parent.home.location.href=\"".$url.".php?pagina=".$pagina."\"
	</SCRIPT>";
	

}
	$codigo = @$_GET['codigo'];
	//$fecha = @$_GET['fecha'];
	//$numero = @$_GET['numero'];
	$consulta="select * from ".$tabla." where cod_tipo=".$codigo;
	//echo $consulta;
	$resultado=query($consulta, $conexion);
	$fila=fetch_array($resultado);

?>

<html class="fondo">

<head>
  <title></title>
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <SCRIPT language="JavaScript" type="text/javascript" src="lib/common.js">
  </SCRIPT>
<script language="javascript" src="cal2.js"></script>
<script language="javascript" src="cal_conf2.js"></script>
<SCRIPT language="JavaScript" type="text/javascript">

function cerrar(retorno){
	parent.home.location.href=retorno+".php?pagina=<?=$pagina?>"
}

</SCRIPT>

</head>
<body>

<FORM name="sampleform" method="POST" target="_self" action="<?php echo $_SERVER['PHP_SELF']; ?>">

<TABLE  width="100%" height="100">
<TBODY>

<tr>
      <td colspan="2" height="30" class="tb-tit"><strong>Eliminar Registro de <?echo $modulo?></strong></td>

    </tr>
<TR><td class=tb-head >Codigo</td><td><INPUT type="text" name="codigo" size="100" readonly="true" value="<?echo $codigo?>"></td> </tr>

	<?
	$i=0;
	foreach($titulos as $nombre){
		$campo=mysql_field_name($resultado,$indices[$i]);
	//echo $campo;
		echo "<TR>";?><td class=tb-head ><?echo "$nombre"?></td>
		<td><INPUT type="text" name="<?echo $campo?>" size="100" value='<?echo "$fila[$campo]";?>' readonly="true"></td> </tr><?
		$i++;
		
	}
?>
    <tr class="tb-tit">
      <td></td>
      <td align="right"><INPUT type="submit" name="aceptar" value="Aceptar">&nbsp;<INPUT type="button" name="cancelar" value="Cancelar" onclick="javascript:cerrar('<?echo $url?>');"></td>
    </tr>
  </tbody>
</table>
</FORM>
</body>
</html>
<?
cerrar_conexion($conexion);

?>