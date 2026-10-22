<?php
   $linea = trim(fgets(STDIN));

   $desplazamiento = ord($linea[0]) - ord('p');
   $mensaje = substr($linea, 1);
   $resultado = '';


   for($i = 0; $i < strlen($mensaje); $i++) {
       $letra = $mensaje[$i];


       if(ctype_lower($letra)) {
           $posicion = ord($letra) - ord('a');
           $posicion = ($posicion - $desplazamiento + 26) % 26; // Vuelta al alfabeto
           $resultado .= chr($posicion + ord('a'));
       } elseif(ctype_upper($letra)) {
           $posicion = ord($letra) - ord('A');
           $posicion = ($posicion - $desplazamiento + 26) % 26; // Vuelta al alfabeto
           $resultado .= chr($posicion + ord('A'));
       } else{
           $resultado .= $letra;
       }
   }
   echo $resultado;