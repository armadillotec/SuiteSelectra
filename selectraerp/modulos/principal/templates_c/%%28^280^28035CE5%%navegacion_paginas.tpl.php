<?php /* Smarty version 2.6.21, created on 2013-08-02 17:43:08
         compiled from snippets/navegacion_paginas.tpl */ ?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    </head>
    <body>
        <table class="tb-head">
            <tbody>
                <tr>
                    <td><span>P&aacute;gina&nbsp;</span></td>
                    <td><a href="?opt_menu=<?php echo $_GET['opt_menu']; ?>
&amp;opt_seccion=<?php echo $_GET['opt_seccion']; ?>
&amp;pagina=1&amp;tipo=<?php echo $this->_tpl_vars['tipo']; ?>
&amp;des=<?php echo $this->_tpl_vars['des']; ?>
&amp;busqueda=<?php echo $this->_tpl_vars['busqueda']; ?>
&amp;codigo=<?php echo $this->_tpl_vars['ultimo_cod_valor']; ?>
"><img src="../../../includes/imagenes/b_firstpage.png" title="Primera" alt="Primera" style="width:16px; height: 16px; border: 0px"/></a></td>
                    <td><a href="?opt_menu=<?php echo $_GET['opt_menu']; ?>
&amp;opt_seccion=<?php echo $_GET['opt_seccion']; ?>
&amp;pagina=<?php echo $this->_tpl_vars['pagina']-1; ?>
&amp;tipo=<?php echo $this->_tpl_vars['tipo']; ?>
&amp;des=<?php echo $this->_tpl_vars['des']; ?>
&amp;busqueda=<?php echo $this->_tpl_vars['busqueda']; ?>
&amp;codigo=<?php echo $this->_tpl_vars['ultimo_cod_valor']; ?>
"><img src="../../../includes/imagenes/b_prevpage.png" alt="Anterior" title="Anterior" style="width:16px; height: 16px; border: 0px"/></a></td>
                    <td><input type="text" name="numero_pagina" value="<?php echo $this->_tpl_vars['pagina']; ?>
" onblur="javascript:paginacion('?opt_menu=<?php echo $_GET['opt_menu']; ?>
&amp;opt_seccion=<?php echo $_GET['opt_seccion']; ?>
',this.value,'&amp;tipo=<?php echo $this->_tpl_vars['tipo']; ?>
&amp;des=<?php echo $this->_tpl_vars['des']; ?>
&amp;busqueda=<?php echo $this->_tpl_vars['busqueda']; ?>
&amp;codigo=<?php echo $this->_tpl_vars['ultimo_cod_valor']; ?>
');" size="4"></td>
                    <td><a href="?opt_menu=<?php echo $_GET['opt_menu']; ?>
&amp;opt_seccion=<?php echo $_GET['opt_seccion']; ?>
&amp;pagina=<?php echo $this->_tpl_vars['pagina']+1; ?>
&amp;tipo=<?php echo $this->_tpl_vars['tipo']; ?>
&amp;des=<?php echo $this->_tpl_vars['des']; ?>
&amp;busqueda=<?php echo $this->_tpl_vars['busqueda']; ?>
&amp;codigo=<?php echo $this->_tpl_vars['ultimo_cod_valor']; ?>
"><img src="../../../includes/imagenes/b_nextpage.png" alt="Siguiente" title="Siguiente" style="width:16px; height: 16px; border: 0px"/></a></td>
                    <td><a href="?opt_menu=<?php echo $_GET['opt_menu']; ?>
&amp;opt_seccion=<?php echo $_GET['opt_seccion']; ?>
&amp;pagina=<?php echo $this->_tpl_vars['num_paginas']; ?>
&amp;tipo=<?php echo $this->_tpl_vars['tipo']; ?>
&amp;des=<?php echo $this->_tpl_vars['des']; ?>
&amp;busqueda=<?php echo $this->_tpl_vars['busqueda']; ?>
&amp;codigo=<?php echo $this->_tpl_vars['ultimo_cod_valor']; ?>
"><img src="../../../includes/imagenes/b_lastpage.png" alt="&Uacute;ltima" title="&Uacute;ltima" style="width:16px; height: 16px; border: 0px"/></a></td>
                    <td style="width:100%; text-align:center;">&nbsp;P&aacute;gina <?php echo $this->_tpl_vars['pagina']; ?>
 de <?php echo $this->_tpl_vars['num_paginas']; ?>
</td>
                </tr>
            </tbody>
        </table>
    </body>
</html>