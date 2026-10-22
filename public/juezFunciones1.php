<?php
declare(strict_types=1);

/*
factoresPrimos($numero): que recibe un número entero y devuelve un array. Cada vez que encontremos un factor x que divide al
número incrementaremos el valor del elemento x del array. Por ejemplo, el array resultante de factorizar el número 24 es:

        array[2] = 3
	    array[3] = 1

*/

    function factoresPrimos(int $numero): array
    {
        foreach ($datos as $dato){
            if($numero / $dato){
                $dato++;    
            }
        }
    }

/*
    imprimeFactoresPrimos($factoresArray): que recibirá el array resultante de la función anterior y generará una cadena de caracteres
    en la que se irán concatenando los factores primos elevados a sus exponentes, como aparece en el resultado de ejemplo. Para recorrer
    el array de los factores primos puedes utilizar la instrucción

*/

    function imprimeFactoresPrimos(array $factoresArray): array
    {
        $cadena = '';

        foreach (factoresArray as $clave => $valor){
            $cadena +=
        }
    }

    while($linea = fgets(STDIN)){

        $datos = explode(" ", trim($linea));
        $x = 2;

        foreach ($datos as $dato) {
            while($dato <> 1){
                if($dato % x == 0){
                    echo $x;
                    $dato = $dato / x;
                } else {
                    $x = $x + 1;
                }
            }
        }

        /* <p><?php echo $numero ?> = <?php echo imprimeFactoresPrimos(factoresPrimos($numero)) ?></p>*/
        
    }
    