<?php
declare(strict_types=1);

    function suma(array $datos): int
    {
        $suma = 0;
        for($i = 0; $i < count($datos); $i++) {
            $suma += $datos[$i];
        }
        return $suma;
    }

    function media(array $datos): float
    {
        $media = 0;
        return $media = suma($datos)  / count($datos);
    }

    while($linea = fgets(STDIN)){

        $datos = explode(" ", trim($linea));
        $operador = array_shift($datos);

        if(count($datos) >= 2) {
            switch ($operador) {
                case 'suma':
                    echo '<p>' . 'La suma de los números es: ' . suma($datos) . '</p>';
                    break;
                case 'media':
                    echo '<p>' . 'La media de los números es: ' . media($datos) . '</p>';
                    break;
                default:
                    echo '<p>' . '(Error) Operación no permitida' . '</p>';
                    break;
            }
        } else {
            echo '<p>' . '(Error) No dispongo de suficientes argumentos.' . '</p>';
        }
        echo "\n";
    }
    