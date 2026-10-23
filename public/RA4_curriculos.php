<?php
declare(strict_types=1);
// https://www.mclibre.org/consultar/php/

    require_once __DIR__ . '/../src/RA4_comun.php';

    session_start([
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
    ]);

    $validador = new ValidadorCurriculo(catalogoCiclos());

    // Reconstruimos cada currículo de la sesión; su id es su posición + 1.
    $curriculos = [];
    foreach ($_SESSION['curriculos'] ?? [] as $posicion => $datos) {
        $curriculos[] = $validador->crearCurriculo($datos, $posicion + 1);
    }

    // Mensaje flash: se muestra una vez y se borra de la sesión.
    $mensaje = $_SESSION['mensaje'] ?? null;
    unset($_SESSION['mensaje']);

    /*Pruébalo. Abre http://localhost/RA4_altaCurriculo.php, con las herramientas de desarrollo (F12) abiertas. En cada caso,
    anota en un comentario PHP de la página qué observas:
        Da de alta dos currículos de ciclos distintos. En la pestaña Red, busca la petición POST: ¿qué código de estado tiene y qué cabeceras
            Set-Cookie y Location lleva su respuesta? ¿Qué petición viene justo después, y con qué método?
        En el listado, pulsa F5. ¿Vuelve a aparecer el mensaje? ¿Te pregunta el navegador si quieres reenviar el formulario?
        Vuelve al alta: ¿qué ciclo aparece elegido? En Aplicación (Chrome) o Almacenamiento (Firefox) → Cookies, mira las dos cookies del sitio.
            ¿Cuál tiene fecha de caducidad y cuál es “de sesión”?
        Abre el listado en una ventana privada: ¿qué currículos ves, y por qué?
    Borra la cookie PHPSESSID desde las herramientas de desarrollo y recarga el listado. ¿Qué ha pasado con los currículos? ¿Siguen en el servidor?
    Cambia el valor de ultimo_ciclo por FP y recarga el alta. ¿Se produce algún error?
    Investiga. Además de las cookies, el navegador ofrece otro almacén en el cliente: Web Storage (localStorage y sessionStorage), que se usa desde JavaScript. Busca en la documentación de MDN en qué se diferencia de una cookie. ¿Recibe el servidor su contenido en cada petición? ¿Serviría para guardar el identificador de sesión de forma segura, teniendo en cuenta lo que has leído sobre HttpOnly? Responde en un comentario de la página.
    */
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Currículos — <?= NOMBRE_CENTRO ?></title>
    </head>
    <body>
        <h1><?= NOMBRE_CENTRO ?> — Currículos</h1>

        <?php if ($mensaje !== null): ?>
            <p class="exito"><?= e($mensaje) ?></p>
        <?php endif; ?>

        <?php if ($curriculos === []): ?>
            <p>Todavía no has dado de alta ningún currículo.</p>
        <?php else: ?>
            <ul>
            <?php foreach ($curriculos as $curriculo): ?>
                <li>
                <?= e($curriculo->id . '. ' . $curriculo->descripcion()) ?>
                <?php if ($curriculo->videoCurriculum !== null): ?>
                    — <a href="<?= e($curriculo->videoCurriculum) ?>">ver vídeo</a>
                <?php endif; ?>
                </li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <p><a href="RA4_altaCurriculo.php">Dar de alta un currículo</a></p>
    </body>
</html>