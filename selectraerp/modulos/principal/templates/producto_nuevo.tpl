<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <script type="text/javascript" src="../../libs/js/config_items_tabs.js"></script>
        <script type="text/javascript" src="../../libs/js/ajax.js"></script>
        <link type="text/css" rel="stylesheet" href="../../../includes/css/estilos_basicos.css" />
        {literal}
            <script type="text/javascript">//<![CDATA[
            function buscarProducto(id,nombre,empaque,cantidad)
            {
                var miId = document.getElementById(id);
                var miItem = document.getElementById('cod_item');

                cargarUrl('buscarProducto.php?codigo=' + miId.value + '&campo=' + id + '&nombre=' + nombre + '&empaque=' + empaque + '&cantidad=' + cantidad, 'TRANSPARENTE' );
                setTimeout ("sumaTotal()", 3000);
            }

            function sumaTotal()
            {
                var total = 0;

                for(var i=1;i<=20;i++){
                    var aux = document.getElementById('sub_total' + i);
                    total = (total * 1) + (aux.value * 1);
                }

                var aux2 = document.getElementById('suma_total');
                    aux2.value = redondear(total);
                var aux3 = document.getElementById('costo_actual');
                    aux3.value = aux2.value;
                    aux3.onchange();
            }

            function agregarItem(codigo)
            {
                var aux = document.getElementById('id0');
                    aux.value=codigo;
                    aux.onchange();
                var aux = document.getElementById('busqueda');
                    aux.value='';
                var aux = document.getElementById('cuadroBusqueda');
                    aux.innerHTML='Inserte palabras claves del producto a seleccionar';
            }

            function buscarProductoLista(cadena)
            {
                cargarUrl('buscarProductoLista.php?cadena=' + cadena , 'cuadroBusqueda' );
            }

            function ocultarVarios(objeto)
            {
                var aux = document.getElementById(objeto);
                var e=aux.getElementsByTagName("input");

                for(var i=0;i<e.length;i++){
                    e[i].style.visibility = 'hidden';
                }

                var e=aux.getElementsByTagName("img");

                for(var i=0;i<e.length;i++){
                    e[i].style.visibility = 'hidden';
                }
            }

            function calcularPrecio(cantidad,precio,sub_total)
            {
                var cant = cantidad.value;
                var monto = document.getElementById(precio).value;
                var sub = document.getElementById(sub_total);
                    sub.value = redondear(cant * monto);
                sumaTotal();
            }

            function eliminarProducto(posicion)
            {
                var aux = document.getElementById('item' + posicion);

                while (aux.value != ''){
                    var item = document.getElementById('item' + posicion);
                    var id = document.getElementById('id' + posicion);
                    var nombre = document.getElementById('nombre' + posicion);
                    var empaque = document.getElementById('empaque' + posicion);
                    var cantidad = document.getElementById('cantidad' + posicion);
                    var precio = document.getElementById('precio' + posicion);
                    var sub_total = document.getElementById('sub_total' + posicion);

                    posicion = (posicion * 1) + 1;

                    var item2 = document.getElementById('item' + posicion);
                    var id2 = document.getElementById('id' + posicion);
                    var nombre2 = document.getElementById('nombre' + posicion);
                    var empaque2 = document.getElementById('empaque' + posicion);
                    var cantidad2 = document.getElementById('cantidad' + posicion);
                    var precio2 = document.getElementById('precio' + posicion);
                    var sub_total2 = document.getElementById('sub_total' + posicion);

                    item.value= item2.value;
                    id.value = id2.value;
                    nombre.value = nombre2.value;
                    empaque.value= empaque2.value;
                    cantidad.value = cantidad2.value;
                    precio.value= precio2.value;
                    sub_total.value = sub_total2.value;

                    var aux = document.getElementById('item' + posicion);
                }

                posicion = (posicion * 1) - 1;

                var item2 = document.getElementById('item' + posicion);
                var id2 = document.getElementById('id' + posicion);
                var nombre2 = document.getElementById('nombre' + posicion);
                var empaque2 = document.getElementById('empaque' + posicion);
                var cantidad2 = document.getElementById('cantidad' + posicion);
                var precio2 = document.getElementById('precio' + posicion);
                var sub_total2 = document.getElementById('sub_total' + posicion);
                var eliminar = document.getElementById('eliminar' + posicion);

                item2.style.visibility='hidden';
                id2.style.visibility='hidden';
                nombre2.style.visibility='hidden';
                empaque2.style.visibility='hidden';
                cantidad2.style.visibility='hidden';
                precio2.style.visibility='hidden';
                sub_total2.style.visibility='hidden';
                eliminar.style.visibility='hidden';
            }

            function redondear(cantidad, decimales) {
                var cantidad = parseFloat(cantidad);
                var decimales = parseFloat(decimales);
                    decimales = (!decimales ? 2 : decimales);
                return Math.round(cantidad * Math.pow(10, decimales)) / Math.pow(10, decimales);
            }

            function calcularMonto(precio, utilidad, campoiva, ocultos){
                /*
                Función modificada para hacer funcionar correctamente
                la configuración de productos exentos o no de IVA.
                */
                var exonerado = document.getElementById('monto_exento');
                var iva = document.getElementById('iva');
                precio.value = parseFloat(ocultos.value * (1 + (parseFloat(utilidad.value) / 100)));
                precio.value = redondear(precio.value,2);

                if (exonerado.value == '1'){
                        // Cambiar cero (0) el valor para guardarlo en campo 'iva' de la tabla 'item'
                        iva.value = 0;
                        campoiva.value = precio.value;
                    }
                    else{
                        // Cambiar al valor configurado IVA para guardarlo en campo 'iva' de la tabla 'item'
                        iva.value = {/literal}{$parametros_generales[0].porcentaje_impuesto_principal}{literal};
                        campoiva.value = redondear(precio.value * (1 + (iva.value/100)), 2);
                    }
            }

            function calcular_todo()
            {
                var aux= document.getElementById('formulario');

                calcularMonto(aux.precio_1,aux.utilidad1,aux.coniva1,aux.ocultos1);
                calcularMonto(aux.precio_2,aux.utilidad2,aux.coniva2,aux.ocultos2);
                calcularMonto(aux.precio_3,aux.utilidad3,aux.coniva3,aux.ocultos3);
            }

            function agregar_impuesto(){
              var fieldset=document.getElementById("tabla_total");
              var inputs=document.getElementsByName("alternativa");
              //var br=document.createElement("br");
              var newInput=document.createElement("select");
              newInput.className = 'form-text';
              var tr=document.createElement("tr");
              var td=document.createElement("td");

              //var impuestos = '{/literal}{$key_impuestos}{literal}';
            {/literal}
            {foreach from=$lista_impuestos key=index item=impuestos}
                {literal}
                var descripcion = '{/literal}{$impuestos.descripcion}{literal}';
                var option = document.createElement('option');
                option.text = descripcion;
                option.value = '{/literal}{$index}{literal}';
                newInput.add(option, '{/literal}{$index}{literal}');
                {/literal}
            {/foreach}
            {literal}

              td.colSpan = "4";
              //newInput.name="alternativa";
              ////newInput.size=100;
              //newInput.id="alt"+(inputs.length+1);

              var btnRemove=document.createElement("input");
              btnRemove.type="button";
              btnRemove.value="Elmininar";

              tr.appendChild(td);
              tr.className = 'label';
              td.appendChild(newInput);
              td.appendChild(btnRemove);

              var tbody = document.getElementById("tbody");
              tbody.appendChild(tr);

              btnRemove.onclick = function(){
                var elem = this.parentNode;
                elem.parentNode.removeChild(elem);
              };
            }

            $(document).ready(function(){
                $("#cod_departamento").focus();
                $("#cod_item").blur(function(){
                    return false;
                    vcoditem = $(this).val();
                    if(vcoditem!=''){
                        $.ajax({
                            type: "GET",
                            url:  "../../libs/php/ajax/ajax.php",
                            data: "opt=ValidarCodigoitem&v1="+vcoditem,
                            beforeSend: function(){
                                $("#notificacionVCoditem").html(MensajeEspera("<b>Veficando Cod. item..<b>"));
                            },
                            success: function(data){
                                resultado = data;
                                if(resultado=="-1"){
                                    //$("#cod_item").val("").focus();
                                    $("#notificacionVCoditem").html("<img align=\"absmiddle\" src=\"../../libs/imagenes/ico_note.gif\"><span style=\"color:red;\"><b>Disculpe, este c&oacute;digo ya existe.</b></span>");
                                }
                                else if(resultado=="1"){//cod de item disponble, originalmente sin "else"
                                    $("#notificacionVCoditem").html("<img align=\"absmiddle\" src=\"../../libs/imagenes/ok.gif\"><span style=\"color:#0c880c;\"><b> C&oacute;digo Disponible</b></span>");
                                }
                            }
                        });
                        }
                    });

                    $("#formulario").submit(function(){
                        if($("#cod_item").val()==""||$("#descripcion1").val()==""){
                            alert("Debe Ingresar los campos obligatorios!.");
                            $("#descripcion1").focus();
                            return false;
                        }
                    });
                });
                //]]>
            </script>
            <style type="text/css">
                .tab{
                    text-align:left;
                    background-color:#d0d0d0;
                    padding-left:10px;
                    padding-right:10px;
                    font-size:11px;
                    font-family: arial;
                    color:#a0a0a0;
                    cursor: pointer;
                    width:auto;
                    border-left: 1px solid #8d8f91;
                    border-right: 1px solid #8d8f91;
                    border-top: 1px solid #8d8f91;
                }
                .sobreboton{
                    background-color:#bec0c1;
                }
                .click{
                    background: url('../../libs/imagenes/azul/tb_tit.jpg') repeat-x;
                    color:black;
                    border-left: 1px solid #8d8f91;
                    border-right: 1px solid #8d8f91;
                    border-top: 1px solid #8d8f91;
                }
                input{
                    color:black;
                    readonly:false;
                }
                #productosKit{
                    position:absolute;
                    right:20px;
                    height:300px;
                }
                #contenedorTAB {
                    background-color: #e3ebf1;
                    border-radius: 5px;
                    padding: 2px;
                    border: 1px solid #adafb0;
                    width:550px;
                }
                #tabs {
                    margin-top:15px;
                }
            </style>
        {/literal}
    </head>
    <body>
        <form name="formulario" id="formulario" method="post" action="">
            <input type="hidden" name="codigo_empresa" value="{$DatosEmpresa[0].codigo}"/>
            <input type="hidden" name="opt_menu" value="{$smarty.get.opt_menu}"/>
            <input type="hidden" name="opt_seccion" value="{$smarty.get.opt_seccion}"/>
            <table style="width: 100%;">
                <tbody>
                    <tr>
                        <td class="tb-tit">
                            <img src="{$subseccion[0].img_ruta}" width="20" height="20" style="vertical-align: middle;"/>
                            <strong>{$subseccion[0].descripcion}</strong>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div id="tabs">
                <table style="margin-left:20px;">
                    <tr style="height:25px;">
                        <td id="tab1" class="tab">
                            <img src="../../libs/imagenes/1.png" width="20" height="20" style="vertical-align: middle;"/>&nbsp;<b>Datos Generales</b>
                        </td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                </table>
            </div>
            <div id='productosKit'></div>
            <div id="contenedorTAB">
                <!-- TAB1 -->
                <div id="div_tab1">
                    <table style="width: 100%; height: 100px;">
                        <tr>
                            <td colspan="4" class="label" style="text-align: center;">COMPLETLE LOS CAMPOS MARCADOS CON&nbsp;** OBLIGATORIAMENTE</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="label" style="width: 30%;">&Uacute;ltimo C&oacute;digo</td>
                            <td>
                                <input type="text" name="ultimo_codigo" id="ultimo_codigo" size="60" value="{$nro_productoOLD}" disabled class="form-text"/>
                                <div id="notificacionVCoditem"></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" width="30%" class="label">C&oacute;digo **</td>
                            <td>
                                <input type="text" name="cod_item" id="cod_item" size="60" value="{$nro_productoNEW}" class="form-text"/>
                                <div id="notificacionVCoditem"></div>
                            </td>
                        </tr>
                        <!--tr>
                            <td class="label" colspan="4" align="center" width="180">DATOS DEL item</td>
                        </tr-->
                        <tr>
                            <td colspan="3" class="label">{$DatosGenerales[0].string_clasificador_inventario1}</td>
                            <td>
                                <select name="cod_departamento" id="cod_departamento" class="form-text">
                                    {html_options values=$option_output_departamentos output=$option_values_departamentos}
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="label">{$DatosGenerales[0].string_clasificador_inventario2}</td>
                            <td>
                                <select name="cod_grupo" id="cod_grupo" class="form-text">
                                    {html_options values=$option_output_grupo output=$option_values_grupo}
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="label">{$DatosGenerales[0].string_clasificador_inventario3}</td>
                            <td>
                                <select name="cod_linea" id="cod_linea" class="form-text">{html_options values=$option_output_linea output=$option_values_linea}</select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="label">C&oacute;digo de barras</td>
                            <td>
                                <input type="text" name="cod_barras" id="cod_barras" size="60" value="{$campos_item[0].codigo_barras}" class="form-text"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="label">Descripci&oacute;n 1 **</td>
                            <td>
                                <input type="text" name="descripcion1" id="descripcion1" size="60" value="{$campos_item[0].descripcion1}" class="form-text"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="label" colspan="3">Descripci&oacute;n 2<td>
                                <input type="text" name="descripcion2" id="descripcion2" size="60" value="{$campos_item[0].descripcion2}" class="form-text"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="label" colspan="3">Descripci&oacute;n 3</td>
                            <td>
                                <input type="text" name="descripcion3" id="descripcion3" size="60" value="{$campos_item[0].descripcion3}" class="form-text"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="label" colspan="3">Referencia</td>
                            <td>
                                <input type="text" name="referencia" id="referencia" size="60" value="{$campos_item[0].referencia}" class="form-text"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="label" colspan="3">Empaque</td>
                            <td>
                                <input type="text" name="empaque" id="empaque" size="60" value="{$campos_item[0].unidad_empaque}" onchange='this.form.empaque_descripcion.value = this.value;' class="form-text"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="label" colspan="3">Unidad Empaque</td>
                            <td>
                                <input type="text" name="unidad_empaque" id="unidad_empaque" size="5" value="{$campos_item[0].cantidad}" class="form-text"/>
                                <input type="text" name="empaque_descripcion" id="empaque_descripcion" size="5" value="{$campos_item[0].unidad_empaque}" readonly style="border-style:none; background:none;" class="form-text"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="label" colspan="3">Tipo de Producto</td>
                            <td>
                                <select name="tipo" id="tipo" class="form-text">
                                    <option>Seleccione el uso del producto</option>
                                    {html_options values=$option_values_tipo output=$option_output_tipo selected=$option_selected_tipo}
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label" colspan="3">C&oacute;digo Fabricante</td>
                            <td>
                                <input type="text" name="codigo_fabricante" id="codigo_fabricante" size="60" value="{$campos_item[0].codigo_fabricante}" class="form-text"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="label" colspan="3">Estatus</td>
                            <td>
                                <select name="estatus" id="estatus" class="form-text">
                                    <option value="A">Activo</option>
                                    <option value="I">Inactivo</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="vertical-align: top; width: 30%;" class="label">Cuenta Contable 1</td>
                            <td>
                                <select name="cuenta_contable1" id="cuenta_contable1" class="form-text">
                                    {html_options values=$option_values_cuenta output=$option_output_cuenta}
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="vertical-align: top; width: 30%;" class="label">Cuenta Contable 2</td>
                            <td>
                                <select name="cuenta_contable2" id="cuenta_contable2" class="form-text">
                                    {html_options values=$option_values_cuenta output=$option_output_cuenta}
                                </select>
                            </td>
                        </tr>
                        <tr><td colspan="4"><hr/></td></tr>
                        <tr>
                            <td class="label" colspan="3"><br/></td>
                            <td>
                                Producto con Serial
                                <input type="checkbox" name="serial" id="serial" size="60" value='1' {$campoSerial} {literal} onclick="if (this.checked) { var aux = 'visible'; var aux2 = 'hidden'; document.getElementById('conFactor').style.visibility = 'hidden';} else {var aux = 'hidden'; var aux2 = 'visible'; document.getElementById('conFactor').style.visibility = 'visible'; } document.getElementById('serialGarantia').style.visibility = aux;  document.getElementById('productoKit').style.visibility = aux2;" class="form-text"/>
                                <div id='serialGarantia' style='display:inline; visibility:hidden'>
                                    &nbsp;&nbsp;&nbsp;&nbsp;Serial Con Garant&iacute;a.
                                    {/literal}
                                        <input type="checkbox" name="garantia" id="garantia" value='1' {$campoGarantia} class="form-text"/>
                                    </div>
                                    <br/>
                                    <div id='productoKit' style='display:inline;'>
                                        <div id='productoKit' style='display:inline;'>
                                            Producto con Kit
                                            <input type="checkbox" name="producto_kit" id="producto_kit" value='1' {$campos_kit} {literal} onclick="if (this.checked) {cargarUrl('kitproductos.php?codigo=' + this.form.cod_item.value,'productosKit'); document.getElementById('productosKit').style.visibility='visible';} else {document.getElementById('productosKit').style.visibility='hidden'; ocultarVarios('productosKit');}" class="form-text"/>
                                        </div>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        {/literal}
                                            <br/>
                                            <div style='padding:10px; border:1px; border-style:solid; border-color:green; -moz-border-radius:10px; width:200px;'>
                                                &nbsp;&nbsp;Tipo de Producto
                                                <br/>
                                                Nacional <input type="radio" name="tipo_producto" id="tipo_producto1" value='0' {$campoNacional} onchange="if (this.checked) var aux = 'hidden'; else var aux = 'visible'; document.getElementById('conFactor').style.visibility = aux; " class="form-text"/>
                                                &nbsp;&nbsp; Importado <input type="radio" name="tipo_producto" id="tipo_producto2" {$campoImportado} value='1' onchange="if (this.checked) var aux = 'visible'; else var aux = 'hidden'; document.getElementById('conFactor').style.visibility = aux;" class="form-text"/>
                                                <br/>
                                                <div id='conFactor' style='visibility:hidden;'>
                                                    Factor de Cambio
                                                    <input type="text" name="factor_cambios" id="factor_cambios" value="0.00" class="form-text"/>
                                                    <br/>
                                                    &Uacute;ltimo Costo
                                                    <input type="text" value="0.00" name="ultimo_costos" id="ultimo_costos" onchange="this.form.costo_actual.value= redondear(this.value * this.form.factor_cambios.value, 2) ; this.form.costo_actual.onchange();" class="form-text"/>
                                                </div>
                                            </div>
                                            <br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label" colspan="3">Costo Actual</td>
                                    <td>
                                        <input size="60" type="text" name="costo_actual" id="costo_actual" onchange='this.form.precio_1.value= this.value ; this.form.costo_promedio.value= this.value; this.form.costo_anterior.value= this.value; this.form.ocultos1.value= this.value;  this.form.ocultos2.value= this.value; this.form.ocultos3.value= this.value; calcular_todo();' value="{$campos_item[0].costo_actual}" class="form-text"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label" colspan="3">Costo Promedio</td>
                                    <td>
                                        <input size="60" type="text" name="costo_promedio" id="costo_promedio" value="{$campos_item[0].costo_promedio}" class="form-text"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label" colspan="3">Costo Anterior</td>
                                    <td>
                                        <input size="60" type="text" name="costo_anterior" id="costo_anterior" value="{$campos_item[0].costo_anterior}" class="form-text"/>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <!--/td>
                            </tr>
                            </tbody>
                            </table-->
                        </div>
                        <!-- /TAB1 -->
                        <!-- TAB2 -->
                        <div id="div_tab2"></div>
                        <!-- /TAB2 -->
                    </div>
                    <table style="width: 100%;">
                        <tr>
                            <td>
                                <br/>
                                <table>
                                    <tr>
                                        <td colspan="4" class="label" style="text-align:center;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="label" colspan="4" align="center" width="180"></td>
                                    </tr>
                                    <tr>
                                        <td class="label" colspan="3" style="text-align:right">&nbsp;&nbsp;&nbsp;</td>
                                        <td>
                                            <table id="tabla_total" style="border: 1px solid #507e95; background-color: white;">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align:left;">Costos</th>
                                                        <th style="text-align:left;">Utilidad</th>
                                                        <th style="text-align:left;">Con Utilidad</th>
                                                        <th style="text-align:left;">Gravado</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody">
                                                    <tr>
                                                        <td>
                                                            <input type='text' name='ocultos1' id='ocultos1' value="{$campos_item[0].p1}" onchange="calcular_todo();" size="9" class="form-text"/>
                                                        </td>
                                                        <td>
                                                            <input onchange="calcularMonto(this.form.precio_1,this,this.form.coniva1,this.form.ocultos1);" class="campo_decimal form-text" size="3" name="utilidad1" id="utilidad1" type="text" value="{$campos_item[0].utilidad1}" />
                                                            <label for="utilidad1">%</label>
                                                        </td>
                                                        <td>
                                                            <input onchange='calcular_todo();' class="campo_decimal form-text" title="{$DatosGenerales[0].titulo_precio1}" id="fila_precio1" name="precio_1" value="{$campos_item[0].precio1}" size="10" readonly type="text" />
                                                        </td>
                                                        <td>
                                                            <input class="campo_decimal form-text" id="fila_precio1_iva" name="coniva1" size="10" type="text" value="{$campos_item[0].coniva1}"/>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type='text' name='ocultos2' value="{$campos_item[0].p2}" onchange="calcular_todo();" size="9" class="form-text"></td>
                                                        <td>
                                                            <input onchange="calcularMonto(this.form.precio_2,this,this.form.coniva2,this.form.ocultos2);" class="campo_decimal form-text" size="3" name="utilidad2" id="utilidad2" type="text" value="{$campos_item[0].utilidad2}">
                                                            <label for="utilidad2">%</label>
                                                        </td>
                                                        <td><input onchange='this.form.oculto2.value=this.value; calcular_todo();' class="campo_decimal form-text" title="{$DatosGenerales[0].titulo_precio2}" id="fila_precio2" name="precio_2" readonly value="{$campos_item[0].precio2}" size="10" type="text"/></td>
                                                        <td><input class="campo_decimal form-text" id="fila_precio2_iva" value="{$campos_item[0].coniva2}" name="coniva2" size="10" type="text"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type='text' name='ocultos3' value="{$campos_item[0].p3}" onchange="calcular_todo();" size="9" class="form-text"/></td>
                                                        <td>
                                                            <input onchange="calcularMonto(this.form.precio_3,this,this.form.coniva3,this.form.ocultos3);" class="campo_decimal form-text" value="{$campos_item[0].utilidad3}" size="3" name="utilidad3" id="utilidad3" type="text">
                                                            <label for="utilidad3">%</label>
                                                        </td>
                                                        <td>
                                                            <input onchange='this.form.oculto3.value=this; calcular_todo();' class="campo_decimal form-text" title="{$DatosGenerales[0].titulo_precio3}" id="fila_precio3" name="precio_3" readonly value="{$campos_item[0].precio3}" size="10" type="text"/>
                                                        </td>
                                                        <td>
                                                            <input class="campo_decimal form-text" id="fila_precio3_iva"  value="{$campos_item[0].coniva3}" name="coniva3" size="10" type="text"/>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="label" align="center">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top" class="label" colspan="3"><b>Existencia M&iacute;nima del &iacute;tem</b></td>
                                                        <td>
                                                            <div class="string_empaque"></div>
                                                            <input onkeypress="return validarNumero(event)" name="existencia_min" type="text" value="{$campos_item[0].existencia_min}" class="form-text"/>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="label" colspan="3"><b>Existencia M&aacute;xima del &iacute;tem</b></td>
                                                        <td>
                                                            <div class="string_empaque"></div>
                                                            <input onkeypress="return validarNumero(event)" name="existencia_max" type="text" value="{$campos_item[0].existencia_max}" class="form-text"/>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="label" align="center">IMPUESTOS</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="label" align="left">Monto Exento</td>
                                                        <td>
                                                            <select name="monto_exento" id="monto_exento" onchange="calcular_todo();" class="form-text">
                                                                <option value="0">No</option>
                                                                <!-- <option value="1">Si</option> -->
                                                                <option value="1" {if $valor_iva[0].iva eq 0} selected {/if}>S&iacute;</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr class="monto_iva">
                                                        <td colspan="3" class="label" align="left">{$DatosGenerales[0].nombre_impuesto_principal}</td>
                                                        <td>
                                                            <!-- <input class="campo_decimal" type="text"  value="{$parametros_generales[0].porcentaje_impuesto_principal}" id="iva" name="iva"> -->
                                                            <!--input class="campo_decimal form-text" type="text" value="{$valor_iva[0].iva}" id="iva" name="iva"/-->
                                                            <select name="iva" id="iva" class="form-text" onchange="calcular_todo();">
                                                                {html_options values=$option_values_porcentaje_impuesto_principal selected=$option_selected_porcentaje_impuesto_principal output=$option_output_porcentaje_impuesto_principal}
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <!-- Aquí estaban los botones Guardar/Cancelar -->
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <!--Trabajando caracteristica-->
                                    <!--tr>
                                        <td colspan="4">
                                            <input type="Button" value="Agregar impuesto" onclick="agregar_impuesto()" class="form-text"/>
                                        </td>
                                    </tr-->
                                    <tr class="tb-tit" align="right">
                                        <td colspan="4">
                                            <input type="submit" name="aceptar" id="aceptar" value="Guardar" class="form-text"/>
                                            <input type="button" name="cancelar" onclick="javascript: document.location.href='?opt_menu={$smarty.get.opt_menu}&amp;opt_seccion={$smarty.get.opt_seccion}'" value="Cancelar" class="form-text"/>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="left:100px;">
                                <table style='width:200px; margin-left:200px; height:200px;  overflow:auto; background:white; border-radius:20px; border-style:none;'>
                                    <tr>
                                        <td colspan='2'>Existencia en Almac&eacute;n</td>
                                    </tr>
                                    <tr>
                                        <td style='background:#ccccdd; color:green; font-size:12px ; height:20px; font-weight:bold;'>Nombre Almac&eacute;n</td>
                                        <td style='color:green; height:20px; background:#ccccdd; width:30px'>Cantidad Existencia</td>
                                    </tr>
                                    {foreach from=$almacenes2 key=i item=miItem}
                                        <tr>
                                            <td style='color:blue; font-size:12px; font-weight:bold;'>{$miItem.descripcion}</td>
                                            <td style='background:#dddddd; width:30px'>{$miItem.cantidad}</td>
                                        </tr>
                                    {/foreach}
                                </table>
                                <!--/div-->
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name="pg_iva" id="pg_iva" value="{$parametros_generales[0].porcentaje_impuesto_principal}"/>
                </form>
                {literal}
                    <script type="text/javascript">//<![CDATA[
            var mikit= document.getElementById('producto_kit');
            mikit.onclick();

            var aux= document.getElementById('serial');
            aux.onclick();

            var aux= document.getElementById('tipo_producto1');
            aux.onchange();

            var aux= document.getElementById('tipo_producto2');
            aux.onchange();

        //]]>
                    </script>
                {/literal}
            </body>
        </html>