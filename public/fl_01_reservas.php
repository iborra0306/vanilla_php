<?php
// ============================================================
// repaso_reservas_01.php  -  Reservas de aulas (paso 1)
// Todo en un solo fichero. Traduce UN comentario cada vez,
// ejecuta, y lee el error antes de seguir.
// ============================================================
// 0. Arranque
declare(strict_types=1);
session_start();
// 1. Funciones
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

// funcion para validar fecha
function validarFecha(string $f): bool
{
    $d = DateTime::createFromFormat('Y-m-d', $f);
    return $d && $d->format('Y-m-d') === $f && $d >= new DateTime('today');
}

// 2. Datos Fijos
$aulas = ['A1', 'A2', 'Lab', 'Salón de actos'];
const FRANJAS = ['mañana', 'tarde'];

// 3. Estado
$errores = []; 
$datos = ['nombre'=>'', 'aula'=>'', 'fecha'=>'', 'franja'=>'', 'alumnos'=>''];

// 4. Recoger y validar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 4.1 Recogida de datos
    foreach ($datos as $campo => $vacio) {
        $datos[$campo] = trim($_POST[$campo] ?? '');
    }

    //4.2 Validacion
    if (mb_strlen($datos['nombre']) < 3) {
        $errores['nombre'] = 'El nombre debe tener al menos 3 caracteres.';
    }

    if (!in_array($datos['aula'], $aulas, true)) {
        $errores['aula'] = 'Elige un aula de la lista.';
    }

    if (!validarFecha($datos['fecha'])) {
        $errores['fecha'] = 'Fecha inválida o anterior a hoy.';
    }

    if (!in_array($datos['franja'], FRANJAS, true)){
        $errores['franja'] = 'Elige una franja valida.';
    }

    $alumnos = filter_var($datos['alumnos'], FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1, 'max_range' => 40],
    ]);
    if ($alumnos === false) {
        $errores['alumnos'] = 'Los alumnos deben ser un número entre 1 y 40.';
    }

    //4.3 Control de errores
    if (count($errores) === 0) {
        $_SESSION['reservas'][] = [
            'nombre' => $datos['nombre'],
            'aula' => $datos['aula'],
            'fecha' => $datos['fecha'],
            'franja' => $datos['franja'],
            'alumnos' => $alumnos,
        ];
        $_SESSION['mensaje'] = 'Reserva guardada correctamente.';

        header('Location: ' . $_SERVER['PHP_SELF'], true, 303);
        exit;
    }

}

// 5. Lo que se muestra por pantalla
$mensaje = $_SESSION['mensaje'] ?? null;
unset($_SESSION['mensaje']);

$reservas = $_SESSION['reservas'] ?? [];

// Filtro por GET (consulta -> GET): ?filtro=Lab
$filtro = $_GET['filtro'] ?? '';
if (in_array($filtro, $aulas, true)) {
    $reservas = array_filter(
        $reservas,
        fn(array $i): bool => $i['aula'] === $filtro
    );
} else {
    $filtro = ''; // Valor no valido (sin filtro)
}

$totalAlumnos = array_sum(array_column($reservas, 'alumnos'));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reservas de aulas</title>
</head>
<body>
    <h1>Reservas de aulas</h1>

    <!-- 6. Mensaje Flash -->
    <?php if ($mensaje !== null) : ?>
            <p><strong><?= e($mensaje) ?></strong></p>
    <?php endif; ?>

    <!-- 7. Formulario -->
    <form action="" method="post">
        <!-- Nombre -->
        <p>
            <label>Nombre
                <input type="text" name="nombre" value="<?= e($datos['nombre']) ?>">
            </label>
            <?php if (isset($errores['nombre'])) : ?>
                <span class="error"><?= e($errores['nombre']) ?></span>
            <?php endif; ?>
        </p>
        <!-- Aula -->
        <p>
            <label>Aula
                <select name="aula">
                    <option value="">-- elige --</option>
                    <?php foreach ($aulas as $aula) : ?>
                        <option value="<?= e($aula) ?>" <?= $datos['aula'] === $aula ? 'selected' : '' ?>>
                            <?= e($aula) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <?php if (isset($errores['aula'])) : ?>
                <span class="error"><?= e($errores['aula']) ?></span>
            <?php endif; ?>
        </p>
        <!-- Fecha -->
        <p>
            <label>Fecha
                <input type="date" name="fecha" value="<?= e($datos['fecha']) ?>">
            </label>
            <?php if (isset($errores['fecha'])) : ?>
                <span class="error"><?= e($errores['fecha']) ?></span>
            <?php endif; ?>
        </p> 
        <!-- Franja -->
        <p>Franja
            <?php foreach (FRANJAS as $f) : ?>
                <label>
                    <input type="radio" name="franja" value="<?= e($f) ?>"
                        <?= $datos['franja'] === $f ? 'checked' : ''?>>
                    <?= e($f)?>
                </label>
            <?php endforeach; ?>
            <?php if (isset($errores['franja'])) : ?>
                <span class="error"><?= e($errores['franja']) ?></span>
            <?php endif; ?>
        </p>
        <!-- Alumnos -->
        <p>
            <label>Alumnos
                <input type="text" name="alumnos" value="<?= e($datos['alumnos']) ?>">
            </label>
            <?php if (isset($errores['alumnos'])) : ?>
                <span class="error"><?= e($errores['alumnos']) ?></span>
            <?php endif; ?>
        </p>

        <button type="submit">Reservar</button>
    </form>


    <!-- 8. LISTADO (tabla) -->
    <h2>Reservas</h2>
    <form action="" method="get">
        <select name="filtro">
            <option value="">Todos</option>
            <?php foreach ($aulas as $aula) : ?>
                <option value="<?= e($aula) ?>" <?= $filtro === $aula ? 'selected' : ''?>><?= e($aula) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filtrar</button>
    </form>

    <?php if (count($reservas) === 0) : ?>
        <p>No hay reservas.</p>
    <?php else : ?>
        <table border="1" cellpadding="4">
            <tr>
                <th>Nombre</th>
                <th>Aula</th>
                <th>Fecha</th>
                <th>Franja</th>
                <th>Alumnos</th>
            </tr>
            <?php foreach ($reservas as $reserva) : ?>
                <tr>
                    <td><?= e($reserva['nombre']) ?></td>
                    <td><?= e($reserva['aula']) ?></td>
                    <td><?= e($reserva['fecha']) ?></td>
                    <td><?= e($reserva['franja']) ?></td>
                    <td><?= e((string) $reserva['alumnos']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <p>Total: <?= count($reservas) ?> reservas, suma de alumnos: <?= $totalAlumnos ?></p>
    <?php endif; ?>

</body>
</html>