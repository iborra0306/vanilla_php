<?php
declare(strict_types=1);

// ---------- 0. ARRANQUE ----------
require_once __DIR__ . '/../../src/videoteca/comun.php';
require_once __DIR__ . '/../../src/videoteca/peliculas.php';
require_once __DIR__ . '/../../src/videoteca/Pelicula.php';

iniciarSesion();   // El catálogo es público: no se llama a exigirLogin().

// ---------- 1. RECOGER Y VALIDAR EL FILTRO (GET) ----------
$genero = $_GET['genero'] ?? '';
if (!in_array($genero, GENEROS, true)) {
    $genero = '';   // valor no válido -> sin filtro
}

// ---------- 2. COOKIE ultimo_genero ----------
// Guardar: solo si hay un género válido, para no machacarla al volver sin filtro.
if ($genero !== '') {
    setcookie('ultimo_genero', $genero, [
        'expires'  => time() + 60 * 60 * 24 * 30,   // 30 días
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
}

// Leer: lo que guardamos hoy llega en la petición SIGUIENTE.
// Se valida igual que el GET: la cookie la puede cambiar cualquiera desde F12.
$generoCookie = $_COOKIE['ultimo_genero'] ?? '';
if (!in_array($generoCookie, GENEROS, true)) {
    $generoCookie = '';
}

// 3. Datos
$peliculas = peliculas();

if ($genero !== '') {
    $peliculas = array_filter(
        $peliculas,
        fn(array $p): bool => $p['genero'] === $genero
    );
}

// Cada array pasa a ser un objeto Pelicula (las claves coinciden con el constructor).
$peliculas = array_map(fn(array $p): Pelicula => new Pelicula(...$p), $peliculas);

// 4. Calcular
$total  = count($peliculas);
$largas = count(array_filter($peliculas, fn(Pelicula $p): bool => $p->esLarga()));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo</title>
</head>
<body>
    <h1>Catálogo</h1>

    <!-- Filtro por género (GET) -->
    <form action="" method="get">
        <p>
            <label>Género
                <select name="genero">
                    <option value="">Todos</option>
                    <?php foreach (GENEROS as $g) : ?>
                        <option value="<?= e($g) ?>" <?= $genero === $g ? 'selected' : '' ?>>
                            <?= e($g) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Filtrar</button>
            </label>
        </p>
    </form>

    <!-- Enlace al último género visto (cookie), solo si no hay filtro activo -->
    <?php if ($genero === '' && $generoCookie !== '') : ?>
        <p>Último género que viste:
            <a href="?genero=<?= e($generoCookie) ?>"><?= e($generoCookie) ?></a>
        </p>
    <?php endif; ?>

    <!-- Listado -->
    <?php if ($total === 0) : ?>
        <p>No hay películas.</p>
    <?php else : ?>
        <table border="1" cellpadding="4">
            <tr>
                <th>Id</th>
                <th>Título</th>
                <th>Género</th>
                <th>Año</th>
                <th>Duración</th>
                <th>¿Es larga?</th>
            </tr>
            <?php foreach ($peliculas as $p) : ?>
                <tr>
                    <td><?= e((string) $p->id) ?></td>
                    <td><?= e($p->titulo) ?></td>
                    <td><?= e($p->genero) ?></td>
                    <td><?= e((string) $p->anio) ?></td>
                    <td><?= e($p->duracionTexto()) ?></td>
                    <td><?= e($p->esLarga() ? 'Sí' : '-') ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <p>Total películas: <?= $total ?></p>
        <p>Total películas largas: <?= $largas ?></p>
    <?php endif; ?>
</body>
</html>