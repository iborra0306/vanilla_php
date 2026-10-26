<?php
declare(strict_types=1);
// 0. Arranque
session_start([
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax',
]);

// 1. Funciones
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

// 2. Recoger
// (qué llega, por qué método y en qué claves)
$nombre = (trim($_POST['nombre'] ?? ''));
$email = (trim($_POST['email'] ?? ''));
$mensaje = (trim($_POST['mensaje'] ?? ''));

// 3. Validar
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (mb_strlen($nombre) < 1) {
        $errores['nombre'] = 'El nombre no puede estar vacio.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = "El email no es válido.";
    }

    if (mb_strlen($mensaje) < 10) {
        $errores['mensaje'] = 'El mensaje debe contener al menos 10 caracteres.';
    }

    // 4. Guardar y añadir a la lista
    if(count($errores) === 0) {
        $_SESSION['solicitudes'][] = [
            'nombre' => $nombre,
            'email' => $email,
            'mensaje' => $mensaje,
        ];

        $_SESSION['mensaje'] = 'Solicitud creada correctamente';

        // añadir cookie para el ultimo nombre
        setcookie('ultimo_nombre', $nombre, [
            'expires'  => time() + 60 * 60 * 24 * 30,   // 30 días
            'path'     => '/',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        header('Location: ' . $_SERVER['PHP_SELF'], true, 303);
        exit;
    }
}

$nombreCookie = $_COOKIE['ultimo_nombre'] ?? '';
if (!is_string($nombreCookie)) {
    $nombreCookie = '';
}
$nombreCookie = mb_substr(trim($nombreCookie), 0, 50);

// 5. Lo que se muestra por pantalla
$aviso = $_SESSION['mensaje'] ?? null;
unset($_SESSION['mensaje']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreCampo = $nombre;
} else {
    $nombreCampo = $nombreCookie;
}

$solicitudes = $_SESSION['solicitudes'] ?? [];

?>
<!DOCTYPE HTML>
<!--
    Identity by HTML5 UP
    html5up.net | @ajlkn
    Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html lang="es">
    <head>
        <title>Contacto</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="https://html5up.net/uploads/demos/identity/assets/css/main.css" />
        <noscript><link rel="stylesheet" href="https://html5up.net/uploads/demos/identity/assets/css/noscript.css" /></noscript>
    </head>
    <body class="is-preload">

        <!-- Wrapper -->
            <div id="wrapper">

                <!-- Formulario -->
                    <section id="main">
                        <header>
                            <h1>Contacto</h1>
                            <p>Escr&iacute;benos y te responderemos pronto</p>
                        </header>

                        <!-- Aviso general: éxito o "revisa los campos" -->
                        <?php if ($aviso !== null) : ?>
                            <p><strong><?= e($aviso) ?></strong></p>
                        <?php endif; ?>

                        <form action="" method="post">
                            <div class="fields">
                                <div class="field">
                                    <input type="text" name="nombre" placeholder="Nombre" value="<?= e($nombreCampo) ?>" />
                                    <!-- error del nombre -->
                                    <?php if (isset($errores['nombre'])) : ?>
                                        <span class="error"><?= e($errores['nombre']) ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="field">
                                    <input type="email" name="email" placeholder="Email" value="<?= e($email) ?>" />
                                    <!-- error del email -->
                                    <?php if (isset($errores['email'])) : ?>
                                        <span class="error"><?= e($errores['email']) ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="field">
                                    <textarea name="mensaje" placeholder="Mensaje" rows="4"><?= e($mensaje) ?></textarea>
                                    <!-- error del mensaje -->
                                    <?php if (isset($errores['mensaje'])) : ?>
                                        <span class="error"><?= e($errores['mensaje']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <ul class="actions">
                                <li><input type="submit" value="Enviar" /></li>
                            </ul>
                        </form>
                    </section>

                <!-- Listado de mensajes recibidos -->
                    <section id="main">
                        <header>
                            <h2>Mensajes recibidos</h2>
                            <p>Total: <?= count($solicitudes) ?></p>
                        </header>
                        
                        <!-- Si no hay mensajes: aviso. Si hay: una tabla con una fila por mensaje -->
                        <div class="table-wrapper">
                            <?php  if (count($solicitudes) === 0) : ?>
                                <p>No hay solicitudes</p>
                            <?php else: ?>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Mensaje</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- filas -->
                                        <?php foreach ($solicitudes as $s) : ?>
                                            <tr>
                                                <td><?= e($s['nombre']) ?></td>
                                                <td><?= e($s['email']) ?></td>
                                                <td><?= e($s['mensaje']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>
                    </section>

                <!-- Footer -->
                    <footer id="footer">
                        <ul class="copyright">
                            <li>&copy; Tu nombre</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
                        </ul>
                    </footer>

            </div>

        <!-- Scripts -->
            <script>
                if ('addEventListener' in window) {
                    window.addEventListener('load', function() { document.body.className = document.body.className.replace(/\bis-preload\b/, ''); });
                    document.body.className += (navigator.userAgent.match(/(MSIE|rv:11\.0)/) ? ' is-ie' : '');
                }
            </script>
    </body>
</html>