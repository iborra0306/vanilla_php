<?php

  define('NOMBRE_CENTRO', 'CIFP Carlos III');

  $curriculos = [
    ['alumno' => 'Ana López',    'ciclo' => 'DAW',  'video' => 'https://youtu.be/curriculo1', 'imagen' => 'https://images.unsplash.com/photo-1484186139897-d5fc6b908812?ixid=M3w4MjcwNjd8MHwxfHNlYXJjaHwxOTB8fHBlcnNvbnxlbnwwfHx8fDE3OTA2NjgwNzF8MA&ixlib=rb-4.1.0&fit=max&q=80'],
    ['alumno' => 'Marcos Pérez', 'ciclo' => 'DAM',  'video' => 'https://youtu.be/curriculo2', 'imagen' => ''],
    ['alumno' => 'Laura García', 'ciclo' => 'ASIR', 'video' => 'https://youtu.be/curriculo3', 'imagen' => '' ],
    ['alumno' => 'Gabriel Iborra', 'ciclo' => 'DAW', 'video' => 'https://youtu.be/curriculo3', 'imagen' => ''],
  ];

  function mostrarCurriculo(array $curriculo) {
    echo  '<li>', $curriculo['alumno'], ' — ', $curriculo['ciclo'],
          ' — <a href="', $curriculo['video'], '">vídeo</a></li>';
  }

  echo '<h1>', NOMBRE_CENTRO, ' — Currículos</h1>';
  echo '<ul>';
  mostrarCurriculo($curriculos[0]);
  mostrarCurriculo($curriculos[1]);
  mostrarCurriculo($curriculos[2]);
  mostrarCurriculo($curriculos[3]);
  echo '</ul>';

  // Seria mas comodo recorrerlo con un for each porque si tuvieramos miles de CVs llamar a cada uno a mano seria una locura.

  /*

  echo '<h1>', NOMBRE_CENTRO, ' — Currículos</h1>';
  echo '<ul>';
  foreach ($curriculos as $curriculo) {
    echo '<li class="curriculo">', $curriculo['alumno'], ' — ', $curriculo['ciclo'], ' — <a href="', $curriculo['video'], '">vídeo</a></li>';
  }
  echo '</ul>';
  */

?>