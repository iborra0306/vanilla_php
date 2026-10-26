<?php
/*
Habrá 3 posibilidades:
    Si, a través del formulario se envía una URL, se debe mostrar la imagen asociada a esta URL. Además, dicha URL se debe almacenar en una cookie.
    Si no se envía ninguna URL pero existe una almacenada en una cookie, se deberá mostrar la imagen asociada a la URL almacenada en la cookie.
    Si no se ha enviado una URL ni tenemos ninguna almacenada en las cookies, se deberá mostrar la imagen por defecto
*/
session_start([
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax',
]);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

$url = $_POST['ans'] ?? '';
$ultimaUrl = $_COOKIE['ultima_url'] ?? '';
$urlDef = $_GET;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $urlDef = 'https://miro.medium.com/max/4800/1*r2fR_OBcBCSUtfLLaTX3JA.png';

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    setcookie('ultima_url', $url, [
                'expires'  => time() + 60 * 60 * 24 * 30,
                'httponly' => true,
                'samesite' => 'Lax',
    ]);

}

print_r($urlDef);

?>
<!DOCTYPE HTML>
<!--
	Identity by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
<head>
    <title>Identity by HTML5 UP</title>
    <meta charset="utf-8" />
    <meta name="Referrer" content="no-referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="https://html5up.net/uploads/demos/identity/assets/css/main.css" />
    <noscript><link rel="stylesheet" href="https://html5up.net/uploads/demos/identity/assets/css/noscript.css" /></noscript>
</head>
<body class="is-preload">

<!-- Wrapper -->
<div id="wrapper">

    <!-- Main -->
    <section id="main">
        <header>

            <?php if(isset($url)) : ?>
                <span class="avatar"><img src="<?= e($urlDef) ?>" alt="" width="256px"/></span>
            <?php else :?>
                <span class="avatar"><img src="<?= e($url ?? $ultimaUrl) ?>" alt="" width="256px"/></span>
            <?php endif; ?>

            <h2>Elecci&oacute;n de colores</h2>
            <form name="calculator" action="" method="post">
                <!-- Escribe el resultado como valor de la propiedad value -->
                <input type="textfield" name="ans" value="<?= e($url) ?>"  style="background-color:rgb(255, 255, 255)">
                <br>
                <label for="rojo">Rojo:</label>
                <input type="range" name="rojo" value="" min="0" max="255">
                <label for="verde">Verde:</label>
                <input type="range" name="verde" value="" min="0" max="255">
                <label for="azul">Azul:</label>
                <input type="range" name="azul" value="" min="0" max="255">
                <br>
                <input type="submit" value="Mostrar color">
                <input type="reset" value="Cancelar">
            </form>

        </header>

        <footer>
            <ul class="icons">
            </ul>
        </footer>
    </section>

    <!-- Footer -->
    <footer id="footer">
        <ul class="copyright">
            <li>&copy; Jane Doe</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
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
<!-- Documento HTML-->