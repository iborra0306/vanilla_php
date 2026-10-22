<?php
    $grado = 'Superior';

  if ($grado === 'Superior') {
    echo '<p>Ciclo de Grado Superior: da acceso a la universidad.</p>';
  } elseif ($grado === 'Medio') {
    echo '<p>Ciclo de Grado Medio: da acceso a un Grado Superior.</p>';
  } else {
    echo '<p>Grado desconocido.</p>';
  }
?>

<?php
  $videoCurriculum = 'https://youtu.be/curriculo1';
  $textoCurriculum = '';

  if ($videoCurriculum !== '' && $textoCurriculum !== '') {
    echo '<p>Currículo completo</p>';
  } elseif ($videoCurriculum !== '' || $textoCurriculum !== '') {
    echo '<p>Currículo incompleto</p>';
  } else {
    echo '<p>Currículo vacío</p>';
  }
?>

<?php
  $codFamilia = 'INF';

  $familia = match ($codFamilia) {
    'INF'   => 'Informática y Comunicaciones',
    'ADG'   => 'Administración y Gestión',
    'COM'   => 'Comercio y Marketing',
    default => 'Familia desconocida',
  };

  echo '<p>Familia profesional: ', $familia, '</p>';
?>

<?php
  $grado = 'Superior';
  $titulo = $grado === 'Superior' ? 'Técnico Superior' : 'Técnico';
  echo '<p>Titulación: ', $titulo, '</p>';
?>

<?php
  $curriculo = ['alumno' => 'Ana López', 'ciclo' => 'DAW'];

  echo '<p>Vídeo: ', $curriculo['video'] ?? 'Sin vídeo de presentación', '</p>';
?>

<?php $publicado = true; ?>

<?php if ($publicado): ?>
  <p class="estado">Currículo publicado</p>
<?php else: ?>
  <p class="estado">Currículo en borrador</p>
<?php endif; ?>

// La ultima comparacion nos diria que no, y preferimos comparar tipos tambien para evitar errores en compilacion