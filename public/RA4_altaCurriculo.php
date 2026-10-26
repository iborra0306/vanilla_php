<?php
declare(strict_types=1);

    require_once __DIR__ . '/../src/RA4_comun.php';

    session_start([
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
    ]);

    $ciclos    = catalogoCiclos();
    $validador = new ValidadorCurriculo($ciclos);
    $datos     = [];
    $errores   = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $datos   = $_POST;
        $errores = $validador->validar($datos);

        if ($errores === []) {
            $curriculos = $_SESSION['curriculos'] ?? [];
            $curriculo  = $validador->crearCurriculo($datos, count($curriculos) + 1);

            // En la sesión guardamos los datos, no el objeto: el listado lo reconstruirá.
            $curriculos[] = [
                'alumno' => $curriculo->alumno,
                'ciclo'  => $curriculo->ciclo->codCiclo,
                'video'  => $curriculo->videoCurriculum ?? '',
            ];
            $_SESSION['curriculos'] = $curriculos;
            $_SESSION['mensaje']    = 'Currículo dado de alta: ' . $curriculo->descripcion();

            // Recordamos el ciclo elegido durante 30 días para proponerlo la próxima vez.
            setcookie('ultimo_ciclo', $curriculo->ciclo->codCiclo, [
                'expires'  => time() + 60 * 60 * 24 * 30,
                'httponly' => true,
                'samesite' => 'Lax',
            ]);

            // POST/Redirect/GET: el navegador pedirá el listado con GET.
            header('Location: RA4_curriculos.php', true, 303);
            exit;
        }
    }

    // Ciclo que aparece elegido: el que se acaba de enviar o, si no, el de la cookie.
    $cicloElegido = $datos['ciclo'] ?? $_COOKIE['ultimo_ciclo'] ?? '';

    /*
    4. Pruébalo. Abre http://localhost/RA4_altaCurriculo.php, con las herramientas de desarrollo (F12) abiertas. En cada caso,
    anota en un comentario PHP de la página qué observas:
        - Da de alta dos currículos de ciclos distintos. En la pestaña Red, busca la petición POST: ¿qué código de estado tiene y qué cabeceras
        Set-Cookie y Location lleva su respuesta? ¿Qué petición viene justo después, y con qué método?
            Da un 303
            En la setcookie nos muestra el ciclo seleccionado, con location en curriculos.php, a donde nos redirige al hacer post, por el metodo get y nos
            muestra el listado de los curriculos
        - En el listado, pulsa F5. ¿Vuelve a aparecer el mensaje? ¿Te pregunta el navegador si quieres reenviar el formulario?
            No
        - Vuelve al alta: ¿qué ciclo aparece elegido? En Aplicación (Chrome) o Almacenamiento (Firefox) → Cookies, mira las dos cookies del sitio.
        ¿Cuál tiene fecha de caducidad y cuál es “de sesión”?
            Expira la de ciclo, la de session es PHPSESSID
        - Abre el listado en una ventana privada: ¿qué currículos ves, y por qué?
            No veo ninguno, porque al meternos en una pestaña privada, iniciamos con otra sesion
        - Borra la cookie PHPSESSID desde las herramientas de desarrollo y recarga el listado. ¿Qué ha pasado con los currículos? ¿Siguen en el servidor?
        Cambia el valor de ultimo_ciclo por FP y recarga el alta. ¿Se produce algún error?
            Se han borrado los curriculos junto con la session
            No
    5. Investiga. Además de las cookies, el navegador ofrece otro almacén en el cliente: Web Storage (localStorage y sessionStorage), que se usa desde JavaScript. Busca en la documentación de MDN en qué se diferencia de una cookie. ¿Recibe el servidor su contenido en cada petición? ¿Serviría para guardar el identificador de sesión de forma segura, teniendo en cuenta lo que has leído sobre HttpOnly? Responde en un comentario de la página.
        Web storage guarda datos en el navegador, solo accesibles de JS, por lo que no envia la cookie al servidor, de esta forma no puede ser protegido
        de forma segura ya que js no usa HttpOnly
    */

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Alta de currículo — <?= NOMBRE_CENTRO ?></title>
    </head>
    <body>
        <h1><?= NOMBRE_CENTRO ?> — Alta de currículo</h1>

        <?php if ($errores !== []): ?>
            <ul class="errores">
            <?php foreach ($errores as $error): ?>
                <li><?= e($error) ?></li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form action="RA4_altaCurriculo.php" method="post">
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
                    <option value="<?= e($codigo) ?>" <?= $cicloElegido === $codigo ? 'selected' : '' ?>><?= e($ciclo->descripcion()) ?></option>
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

        <p><a href="RA4_curriculos.php">Ver los currículos dados de alta</a></p>
    </body>
</html>