<?php
    $linea = fgets(STDIN);
    $datos = explode(" ", trim($linea));
?>
<table border="solid 1px">
    <?php for($i = 0; $i <= $datos[0]; $i++):?>
    <tr>
        <?php for($i = 0; $i <= $datos[1]; $i++):?>
            <td>
                
            </td>
        <?php endfor;?>
    </tr>
    <?php endfor;?>
</table>