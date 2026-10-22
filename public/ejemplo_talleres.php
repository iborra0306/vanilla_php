<?php
declare(strict_types=1);

// ============================================================
// ejemplo_talleres.php  -  Inscripciones a talleres (EJEMPLO RESUELTO)
// Misma estructura que repaso_reservas_01.php: úsalo como plantilla.
// ============================================================

// ---------- 0. ARRANQUE ----------
// La sesión se inicia ANTES de cualquier salida (HTML incluido).
session_start();

// ---------- 1. FUNCIÓN e() ----------
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

// ---------- 2. DATOS FIJOS ----------
const TALLERES = ['Robótica', 'Fotografía', 'Cocina', 'Teatro'];
const NIVELES  = ['básico', 'avanzado'];

// ---------- 3. ESTADO INICIAL ----------
// Primera carga: formulario vacío y sin errores.
$errores = [];
$datos   = ['nombre' => '', 'email' => '', 'taller' => '', 'nivel' => '', 'edad' => ''];

// ---------- 4. ¿HA LLEGADO EL FORMULARIO? ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 4.1 Recoger (siempre con ?? y trim: el campo puede no existir)
    foreach ($datos as $campo => $vacio) {
        $datos[$campo] = trim($_POST[$campo] ?? '');
    }

    // 4.2 Validar: cada fallo va a $errores['campo']
    if (mb_strlen($datos['nombre']) < 3) {
        $errores['nombre'] = 'El nombre debe tener al menos 3 caracteres.';
    }

    if (filter_var($datos['email'], FILTER_VALIDATE_EMAIL) === false) {
        $errores['email'] = 'El email no es válido.';
    }

    // in_array con true: comparación estricta (===)
    if (!in_array($datos['taller'], TALLERES, true)) {
        $errores['taller'] = 'Elige un taller de la lista.';
    }

    if (!in_array($datos['nivel'], NIVELES, true)) {
        $errores['nivel'] = 'Elige un nivel.';
    }

    // filter_var devuelve el entero o false. Ojo: compara con === false
    $edad = filter_var($datos['edad'], FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 12, 'max_range' => 99],
    ]);
    if ($edad === false) {
        $errores['edad'] = 'La edad debe ser un número entre 12 y 99.';
    }

    // 4.3 ¿Hay errores?
    if (count($errores) === 0) {
        // Guardamos el registro ya validado (edad convertida a int)
        $_SESSION['inscripciones'][] = [
            'nombre' => $datos['nombre'],
            'email'  => $datos['email'],
            'taller' => $datos['taller'],
            'nivel'  => $datos['nivel'],
            'edad'   => $edad,
        ];
        $_SESSION['mensaje'] = 'Inscripción guardada correctamente.';

        // PRG: nueva petición GET para que F5 no reenvíe el formulario
        header('Location: ' . $_SERVER['PHP_SELF'], true, 303);
        exit;
    }
    // Si hay errores NO redirigimos: se vuelve a pintar el formulario
    // con $datos (lo escrito) y $errores (los avisos).
}

// ---------- 5. PREPARAR LO QUE SE VA A PINTAR ----------
// Mensaje flash: se lee y se borra para que salga una sola vez.
$mensaje = $_SESSION['mensaje'] ?? null;
unset($_SESSION['mensaje']);

$inscripciones = $_SESSION['inscripciones'] ?? [];

// Filtro por GET (consulta -> GET): ?filtro=Teatro
$filtro = $_GET['filtro'] ?? '';
if (in_array($filtro, TALLERES, true)) {
    $inscripciones = array_filter(
        $inscripciones,
        fn(array $i): bool => $i['taller'] === $filtro
    );
} else {
    $filtro = '';   // valor no válido -> sin filtro
}

$totalEdades = array_sum(array_column($inscripciones, 'edad'));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Talleres</title>
    <style>.error { color: #b00020; }</style>
</head>
<body>
    <h1>Inscripciones a talleres</h1>

    <!-- 6. MENSAJE FLASH -->
    <?php if ($mensaje !== null) : ?>
        <p><strong><?= e($mensaje) ?></strong></p>
    <?php endif; ?>

    <!-- 7. FORMULARIO: action vacío = se envía a sí mismo -->
    <form action="" method="post">
        <p>
            <label>Nombre
                <input type="text" name="nombre" value="<?= e($datos['nombre']) ?>">
            </label>
            <?php if (isset($errores['nombre'])) : ?>
                <span class="error"><?= e($errores['nombre']) ?></span>
            <?php endif; ?>
        </p>

        <p>
            <label>Email
                <input type="text" name="email" value="<?= e($datos['email']) ?>">
            </label>
            <?php if (isset($errores['email'])) : ?>
                <span class="error"><?= e($errores['email']) ?></span>
            <?php endif; ?>
        </p>

        <p>
            <label>Taller
                <select name="taller">
                    <option value="">-- elige --</option>
                    <?php foreach (TALLERES as $t) : ?>
                        <option value="<?= e($t) ?>" <?= $datos['taller'] === $t ? 'selected' : '' ?>>
                            <?= e($t) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <?php if (isset($errores['taller'])) : ?>
                <span class="error"><?= e($errores['taller']) ?></span>
            <?php endif; ?>
        </p>

        <p>Nivel:
            <?php foreach (NIVELES as $n) : ?>
                <label>
                    <input type="radio" name="nivel" value="<?= e($n) ?>"
                        <?= $datos['nivel'] === $n ? 'checked' : '' ?>>
                    <?= e($n) ?>
                </label>
            <?php endforeach; ?>
            <?php if (isset($errores['nivel'])) : ?>
                <span class="error"><?= e($errores['nivel']) ?></span>
            <?php endif; ?>
        </p>

        <p>
            <label>Edad
                <input type="text" name="edad" value="<?= e($datos['edad']) ?>">
            </label>
            <?php if (isset($errores['edad'])) : ?>
                <span class="error"><?= e($errores['edad']) ?></span>
            <?php endif; ?>
        </p>

        <button type="submit">Inscribirme</button>
    </form>

    <!-- 8. LISTADO con filtro GET (un formulario GET, otro método, otra superglobal) -->
    <h2>Inscritos</h2>
    <form action="" method="get">
        <select name="filtro">
            <option value="">Todos</option>
            <?php foreach (TALLERES as $t) : ?>
                <option value="<?= e($t) ?>" <?= $filtro === $t ? 'selected' : '' ?>><?= e($t) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filtrar</button>
    </form>

    <?php if (count($inscripciones) === 0) : ?>
        <p>No hay inscripciones.</p>
    <?php else : ?>
        <table border="1" cellpadding="4">
            <tr><th>Nombre</th><th>Email</th><th>Taller</th><th>Nivel</th><th>Edad</th></tr>
            <?php foreach ($inscripciones as $i) : ?>
                <tr>
                    <td><?= e($i['nombre']) ?></td>
                    <td><?= e($i['email']) ?></td>
                    <td><?= e($i['taller']) ?></td>
                    <td><?= e($i['nivel']) ?></td>
                    <td><?= e((string) $i['edad']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <p>Total: <?= count($inscripciones) ?> inscripciones, suma de edades: <?= $totalEdades ?></p>
    <?php endif; ?>
</body>
</html>