<?php
declare(strict_types=1);

// 0 Arranque de la sesion
session_start();

// 1 Funcion e()
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

// funcion para validar fecha
function validarFecha(string $f): bool
{
    $d = DateTime::createFromFormat('!Y-m-d', $f);
    return $d !== false
        && $d->format('Y-m-d') === $f
        && $d <= new DateTime('today');
}

// 2 Datos Fijos
const CATEGORIAS = ['Ocio', 'Comida', 'Pagos minimos', 'Casa', 'Coche', 'Imprevistos','Otros'];
const PAGADO = ['Si', 'Parcialmente', 'No'];

// 3 Estado inicial
$errores = [];
$datos = [
    'concepto' => '',
    'categoria' => '',
    'importe' => '',
    'fecha' => '',
    'pagado' => ''
];

// 4 ¿Ha llegado el formulario?
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 4.1 Recoger datos
    foreach ($datos as $campo => $valor) {
        $datos[$campo] = trim($_POST[$campo] ?? '');
    }

    // 4.2 Validar, fallos en errores['campo']
    $largo = mb_strlen($datos['concepto']);
    if ($largo < 3 || $largo > 40) {
        $errores['concepto'] = 'Debe contener entre 3 y 40 caracteres.';
    }

    if (!in_array($datos['categoria'], CATEGORIAS, true)) {
        $errores['categoria'] = 'Selecciona una categoria de la lista.';
    }

    $importe = filter_var($datos['importe'], FILTER_VALIDATE_FLOAT, [
        'options' => ['min_range' => 0.01, 'max_range' => 10000],
    ]);
    if ($importe === false) {
        $errores['importe'] = 'El importe debe ser decimal mayor que 0 y menor o igual que 10000.';
    }

    if (!validarFecha($datos['fecha'])) {
        $errores['fecha'] = 'La fecha no es válida o es posterior a hoy.';
    }

    if ($datos['pagado'] !== '' && !in_array($datos['pagado'], PAGADO, true)) {
        $errores['pagado'] = 'Valor no válido.';
    }

    // El checkbox como es opcional no lo valido

    // 4.3 Guardar registro validado con prg
    if (count($errores) === 0) {
        $_SESSION['gastos'][] = [
            'concepto' => $datos['concepto'],
            'categoria' => $datos['categoria'],
            'importe' => $importe,
            'fecha' => $datos['fecha'],
            'pagado' => $datos['pagado'],
        ];
        $_SESSION['mensaje'] = 'Gasto guardado correctamente.';
        
        // Redireccion al enviar el form
        header('Location: ' . $_SERVER['PHP_SELF'], true, 303);
        exit;

    }
}

// 5 Flash
$mensaje = $_SESSION['mensaje'] ?? null;
unset($_SESSION['mensaje']);

$gastos = $_SESSION['gastos'] ?? [];

// Filtro por GET
// ?categoria=Casa
$filtro = $_GET['filtro'] ?? '';
if (in_array($filtro, CATEGORIAS, true)) {
    $gastos = array_filter(
        $gastos,
        fn(array $i): bool => $i['categoria'] === $filtro
    );
} else {
    $filtro = '';
}

$totalImportes = array_sum(array_column($gastos, 'importe'));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Gastos</title>
    <style>.error { color: #b00020; }</style>
</head>
<body>
    <h1>Gastos</h1>

    <!-- 6 Mensaje flash -->
    <?php if ($mensaje !== null) : ?>
        <p><strong><?= e($mensaje) ?></strong></p>
    <?php endif; ?>

    <!-- 7 Formulario -->
    <form action="" method="post">
        
        <p>
            <label>Concepto
                <input type="text" name="concepto" value="<?= e($datos['concepto']) ?>">
            </label>
            <?php if (isset($errores['concepto'])) : ?>
                <span class="error"><?= e($errores['concepto']) ?></span>
            <?php endif; ?>
        </p>

        <p>
            <label>Categoria
                <select name="categoria">
                    <option value="">-- elige una opcion--</option>
                    <?php foreach (CATEGORIAS as $c) : ?>
                        <option value="<?= e($c)?>" <?= $datos['categoria'] === $c ? 'selected' : '' ?>>
                            <?= e($c) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <?php if (isset($errores['categoria'])) : ?>
                <span class="error"><?= e($errores['categoria']) ?></span>
            <?php endif; ?>
        </p>

        <p>
            <label>Importe
                <input type="text" name="importe" value="<?= e($datos['importe']) ?>">
            </label>
            <?php if (isset($errores['importe'])) : ?>
                <span class="error"><?= e($errores['importe']) ?></span>
            <?php endif; ?>
        </p>

        <p>
            <label>Fecha
                <input type="date" name="fecha" value="<?= e($datos['fecha']) ?>">
            </label>
            <?php if (isset($errores['fecha'])) : ?>
                <span class="error"><?= e($errores['fecha']) ?></span>
            <?php endif; ?>
        </p> 

        <p>Pagado
            <?php foreach(PAGADO as $p) : ?>
                <label>
                    <input type="radio" name="pagado" value="<?= e($p) ?>"
                        <?= $datos['pagado'] === $p ? 'checked' : ''?>>
                        <?= e($p)?>
                </label>
            <?php endforeach; ?>
            <?php if (isset($errores['pagado'])) : ?>
                <span class="error"><?= e($errores['pagado']) ?></span>
            <?php endif; ?>
        </p>
            
        <button type="submit">Añadir gasto</button>
    </form>

    <!-- 8 Listado-->
    <h2>Gastos</h2>
    <form action="" method="get">
        <select name="filtro">
            <option value="">Todos</option>
            <?php foreach(CATEGORIAS as $c) : ?>
                <option value="<?= e($c) ?>" <?= $filtro === $c ? 'selected' : '' ?>><?= e($c) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filtrar</button>
    </form>

    <?php if (count($gastos) === 0)  : ?>
        <p>No hay gastos.</p>
        <?php else : ?>
            <table border="1px solid black" cellpadding="4">
                <tr>
                    <th>Concepto</th>
                    <th>Categoria</th>
                    <th>Importe</th>
                    <th>Fecha</th>
                    <th>Pagado</th>
                </tr>
                <?php foreach ($gastos as $gasto) : ?>
                    <tr>
                        <td><?= e($gasto['concepto'])?></td>
                        <td><?= e($gasto['categoria'])?></td>
                        <td><?= e((string) $gasto['importe'])?></td>
                        <td><?= e($gasto['fecha'])?></td>
                        <td><?= e($gasto['pagado'])?></td>
                    </tr>
                <?php endforeach; ?> 
            </table>
            <p>Total: <?= count($gastos) ?> gastos, total importes: <?= $totalImportes ?></p>
    <?php endif; ?>

</body>
</html>