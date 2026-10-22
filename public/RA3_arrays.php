<?php
  $ciclos = ['DAW', 'DAM'];
  $ciclos[] = 'ASIR';

  echo '<p>Número de ciclos: ', count($ciclos), '</p>';
  echo '<p>', in_array('SMR', $ciclos, true) ? 'SMR ofertado' : 'SMR no ofertado', '</p>';
?>

<?php
  $ciclo = [
    'codCiclo' => 'DAW',
    'nombre'   => 'Desarrollo de Aplicaciones Web',
    'modulos'  => [
      '0612' => 'Desarrollo web en entorno cliente',
      '0613' => 'Desarrollo web en entorno servidor',
      '0614' => 'Despliegue de aplicaciones web',
      '0615' => 'Diseño de interfaces web',
    ],
  ];

  echo $ciclo['modulos']['0613'];   // Desarrollo web en entorno servidor

  echo '<ul>';
  foreach ($ciclo['modulos'] as $codigo => $nombre) {
    echo '<li class="modulo">', $codigo, ' — ', $nombre, '</li>';
  }
  echo '</ul>';
?>

<?php
  $curriculos = [
    ['alumno' => 'Ana López',    'ciclo' => 'DAW',  'video' => 'https://youtu.be/curriculo1'],
    ['alumno' => 'Marcos Pérez', 'ciclo' => 'DAM',  'video' => 'https://youtu.be/curriculo2'],
    ['alumno' => 'Laura García', 'ciclo' => 'ASIR', 'video' => 'https://youtu.be/curriculo3'],
  ];

  $alumnos = array_column($curriculos, 'alumno');
   sort($alumnos);
   echo '<p>Alumnos: ', implode(', ', $alumnos), '</p>';
?>

<?php
  [$primero, $segundo] = ['DAW', 'DAM', 'ASIR'];
  echo $primero;   // DAW
?>

<?php
  $copia = $curriculos;
  $copia[] = ['alumno' => 'Marcos Pérez', 'ciclo' => 'DAW', 'video' => ''];

  echo count($curriculos);   // 3: el original no ha cambiado
  echo count($copia);        // 4

  echo '<p>Original: ', count($curriculos), ' · Copia: ', count($copia), '</p>';

?>
