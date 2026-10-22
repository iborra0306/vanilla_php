<?php
    $nombreCiclo = "Desarrollo de Aplicaciones Web";
    $familia     = "Informática y Comunicaciones";
    $horas       = 2000;

    echo '<p>El ciclo <strong>', $nombreCiclo, '</strong> pertenece a la familia de ', $familia, ' y tiene ', $horas, ' horas.</p>';
?>

<?php
    print '<p>El ciclo <strong>' . $nombreCiclo . '</strong> pertenece a la familia de ' . $familia . ' y tiene ' . $horas . ' horas.</p>';
?>

<?php
    $resultado = print "Hola";
    //echo '</br>';
    echo $resultado;
?>