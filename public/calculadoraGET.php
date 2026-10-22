<?php
declare(strict_types=1);

// BOTONES : Trabajar con $_POST para recibir los valores que recibamos al pulsar los botones, validar, operar y finalmente mostrar


// Asginacion de valores con $_GET
$operador = $_GET['operador'] ?? '';
$operando1 = (int) $_GET['operando1'] ?? '';
$operando2 = (int) $_GET['operando2'] ?? '';


// Funciones
function e(string $texto): string
{
    return htmlspecialchars($texto);
}

function operaciones(string $operador, int $operando1, int $operando2): string
{

    // Variables para almacenar el resultado de la operacion y concatenar la salida
    $calculo = 0;
    $resultado = '';
    
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        // Operacion
        switch ($operador) {
            case 'mas':
                $calculo = $operando1 + $operando2;
                break;
            case 'menos':
                $calculo = $operando1 - $operando2;
                break;
            case 'por':
                $calculo = $operando1 * $operando2;
                break;
            case 'entre':
                $calculo = $operando1 / $operando2;
                break;
            default:
                $calculo = 'Operacion no permitida';
                break;
        }

        // Asigancion del operador dependiendo de la operacion que realicemos
        switch ($operador) {
            case 'mas':
                $operador = '+';
                break;
            case 'menos':
                $operador = '-';
                break;
            case 'por':
                $operador = '*';
                break;
            case 'entre':
                $operador = '/';
                break;
            default:
                $calculo = 'Operacion no permitida';
                break;
        }

        // Mostramos el resultado de la operacion concatenado con la cadena que va
        $resultado = $operando1 . ' ' . $operador . ' ' . $operando2 . ' = ' . $calculo;

    }

    return $resultado;

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
                            <form name="calculator">
                            <!-- Escribe el resultado como valor de la propiedad value -->
                                <input type="textfield" name="ans" value="<?= e(operaciones($operador, $operando1, $operando2) ?? '') ?>">
                                <br>
                                <input type="button" value="1">
                                <input type="button" value="2">
                                <input type="button" value="3">
                                <input type="button" value="+">
                                <br>
                                <input type="button" value="4">
                                <input type="button" value="5">
                                <input type="button" value="6">
                                <input type="button" value="-">
                                <br>
                                <input type="button" value="7">
                                <input type="button" value="8">
                                <input type="button" value="9">
                                <input type="button" value="*">
                                <br>
                                <input type="button" value="0">
                                <input type="reset" value="c">
                                <input type="button" value="/">
                                <input type="button" value="=">
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