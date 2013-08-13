<?php
/*
 * <DATOS DE CONEXION A BASE DE DATOS>
 */
require_once($_SERVER['DOCUMENT_ROOT'].'/pyme/generalp.config.inc.php');

define("USUARIO",DB_USUARIO);
define("CLAVE",DB_CLAVE);
define("BASEDEDATOS",$_SESSION['EmpresaFacturacion']);
define("SERVIDOR", DB_HOST);
define("GESTOR_DATABASE","mysql"); //mysql, postgrest
/*
 * </DATOS DE CONEXION A BASE DE DATOS>
 */

/*
 * <CONSTANTES DE TABLA TIPO_PRECIO>
 * Ej: Valores actuales de la tabla.
 *      cod_tipo_precio |	descripcion
                1       |       Libre
             	2       |       xxxx
                3       |       xxxx
                4       |       xxxx
 */
define("codTipoPrecioLibre",1);
define("codTipoPrecio1",2);
define("codTipoPrecio2",3);
define("codTipoPrecio3",4);

/*
 * </CONSTANTES DE TABLA TIPO_PRECIO>
 */
?>