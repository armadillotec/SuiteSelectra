<?php /* Smarty version 2.6.21, created on 2013-08-02 19:43:36
         compiled from menu.tpl */ ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title></title>
    </head>
    <body>
        <table style="width: 100%;">
            <tr>
                <td colspan="2">
                    <img src="../../../includes/imagenes/sep_menu2.png" width="200"/>
                </td>
            </tr>
            <?php $_from = $this->_tpl_vars['itemMenuPrincipal']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['matriz']):
?>
                <tr style="cursor: pointer;">
                    <td style="width:35px;">
                        <span style="float:left">
                            <img src="<?php echo $this->_tpl_vars['matriz']['img_ruta']; ?>
" style="text-align: center;"/>
                        </span>
                    </td>
                    <td style="height:40px;" class="menu">
                        <a href="?opt_menu=<?php echo $this->_tpl_vars['matriz']['cod_modulo']; ?>
"><?php echo $this->_tpl_vars['matriz']['nom_menu']; ?>
</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <img src="../../../includes/imagenes/sep_menu2.png" width="200"/>
                    </td>
                </tr>
            <?php endforeach; endif; unset($_from); ?>
        </table>
    </body>
</html>