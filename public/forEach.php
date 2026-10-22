<?php
  $curriculos = [
    ['alumno' => 'Ana López',    'ciclo' => 'DAW',  'video' => 'https://youtu.be/curriculo1'],
    ['alumno' => 'Marcos Pérez', 'ciclo' => 'DAM',  'video' => 'https://youtu.be/curriculo2'],
    ['alumno' => 'Laura García', 'ciclo' => 'ASIR', 'video' => 'https://youtu.be/curriculo3'],
  ];

    //$prueba =  $curriculos.sizeof();
    //echo $prueba;
?>

<ol>
<?php foreach ($curriculos as $clave => $curriculo) : ?>    
    <li class="curriculo" value=" <?= $clave ?> ">
        <dl>
            <?php foreach ($curriculo as $campo => $valor) : ?>
                <dt> <?= $campo ?> </dt><dd><?= $valor ?></dd>
            <?php endforeach; ?>
        </dl>
    </li>
<?php endforeach; ?>
</ol>


<?php
    $linea = fgets(STDIN);
    $datos = explode(" ", trim($linea));
?>
<table border="solid 1px">
    <?php for($i = 0, $i = $datos[0], $i++):?>
    <tr>
        <?php for($i = 0, $i = $datos[1], $i++):?>
            <td></td>
        <?php endfor;?>
    </tr>
    <?php endfor;?>
</table>