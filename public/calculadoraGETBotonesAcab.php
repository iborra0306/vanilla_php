<?php
declare(strict_types=1);
// CALCULADORA con enlaces GET: cada botón es un enlace que lleva en la URL
// el estado actual (operando1, operador, operando2) y lo que se acaba de pulsar.

// 1. Recogida de datos
$operando1 = (int) ($_GET['operando1'] ?? 0);
$operador  = $_GET['operador'] ?? '';
$operando2 = (int) ($_GET['operando2'] ?? 0);
$numero    = $_GET['numero'] ?? '';   // la cifra que se acaba de pulsar (si hay)

// 2. Funciones
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

function operaciones(string $operador, int $operando1, int $operando2): string
{
    switch ($operador) {
        case 'mas':
            return "$operando1 + $operando2 = " . ($operando1 + $operando2);
        case 'menos':
            return "$operando1 - $operando2 = " . ($operando1 - $operando2);
        case 'por':
            return "$operando1 * $operando2 = " . ($operando1 * $operando2);
        case 'entre':
            return "$operando1 / $operando2 = " . ($operando1 / $operando2);
        default:
            return 'Operacion no permitida';
    }
}

// 3. Actualizar estado
// Si se ha pulsado una cifra, se pega al final del número que se está escribiendo.
if ($numero !== '') {
    if ($operador === '') { // Concatenamos en 
        $operando1 = (int) ($operando1 . (int) $numero);
    } else {
        $operando2 = (int) ($operando2 . (int) $numero);
    }
}

// Cuando se pulsa = se realiza el calculo.
if (isset($_GET['igual'])) {
    $resultado = operaciones($operador, $operando1, $operando2);
} else {
    $resultado = '';
}

// Lo que se muestra en pantalla
if ($resultado !== '') {
    $pantalla = $resultado;
} elseif ($operador === '') {
    $pantalla = (string) $operando1;
} else {
    $pantalla = (string) $operando2;
}

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
                            <span class="avatar"><img src="https://es.calcuworld.com/wp-content/uploads/sites/2/2013/02/matematicas-150x150.png" alt="" /></span>
                            <h2>Calculadora B&aacute;sica</h2>

                            <input type="text" name="ans" value="<?= e($pantalla) ?>" readonly>
                            <br>
                            <a href="?operando1=<?= $operando1 ?>&operador=<?= e($operador) ?>&operando2=<?= $operando2 ?>&numero=1" class="button">1</a>
                            <a href="?operando1=<?= $operando1 ?>&operador=<?= e($operador) ?>&operando2=<?= $operando2 ?>&numero=2" class="button">2</a>
                            <a href="?operando1=<?= $operando1 ?>&operador=<?= e($operador) ?>&operando2=<?= $operando2 ?>&numero=3" class="button">3</a>
                            <a href="?operando1=<?= $operando1 ?>&operador=mas" class="button">+</a>
                            <br>
                            <a href="?operando1=<?= $operando1 ?>&operador=<?= e($operador) ?>&operando2=<?= $operando2 ?>&numero=4" class="button">4</a>
                            <a href="?operando1=<?= $operando1 ?>&operador=<?= e($operador) ?>&operando2=<?= $operando2 ?>&numero=5" class="button">5</a>
                            <a href="?operando1=<?= $operando1 ?>&operador=<?= e($operador) ?>&operando2=<?= $operando2 ?>&numero=6" class="button">6</a>
                            <a href="?operando1=<?= $operando1 ?>&operador=menos" class="button">-</a>
                            <br>
                            <a href="?operando1=<?= $operando1 ?>&operador=<?= e($operador) ?>&operando2=<?= $operando2 ?>&numero=7" class="button">7</a>
                            <a href="?operando1=<?= $operando1 ?>&operador=<?= e($operador) ?>&operando2=<?= $operando2 ?>&numero=8" class="button">8</a>
                            <a href="?operando1=<?= $operando1 ?>&operador=<?= e($operador) ?>&operando2=<?= $operando2 ?>&numero=9" class="button">9</a>
                            <a href="?operando1=<?= $operando1 ?>&operador=por" class="button">*</a>
                            <br>
                            <a href="?operando1=<?= $operando1 ?>&operador=<?= e($operador) ?>&operando2=<?= $operando2 ?>&numero=0" class="button">0</a>
                            <a href="?" class="button">c</a>
                            <a href="?operando1=<?= $operando1 ?>&operador=entre" class="button">/</a>
                            <a href="?operando1=<?= $operando1 ?>&operador=<?= e($operador) ?>&operando2=<?= $operando2 ?>&igual=1" class="button">=</a>
                        </header>
                        <footer>
                            <ul class="icons">
                            </ul>
                        </footer>
                    </section>

                <!-- Footer -->
                    <footer id="footer">
                        <ul class="copyright">
                            <li>Copyright Jane Doe</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
                        </ul>
                    </footer>
            </div>

        <!-- Scripts -->
        <!-- Curso 2024/2025 -->
            <script>
                if ('addEventListener' in window) {
                    window.addEventListener('load', function() { document.body.className = document.body.className.replace(/\bis-preload\b/, ''); });
                    document.body.className += (navigator.userAgent.match(/(MSIE|rv:11\.0)/) ? ' is-ie' : '');
                }
            </script>
    </body>
</html>