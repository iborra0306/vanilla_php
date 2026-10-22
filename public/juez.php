<?php
	$linea = fgets(STDIN);
	$datos = explode(" ", trim($linea));
	
	//$suma = 0;
    $resultado = 0;
	while ($datos === 0 ) {
        foreach ($datos as $dato) {
            $resultado = $resultado + $dato;
            echo $resultado;
        }
        /*for ($i = 0; $i <= sizeof($datos); $i++) {
            echo $datos;
        }*/
        break;
    }

  echo '<p>Se han sumado ', sizeof($datos) , ' números, dando como resultado un total de ', $resultado, '</p>';
?>