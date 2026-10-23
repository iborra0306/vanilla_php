<?php
declare(strict_types=1);

// Funciones
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

function jugadaOrdenador(): string
{

    $elementos = ['piedra', 'papel', 'tijera'];
    // Selecciona un int random (indice)
    $clave = array_rand($elementos);

    return $elementos[$clave];

}

function resultado(string $jugador, string $ordenador): string
{

    switch(true) {
        case $jugador === $ordenador:
            return 'Empate';
        case $jugador === 'piedra' && $ordenador === 'tijera':
        case $jugador === 'papel' && $ordenador === 'piedra':
        case $jugador === 'tijera' && $ordenador === 'papel':
            return 'Ganaste :)';
        default:
            return 'Perdiste :(';
            break;
    }

}
// Recogida de datos

$eleccion = $_GET['opcion'] ?? '';

// Validacion
$elementos = ['piedra', 'papel', 'tijera'];

if (!in_array($eleccion, $elementos, true)) {
    $eleccion = '';
}
// Calcular puntos jugador - navegador

if ($eleccion !== '') {
    $ordenador = jugadaOrdenador();
    $result = resultado($eleccion, $ordenador);
} else {
    $ordenador = '';
    $result = '';
}

// Mostrar por pantalla


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Piedra, papel o tijera</title>
    <style>
        :root {
            --fondo: #f4efe6;
            --tinta: #1f2430;
            --acento: #e4572e;
            --tarjeta: #ffffff;
            --borde: #d9d0bf;
        }
        @media (prefers-color-scheme: dark) {
            :root {
                --fondo: #151821;
                --tinta: #ece8df;
                --acento: #ff7a52;
                --tarjeta: #1f2330;
                --borde: #343a4d;
            }
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px 16px;
            background: var(--fondo);
            color: var(--tinta);
            font-family: Georgia, "Times New Roman", serif;
        }
        main {
            width: 100%;
            max-width: 520px;
            background: var(--tarjeta);
            border: 2px solid var(--borde);
            border-radius: 18px;
            padding: 32px 24px;
            text-align: center;
        }
        h1 { margin: 0 0 4px; font-size: 1.8rem; letter-spacing: -0.02em; }
        .sub { margin: 0 0 24px; opacity: .7; }
        .jugadas { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
        .jugadas a {
            flex: 1 1 120px;
            padding: 18px 8px;
            border: 2px solid var(--tinta);
            border-radius: 14px;
            color: var(--tinta);
            text-decoration: none;
            font-size: 1.05rem;
            transition: transform .12s, background .12s, color .12s;
        }
        .jugadas a:hover, .jugadas a:focus-visible {
            background: var(--acento);
            border-color: var(--acento);
            color: #fff;
            transform: translateY(-3px);
            outline: none;
        }
        .jugadas span { display: block; font-size: 2.2rem; margin-bottom: 6px; }
        .resultado {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 2px dashed var(--borde);
        }
        .resultado .cruce { font-size: 1.1rem; margin: 0 0 8px; }
        .resultado .veredicto { font-size: 1.6rem; font-weight: bold; color: var(--acento); margin: 0; }
    </style>
</head>
<body>
    <main>
        <h1>Piedra, papel o tijera</h1>
        <p class="sub">Elige tu jugada</p>

        <!-- Jugadas: tres enlaces escritos a mano -->
        <nav class="jugadas">
            <a href="?opcion=piedra"><span>&#9994;</span>Piedra</a>
            <a href="?opcion=papel"><span>&#9995;</span>Papel</a>
            <a href="?opcion=tijera"><span>&#9996;</span>Tijera</a>
        </nav>

        <!-- Resultado de la partida: solo si hay jugada válida -->
        <!--
        <section class="resultado">
            <p class="cruce">T&uacute;: ... &middot; Ordenador: ...</p>
            <p class="veredicto">...</p>
        </section>
        -->
        <section class="resultado">
            <p class="veredicto"><?= e(resultado($eleccion, jugadaOrdenador()))?></p>
        </section>
    </main>
</body>
</html>