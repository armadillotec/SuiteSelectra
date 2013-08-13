<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title></title>
        <script type="text/javascript" src="../../libs/js/md5_crypt.js"></script>
        <script type="text/javascript" src="../../libs/js/cambiar_clave.js"></script>
    </head>
    <body>
        <div style="background-image:url('../../../includes/imagenes/top_bg.png'); background-repeat:repeat-x;">
            <table style="width:100%; background-image:url('../../../includes/imagenes/logo_bg.png'); background-repeat:no-repeat;" >
                <tr>
                    <td style="cursor:pointer; width:200px; height:60px;">
                        <img width="200" height="60" src="../../../includes/imagenes/logo.png" onclick="javascript: window.location.href='?opt_menu=54';"/>
                    </td>
                    <td>
                        <table style="width:100%">
                            <tr>
                                <td style="height:38px; text-align:right;">
                                    <table style="width:100%">
                                        <tr>
                                            <td style="width:90%"></td>
                                            <td style="width:10%">
                                                <div style="text-align:right">
                                                    <img src="../../../includes/imagenes/asys.png" width="100" height="38"/>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <table style="width:100%">
                            <tr>
                                <td style="width:20px"><img src="../../../includes/imagenes/sup_c22.png" width="20" height="23"/></td>
                                <td style="background-color: #517D96"><span style="color:#FFF;"><b>{$nombre}</b> ({$stringLoginUsuario}) de <b>{$DatosGenerales[0].nombre_empresa}</b> - Su &uacute;ltima sesión fue el d&iacute;a {$stringUltimaSesionFecha} a las {$stringUltimaSesionHora} - ID: {$idsesion}</span></td>
                                <td style="background-color: #517D96; cursor: pointer;" onclick="javascript: winClave.show();">
                                    <a style="color:#FFF;"><img src="../../../includes/imagenes/generar.png" width="22" height="22" class="icon"/>Cambiar Contrase&ntilde;a</a>
                                </td>
                                <td style="background-color: #517D96;">
                                    <a style="color:#FFF" href="index.php?logout=off" target="_top"><img src="../../../includes/imagenes/exit.png" width="22" height="22" class="icon"/>Salir</a>
                                </td>
                                <!--td style="background-color: #517D96; width:10px">&nbsp;</td-->
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div id="cambiarclave" class="x-hide-display">
            <table>
                <thead>
                    <tr style="text-align: center">
                        <th class="tb-tit" colspan="2"><b>Ingrese sus Datos</b></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="tb-head" style="text-align: left; width: 60%; padding-left: 2%;">Clave Anterior</td>
                        <td>
                            <input maxlength="90" type="password" name="claveOLD" size="30" id="claveOLD" />
                        </td>
                    </tr>
                    <tr>
                        <td class="tb-head" style="text-align: left; width: 60%; padding-left: 2%;">Nueva Clave</td>
                        <td><input maxlength="90" type="password" name="clave1" size="30" id="clave1" /></td>
                    </tr>
                    <tr>
                        <td class="tb-head" style="text-align: left; width: 60%; padding-left: 2%;">Confirmar Nueva Clave</td>
                        <td><input maxlength="90" type="password" name="clave2" size="30" id="clave2" /></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>