<?php
require_once '../lib/common.php';
include ("../header.php");
$conexion=conexion();
//echo $conexion;
$pagina = @$_GET['pagina'];
$url="estados_list";
$modulo="Estados";
$tabla="estados";
$titulos=array("Estado");
$indices=array("1");

if(isset($_POST['aceptar'])){
	
	$consul="select * from municipios where cod_estado=".$_POST["codigo"];
	$result=query($consul,$conexion);
	$num=mysql_num_rows($result);
	if($num==0)
	{
		$consulta="DELETE FROM ".$tabla." where cod_estado=".$_POST["codigo"];
		$resultado=query($consulta,$conexion) or die("no se actualizo el movimiento");
		$pagina=@$_POST['pagina'];
		cerrar_conexion($conexion);
		echo "<SCRIPT language=\"JavaScript\" type=\"text/javascript\">
		parent.cont.location.href=\"".$url.".php?pagina=".$pagina."\"
		</SCRIPT>";
	}else
	{
		echo "<SCRIPT language=\"JavaScript\" type=\"text/javascript\">
		alert(\"La unidad tiene municipios adcritos, No se puede borrar el Estado\")
		parent.cont.location.href=\"".$url.".php?pagina=1\"
		</SCRIPT>";
	}
	

}
	$codigo = @$_GET['codigo'];
	//$fecha = @$_GET['fecha'];
	//$numero = @$_GET['numero'];
	$consulta="select * from ".$tabla." where cod_estado=".$codigo;
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
	parent.cont.location.href=retorno+".php?pagina=<?=$pagina?>"
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
<TR><td class=tb-head >C&oacute;digo</td><td><INPUT type="text" name="codigo" size="100" readonly="true" value="<?echo $codigo?>"></td> </tr>
<INPUT type="hidden" name="pagina" value="<?echo "$pagina";?>"></td>


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