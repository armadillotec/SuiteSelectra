<?php 
session_start();
ob_start();
?>
<?
include("../lib/common.php");
include("../header.php");
include("func_bd.php");

$parametro = $_GET['mes'];

$mes = substr($_GET['mes'],0,2);
if($mes == 1)
	$mesl = "Enero";
elseif($mes == 2)
	$mesl = "Febrero";
elseif($mes == 3)
	$mesl = "Marzo";
elseif($mes == 4)
	$mesl = "Abril";
elseif($mes == 5)
	$mesl = "Mayo";
elseif($mes == 6)
	$mesl = "Junio";
elseif($mes == 7)
	$mesl = "Julio";
elseif($mes == 8)
	$mesl = "Agosto";
elseif($mes == 9)
	$mesl = "Septiembre";
elseif($mes == 10)
	$mesl = "Octubre";
elseif($mes == 11)
	$mesl = "Noviembre";
elseif($mes == 12)
	$mesl = "Diciembre";

$pagina=1;
$var_sql = "SELECT imagen_izq, imagen_der FROM nomempresa";
	$rs = sql_ejecutar($var_sql);
	$row_rs = mysql_fetch_array($rs);

	$var_imagen_izq = $row_rs['imagen_izq'];
	$var_imagen_der = $row_rs['imagen_der'];
	$encabezado=encabezado('','','','','../imagenes/SiSalud.bmp'.$var_imagen_izq,'../imagenes/SiSalud.bmp'.$var_imagen_der);
	//cerrar_conexion($Conn);
	


$consulta11 = "select count(mes)as meses from nom_nominas_pago where mes='".$mes."'";
$resultado11=sql_ejecutar($consulta11);
$meses = fetch_array($resultado11);
if($meses['meses']!=4)
{
?>
<script type="text/javascript">
alert("No ha generado las nominas correspondientes para esa quincena!!")
window.close()
</script>
<?

}



?>

<table align="center" width="1500">
  <tbody>
    <tr>
      <td align="right"><INPUT type="button" name="imp" value="Imprimir" onclick="javascript:imprimir('area_impresion');"></td>
    </tr>
 <tr>
      <td align="right"><hr></td>
    </tr>
  </tbody>
</table>

<div id="area_impresion">
<table align="center" width="1500">
<TR>
<TD>
<? echo $encabezado;?>
</TD>
</TR>
</table>

<table align="center" width="1500">
<tbody>

<tr>
	<td align="center"><strong>APORTES PATRONALES POR EMPLEADOS Y OBREROS</strong></td>
</tr>
<tr>
	<td align="center">Mes de <? echo $mesl." "; echo date('Y');?></td>
</tr>

</tbody>
</table>
<br />

<table align="center" width="1500" >
<tbody>
<tr style="border-bottom-style : solid; border-bottom-width : 1px; font-weight : bold; border-top-style : solid; border-top-width : 1px;">
<td align="center">Correspondiente a Empleados</td>		
</tr>
</tbody>
</table>


<table align="center" width="1500" >
  <tbody>

	<tr style="border-bottom-style : solid; border-bottom-width : 1px; font-weight : bold;">
	<td align="center" colspan="4">&nbsp;</td>
	<td align="center" colspan="14" style="border-left-style : solid; border-right-style : solid;">Asignaciones</td>
	<td align="center" colspan="4" style="border-left-style : solid; font-weight : bold; border-right-style : solid; font-weight : bold;">Deducciones</td>
	</tr>
    	<tr style="border-bottom-style : solid; border-bottom-width : 1px; font-weight : bold;">          
      	<td align="center" width="250">Apellidos y Nombres</td>
       	<td align="center" width="50">C&eacute;dula</td>
	<td align="center" width="250">Cargo</td>
        <td align="center" width="50">Fecha de ingreso</td>
      	<td align="center" width="50">Sueldo Mensual 4.01.01.01.00</td>
      	<td align="center" width="50">Sueldo Mensual 4.01.04.96.00</td>
	<td align="center" width="50">Prima Prof.</td>
	<td align="center" width="50">Bono de transp.</td>
	<td align="center" width="50">Ap. por guarderia</td>
	<td align="center" width="50">Beca x hijo</td>
	<td align="center" width="50">Cesta ticket</td>        
        <td align="center" width="50">Sueldo integral</td>
        <td align="center" width="50">Alicuota de B. V.</td>
        <td align="center" width="50">Alicuota aguinaldo</td>
	<td align="center" width="50">Antiguedad</td>
	<td align="center" width="50">Aguinaldo</td>
	<td align="center" width="50">B vac empleados</td>
	<td align="center" width="50">Sueldo base IVSS</td>
	<td align="center" width="50">Ap. patronal IVSS</td>
	<td align="center" width="50">Ap. patronal FSPF</td>
	<td align="center" width="50">Ap. patronal FJEP</td>
	<td align="center" width="50">Ap. patronal FAH</td>		
    	</tr>
<?
$consulta12 = "select codnom,tipnom from nom_nominas_pago where mes='".$mes."' ORDER BY tipnom";
$resultado12=sql_ejecutar($consulta12);

$consulta="select apenom, suesal, ficha, cedula, tipnom, codcargo, fecing from nompersonal ORDER BY ficha, codnivel2";
$resultado=sql_ejecutar($consulta);
$i = $cont = 1;
$j = 0;
while($fila=fetch_array($resultado))
{
	$consulta333 = "SELECT des_car FROM nomcargos WHERE cod_car = '".$fila['codcargo']."'";
	$resultado333 = sql_ejecutar($consulta333);
	$fetch333 = fetch_array($resultado333);
	$basespf = $fila['suesal']/30;		
	$k=$m1=$m2=$fila_personal1=$fila_personal2=$fila_personal3=$fila_personal4=$fila_personal5=0;
	$resultado12=sql_ejecutar($consulta12);
	while($nominas = fetch_array($resultado12))
	{
		$c=0;
		$con=2001; //"supuesta" prima de profesionalizacion 
		while($c<5)
		{		
			$consulta="select monto from nom_movimientos_nomina where cedula='".$fila['cedula']."' and ficha='".$fila['ficha']."'  and codnom='".$nominas['codnom']."' and tipnom = '".$nominas['tipnom']."' and codcon='".$con."' ";
			$resultado_personal=sql_ejecutar($consulta);
			$montoss=fetch_array($resultado_personal);
			$montos=$montoss['monto'];
			if(($montos)&&($c==0))
			{
				$fila_personal1=$montos;
				$fila_personal1=($fila_personal1*2);
			}
			elseif(($montos)&&($c==1))
			{
				$fila_personal2=$montos;
				$fila_personal2=($fila_personal2*2);
			}
			elseif(($montos)&&($c==2))
			{
				$fila_personal3=$montos;
				$fila_personal3=($fila_personal3*2);
			}
			elseif(($montos)&&($c==3))
			{
				$fila_personal4=$montos;
				$fila_personal4=($fila_personal4*2);
			}
			elseif(($montos)&&($c==4))
			{
				$fila_personal5=$montos;
				$fila_personal5=($fila_personal5*2);
			}
			if($c==0)
				$con=2002;		//"supuesto" bono de transporte
			elseif($c==1)
				$con=2003;		//"supuesto" bono de guarderia
			elseif($c==2)
				$con=2003;		//"supuesto" beca por hijo
			elseif($c==3)
				$con=2003;		//"supuesto" cesta ticket
			$c+=1;
		}
				
	if(($montos)&&($k==0))
		{
			if(($nominas['tipnom'] == 3)&&($j == 0))
			{
				?>                
                <tr>      
                <td colspan="3" align="right"><strong>Total empleados:&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                <!--<td></td>-->
                <td align="right"><strong><? echo number_format($totsuel,2,',','.');?></strong></td>
                <td align="right"><strong><? echo number_format($totbasespf,2,',','.');?></strong></td>        
               <td align="right"><strong><? echo number_format($tot1,2,',','.');?></strong></td>        
                <td align="right"><strong><? echo number_format($tot2,2,',','.');?></strong></td>	
                <td align="right"><strong><? echo number_format($tot3,2,',','.');?></strong></td>        
                <td align="right"><strong><? echo number_format($tot4,2,',','.');?></strong></td>	 	              
                <td align="right"><strong><? echo number_format($tot5,2,',','.');?></strong></td>	 	              
             	<td align="right"><strong><? echo number_format($totaltotal,2,',','.');?></strong></td>
           		</tr>
                
</tbody>
</table><table align="center" width="1500" >
<tbody>
<tr style="font-weight : bold; border-top-style : solid; border-top-width : 1px;">
<td align="center">Correspondiente a Obreros</td>		
</tr>
</tbody>
</table>
<table align="center" width="1500">
<tbody>
	<tr style="border-bottom-style : solid; border-top-style : solid; border-bottom-width : 1px; font-weight : bold;">
	<td align="center" colspan="4">&nbsp;</td>
	<td align="center" colspan="14" style="border-left-style : solid; border-right-style : solid;">Asignaciones</td>
	<td align="center" colspan="4" style="border-left-style : solid; font-weight : bold; border-right-style : solid; font-weight : bold;">Deducciones</td>
	</tr>
	<tr style="border-bottom-style : solid; border-bottom-width : 1px; font-weight : bold; border-top-style : solid; border-top-width : 1px;">
	<td align="center" width="250">Apellidos y Nombres</td>
       	<td align="center" width="50">C&eacute;dula</td>
	<td align="center" width="250">Cargo</td>
        <td align="center" width="50">Fecha de ingreso</td>
      	<td align="center" width="50">Sueldo Mensual 4.01.01.01.00</td>
      	<td align="center" width="50">Sueldo Mensual 4.01.04.96.00</td>
	<td align="center" width="50">Prima Prof.</td>
	<td align="center" width="50">Bono de transp.</td>
	<td align="center" width="50">Ap. por guarderia</td>
	<td align="center" width="50">Beca x hijo</td>
	<td align="center" width="50">Cesta ticket</td>        
        <td align="center" width="50">Sueldo integral</td>
        <td align="center" width="50">Alicuota de B. V.</td>
        <td align="center" width="50">Alicuota aguinaldo</td>
	<td align="center" width="50">Antiguedad</td>
	<td align="center" width="50">Aguinaldo</td>
	<td align="center" width="50">B vac empleados</td>
	<td align="center" width="50">Sueldo base IVSS</td>
	<td align="center" width="50">Ap. patronal IVSS</td>
	<td align="center" width="50">Ap. patronal FSPF</td>
	<td align="center" width="50">Ap. patronal FJEP</td>
	<td align="center" width="50">Ap. patronal FAH</td>			
</tr>
              <?                  	
				$j++;
				
				$totsuelempl = $totsuel;
				$totbasespfempl = $totbasespf;
				$tot11 = $tot1;
				$tot12 = $tot2;
				$tot13 = $tot3;
				$tot14 = $tot4;
				$tot15 = $tot5;
				$totaltotalempl = $totaltotal;	
				
				$totsuel = 0;
				$totbasespf = 0;
				$tot1 = 0;
				$tot2 = 0;
				$tot3 = 0;
				$tot4 = 0;
				$tot5 = 0;
				$totaltotal = 0;	
			}
			
			$k++;
		}
		elseif($k==1)
		{
					
			$k++;
		}
	}
	
	$pal = $fila_personal1+$fila_personal2+$fila_personal3+$fila_personal4+$fila['suesal'];
	$ali_vac = (($pal*40)/12)/30;
	$ali_agui = (($pal*105)/12)/30;
	// Descripcion del cargo de la persona
	$consulta333 = "SELECT des_car FROM nomcargos WHERE cod_car = '".$fila['codcargo']."'";
	$resultado333 = sql_ejecutar($consulta333);
	$fetch333 = fetch_array($resultado333);
?>
  <tr>
      
      
      	<td align="left"><? echo $fila['apenom'];?></td>
      	<td align="center"><? echo number_format($fila['cedula'],0,',','.');?></td>
	<td align="center"><? echo $fetch333['des_car'];?></td>
      	<td aling="center"><? echo fecha($fila['fecing']);?></td>
	<td align="right"><? echo number_format($fila['suesal'],2,',','.');?></td>
        <td align="right"><? echo number_format($basespf,2,',','.');?></td>        
        <td align="right"><? echo number_format($fila_personal1,2,',','.');?></td>
        <td align="right"><? echo number_format($fila_personal2,2,',','.');?></td>
        <td align="right"><? echo number_format($fila_personal3,2,',','.');?></td>
        <td align="right"><? echo number_format($fila_personal4,2,',','.');?></td>	      
        <td align="right"><? echo number_format($fila_personal5,2,',','.');?></td>	      
    	<td align="right"><? $total=$pal; echo number_format($total,2,',','.');?></td>
	<td align="right"><? echo number_format($ali_vac,2,',','.');?></td>
	<td align="right"><? echo number_format($ali_agui,2,',','.');?></td>
	<td align="right"><? echo number_format($fila_personal5,2,',','.');?></td>
	<td align="right"><? echo number_format($fila_personal5,2,',','.');?></td>
	<td align="right"><? echo number_format($fila_personal5,2,',','.');?></td>
	<td align="right"><? echo number_format($fila_personal5,2,',','.');?></td>
	<td align="right"><? echo number_format($fila_personal5,2,',','.');?></td>
	<td align="right"><? echo number_format($fila_personal5,2,',','.');?></td>
	<td align="right"><? echo number_format($fila_personal5,2,',','.');?></td>
	<td align="right"><? echo number_format($fila_personal5,2,',','.');?></td>
	
    </tr>
	<?
    	$totsuel += $fila['suesal'];
	$totbasespf += $basespf;
	$tot1 += $fila_personal1;
	$tot2 += $fila_personal2;
	$tot3 += $fila_personal3;
	$tot4 += $fila_personal4;
	$tot5 += $fila_personal5;
	$totaltotal += $total; 
		
    $i++;
    $cont++;
    
    if($cont>=24)
    {
        $cont = 1;
    ?>
      </tbody>
    </table>
    
    <?
    echo $pie = pie_irem();
    echo "<br class=\"saltopagina\">";
    echo $encabezado;//encabezado($nomina_id, $pagina);
    ?>
    
    
    <table align="center">
      <tbody>
    	<tr>
		<td align="center"><strong>RELACI&Oacute;N DEL CALCULO DE ANTIGUEDAD</strong></td>
		</tr>
		<tr>
		<td align="center">Mes de <? echo $mesl." "; echo date('Y');?></td>
		</tr>
      </tbody>
    </table>
    <br>
    
    <table align="center" width="1500" >
      <tbody>
        <tr style="border-bottom-style : solid; border-bottom-width : 1px; font-weight : bold;">
         
     <tr style="border-bottom-style : solid; border-bottom-width : 1px; font-weight : bold;">          
      	<td align="center" width="250">Apellidos y Nombres</td>
       	<td align="center" width="50">C&eacute;dula</td>
	<td align="center" width="250">Cargo</td>
        <td align="center" width="80">Fecha de ingreso</td>
      	<td align="center" width="50">Sueldo Mensual</td>
      	<td align="center" width="50">Sueldo diario</td>
	<td align="center" width="50">Bono de transp.</td>
        <td align="center" width="50">Prima Prof.</td>
        <td align="center" width="50">Sueldo integral</td>
        <td align="center" width="50">Alicuota de B. V.</td>
        <td align="center" width="50">Alicuota aguinaldo</td>
	<td align="center" width="50">Total antig 4.01.08.02.00</td>
	<td align="center" width="50"></td>
	<td align="center" width="50"></td>
	<td align="center" width="50"></td>	
	<td align="center" width="50"></td>
	<td align="center" width="50"></td>
	<td align="center" width="50"></td>
	<td align="center" width="50"></td>
	<td align="center" width="50"></td>
	<td align="center" width="50"></td>
	<td align="center" width="50"></td>
				
    
       <?
          if($j==0)
          {
          ?>  
			<td align="center" width="50">Total antig 4.01.08.01.00</td>
          <?
           }
           else
           {
           ?> 
           <td align="center" width="50">Total antig 4.01.08.02.00</td>
           	 <? 
            }
            ?>
		
        </tr>
    
    <?
    }
}
?>

<tr>      
<td colspan="3" align="center"><strong>Total obreros:&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
<!--<td></td>-->
<td align="right"><strong><? echo number_format($totsuel,2,',','.');?></strong></td>      
<td align="right"><strong><? echo number_format($totbasespf,2,',','.');?></strong></td>        
<td align="right"><strong><? echo number_format($tot1,2,',','.');?></strong></td>        
<td align="right"><strong><? echo number_format($tot2,2,',','.');?></strong></td>	
<td align="right"><strong><? echo number_format($tot3,2,',','.');?></strong></td>        
<td align="right"><strong><? echo number_format($tot4,2,',','.');?></strong></td>	              
<td align="right"><strong><? echo number_format($tot5,2,',','.');?></strong></td>	              
<td align="right"><strong><? echo number_format($totaltotal,2,',','.');?></strong></td>
<td align="right"><?// echo number_format($fila_personal5,2,',','.');?></td>
<td align="right"><?// echo number_format($fila_personal5,2,',','.');?></td>
<td align="right"><?// echo number_format($fila_personal5,2,',','.');?></td>
<td align="right"><?// echo number_format($fila_personal5,2,',','.');?></td>
<td align="right"><?// echo number_format($fila_personal5,2,',','.');?></td>
<td align="right"><?// echo number_format($fila_personal5,2,',','.');?></td>
<td align="right"><?// echo number_format($fila_personal5,2,',','.');?></td>
<td align="right"><?// echo number_format($fila_personal5,2,',','.');?></td>
<td align="right"><?// echo number_format($fila_personal5,2,',','.');?></td>
<td align="right"><?// echo number_format($fila_personal5,2,',','.');?></td>
<td align="right"><?// echo number_format($fila_personal5,2,',','.');?></td>
</tr>

<tr>      
<td colspan="3" align="center"><strong>Total general:&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
<!--<td></td>-->
<td align="right"><strong><? echo number_format($totsuel + $totsuelempl,2,',','.');?></strong></td>
<td align="right"><strong><? echo number_format($totbasespf + $totbasespfempl,2,',','.');?></strong></td>        
<td align="right"><strong><? echo number_format($tot1 + $tot11,2,',','.');?></strong></td>        
<td align="right"><strong><? echo number_format($tot2 + $tot12,2,',','.');?></strong></td>      
<td align="right"><strong><? echo number_format($tot3 + $tot13,2,',','.');?></strong></td>      
<td align="right"><strong><? echo number_format($tot4 + $tot14,2,',','.');?></strong></td>      	              
<td align="right"><strong><? echo number_format($tot5 + $tot15,2,',','.');?></strong></td>      	              
<td align="right"><strong><? echo number_format($totaltotal + $totaltotalempl,2,',','.');?></strong></td>
<td align="right"><?// echo number_format($fila_personal5,2,',','.');?></td>
<td align="right"><?// echo number_format($fila_personal5,2,',','.');?></td>
<td align="right"><?// echo number_format($fila_personal5,2,',','.');?></td>
<td align="right"><?// echo number_format($fila_personal5,2,',','.');?></td>
<td align="right"><?// echo number_format($fila_personal5,2,',','.');?></td>
<td align="right"><?// echo number_format($fila_personal5,2,',','.');?></td>
<td align="right"><?// echo number_format($fila_personal5,2,',','.');?></td>
<td align="right"><?// echo number_format($fila_personal5,2,',','.');?></td>
<td align="right"><?// echo number_format($fila_personal5,2,',','.');?></td>
<td align="right"><?// echo number_format($fila_personal5,2,',','.');?></td>
<td align="right"><?// echo number_format($fila_personal5,2,',','.');?></td>
</tr>

</tbody>
</table>

<table align="center" width="1500">
  <tbody>
 <tr>
      <td><hr></td>
    </tr>
   
  </tbody>
</table>


<?
echo $pie = pie_irem_rrhh();
?>


</div>


<table align="center" width="1500">
  <tbody>
 <tr>
      <td align="right"></td>
    </tr>
    <tr>
      <td align="right"><INPUT type="button" name="imp" value="Imprimir" onclick="javascript:imprimir('area_impresion');"></td>
    </tr>

  </tbody>
</table>

</body>
</html>