<?php
declare(strict_types=1);

 // Comentario de una línea: no llega al navegador
 # También de una línea, estilo consola
 /*
  * Comentario de varias líneas: tampoco llega al navegador.
  * Nota interna: revisar el texto de bienvenida.
  */
 $titulo = 'Currículos del CIFP Carlos III';
?>
<!-- Comentario HTML: este sí llega al navegador -->
<h1><?= $titulo ?></h1>