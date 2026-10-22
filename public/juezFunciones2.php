<?php
declare(strict_types=1);

function factoresPrimos(int $numero): array
{
    $x = 2;
    $factores = [];
    while ($numero != 1){
        if($numero % $x == 0){
            $factores[$x] = ($factores[$x] ?? 0) + 1;
            $numero = $numero / $x;
        } else{
            $x++;
        }
    }

    return $factores;
}

function imprimeFactoresPrimos(array $factores): string
{
    $trozos = [];

    foreach($factores as $clave => $valor){
        $trozos[] = $clave . " ^ " . $valor;
    }

    return implode(" * ", $trozos);
}

while ($linea = fgets(STDIN)) {
    $numero = (int) trim($linea);
?><p><?php echo $numero ?> = <?php echo imprimeFactoresPrimos(factoresPrimos($numero)) ?></p>
<?php
}