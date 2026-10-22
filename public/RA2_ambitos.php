<?php
  function mostrarCiclo() {
    $nombreCiclo = "Desarrollo de Aplicaciones Web";
    echo '<p>', $nombreCiclo, '</p>';
  }

  mostrarCiclo();

  // echo $nombreCiclo;   // Warning: Undefined variable $nombreCiclo
?>

<?php
  $totalCiclosMostrados = 0;

  function registrarVisita() {
    global $totalCiclosMostrados;
    $totalCiclosMostrados++;
  }

  registrarVisita();
  registrarVisita();
  registrarVisita();

  echo '<p>Ciclos mostrados: ', $totalCiclosMostrados, '</p>';   // 3
?>

<?php
  define('NOMBRE_CENTRO', 'CIFP Carlos III');

  function pie() {
    // Sin "global": las constantes son accesibles en cualquier ámbito
    echo '<footer>', NOMBRE_CENTRO, '</footer>';
  }

  pie();
?>

<?php
  function contadorVisitas() {
    static $visitas = 0;
    $visitas++;
    echo '<p>Visita número ', $visitas, '</p>';
  }
 
  contadorVisitas();   // Visita número 1
  contadorVisitas();   // Visita número 2
  contadorVisitas();   // Visita número 3

  // El valor siempre se vuevle a incrementar en 1 pq el valor de esa variable no se guarda cuando acaba la ejecucion del script

  // Esto no sucede con las variables globales, que estan disponibles en distintos ambitos, como $_POST y $_GET
?>