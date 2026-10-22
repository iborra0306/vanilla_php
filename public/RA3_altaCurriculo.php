<?php
declare(strict_types=1);

 require_once __DIR__ . '/../src/RA3_formularios.php';
 require_once __DIR__ . '/../src/ValidadorCurriculo.php';

 const NOMBRE_CENTRO = 'CIFP Carlos III';

 // Catálogo de ciclos del centro. En el Bloque 6 saldrá de la base de datos.
 $ciclos = [
     'DAW'  => new Ciclo(1, 'DAW', 'Desarrollo de Aplicaciones Web', Ciclo::GRADO_SUPERIOR),
     'DAM'  => new Ciclo(2, 'DAM', 'Desarrollo de Aplicaciones Multiplataforma', Ciclo::GRADO_SUPERIOR),
     'ASIR' => new Ciclo(3, 'ASIR', 'Administración de Sistemas Informáticos en Red', Ciclo::GRADO_SUPERIOR),
     'SMR'  => new Ciclo(4, 'SMR', 'Sistemas Microinformáticos y Redes', Ciclo::GRADO_MEDIO),
 ];

 $validador = new ValidadorCurriculo($ciclos);
 $datos     = [];
 $errores   = [];
 $curriculo = null;

 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $datos   = $_POST;
     $errores = $validador->validar($datos);

     if ($errores === []) {
         // Sin base de datos no hay quien asigne el id: usamos 1 (Bloque 6).
         $curriculo = $validador->crearCurriculo($datos, 1);
     }
 }
 ?>
 <!DOCTYPE html>
 <html lang="es">
 <head>
   <meta charset="UTF-8">
   <title>Alta de currículo — <?= NOMBRE_CENTRO ?></title>
 </head>
 <body>
   <h1><?= NOMBRE_CENTRO ?> — Alta de currículo</h1>

   <?php if ($curriculo !== null): ?>
     <section class="resultado">
       <h2>Currículo validado</h2>
       <p class="exito"><?= e($curriculo->descripcion()) ?></p>
       <p>Ciclo: <?= e($curriculo->ciclo->nombre) ?> — titulación de <?= e($curriculo->ciclo->titulacion()) ?></p>
       <p>Vídeo:
         <?php if ($curriculo->videoCurriculum !== null): ?>
           <a href="<?= e($curriculo->videoCurriculum) ?>">ver vídeo</a>
         <?php else: ?>
           sin vídeo
         <?php endif; ?>
       </p>
       <p><a href="RA3_altaCurriculo.php">Dar de alta otro currículo</a></p>
     </section>
   <?php else: ?>
     <?php if ($errores !== []): ?>
       <ul class="errores">
         <?php foreach ($errores as $error): ?>
           <li><?= e($error) ?></li>
         <?php endforeach; ?>
       </ul>
     <?php endif; ?>

     <form action="RA3_altaCurriculo.php" method="post">
       <p>
         <label>Alumno
           <input name="alumno" value="<?= e($datos['alumno'] ?? '') ?>">
         </label>
       </p>
       <p>
         <label>Ciclo
           <select name="ciclo">
             <option value="">— Elige un ciclo —</option>
             <?php foreach ($ciclos as $codigo => $ciclo): ?>
               <option value="<?= e($codigo) ?>" <?= ($datos['ciclo'] ?? '') === $codigo ? 'selected' : '' ?>><?= e($ciclo->descripcion()) ?></option>
             <?php endforeach; ?>
           </select>
         </label>
       </p>
       <p>
         <label>Vídeo de presentación (opcional)
           <input name="video" type="url" value="<?= e($datos['video'] ?? '') ?>">
         </label>
       </p>
       <button type="submit">Dar de alta</button>
     </form>
   <?php endif; ?>
 </body>
 </html>