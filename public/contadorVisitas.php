<?php

function contadorVisitas(int &$numero) : int{
    return $numero++;
}

$numero = $numero ?? 0; //Si no tiene valor empieza en 0

echo "<p>Usted ha visitado " . contadorVisitas($numero). " veces esta página</p>";
