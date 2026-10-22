<?php
    $linea = fgets(STDIN);
    $valores = explode(" ", trim($linea));

    // Si es numero apila, si es operador coje los dos ultimos numeros y realiza la operacion que indiquemos

    $resultado = '';

    $pila = [];

    // 1º bucle para recorrer el array
    for($i = 0; $i < count($valores); $i++){
        $elemento = $valores[$i];

        if(is_numeric($elemento)) {
            $pila[] = (int) $elemento; 
        } else{

            if(count($pila) < 2) {
                exit('<p>(Error) El usuario no ha introducido suficientes argumentos en la expresión.</p>');
            }

            $valorDos = array_pop($pila);
            $valorUno = array_pop($pila);

            switch($elemento) {
                case '+':
                    $resultado = $valorUno + $valorDos;
                    $pila[] = $resultado;
                    break;
                case ':':
                    $resultado = $valorUno / $valorDos;
                    $pila[] = $resultado;
                    break;
                case 'x':
                    $resultado = $valorUno * $valorDos;
                    $pila[] = $resultado;
                    break;
                case '-':
                    $resultado = $valorUno - $valorDos;
                    $pila[] = $resultado;
                    break;
            }

        }
    }

        if(count($pila) !== 1) {
            exit('<p>(Error) El usuario ha introducido demasiados elementos.</p>');
        } else {
            $resultado = 'El resultado es: ' . $pila[0];
        }

    echo '<p>' . $resultado . '</p>';
?>
