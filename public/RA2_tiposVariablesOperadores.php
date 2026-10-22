<?php
   $codCiclo  = "DAW";     // string
   $horas     = 2000;      // int
   $notaCorte = 8.75;      // float
   $activo    = true;      // bool

   echo '<p>', $codCiclo, ' — ', $horas, ' horas — nota de corte ', $notaCorte, '</p>';

   echo '<pre>';
   var_dump($codCiclo, $horas, $notaCorte, $activo);
   echo '</pre>';
?>

<?php
  define('NOMBRE_CENTRO', 'CIFP Carlos III');   // función: válida en cualquier punto del script
  const CODIGO_CENTRO = '30012345';         // palabra clave: se resuelve al cargar el script

  echo '<p>Centro: ', NOMBRE_CENTRO, ' (código ', CODIGO_CENTRO, ')</p>';
?>

<?php
   $horasTotales  = 2000;
   $horasCursadas = 1350;
   echo '<p>Horas restantes: ', $horasTotales - $horasCursadas, '</p>';

   $codCiclo = "10";   // string
   $idCiclo  = 10;     // int

   echo '<pre>';
   var_dump($codCiclo == $idCiclo);    // ¿qué esperas? --> True
   var_dump($codCiclo === $idCiclo);   // ¿y aquí? --> False
   echo '</pre>';
 ?>