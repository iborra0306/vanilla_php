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

    while($linea = fgets(STDIN)) {
        $datos = explode(" ", trim($linea));

        if(count($datos) < 2) {
            echo '<p>(Error) insuficientes argumentos.</p>';
            echo "\n";
            continue;
        }

        $numero = array_shift($datos);

        $mcd = factoresPrimos(+$numero);

        foreach($datos as $numero){
            $otros = factoresPrimos(+$numero);

            foreach ($mcd as $clave => $valor){
                if(!array_key_exists($clave, $otros)){
                    unset($mcd[$clave]);
                } else {
                    $mcd[$clave] = min($valor, $otros[$clave]);
                }
            }

        }

        if(empty($mcd)){
            echo '<p>El m.c.d. es 1</p>';
            echo "\n";
        } else {
            echo  '<p>El m.c.d. es ' . imprimeFactoresPrimos($mcd) . '</p>';
            echo "\n";
        }

    }