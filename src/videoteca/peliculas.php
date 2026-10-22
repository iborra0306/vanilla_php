<?php
declare(strict_types=1);
// Catálogo de películas. Las páginas lo cargan con:
//   require_once __DIR__ . '/../../src/videoteca/peliculas.php';

/**
 * Películas de la videoteca. Cada una es un array con las mismas claves
 * que los parámetros del constructor de Pelicula (duracion en minutos).
 *
 * @return array<int, array{id: int, titulo: string, genero: string, anio: int, duracion: int}>
 */
function peliculas(): array
{
    return [
        ['id' => 1, 'titulo' => 'El silencio de los corderos',    'genero' => 'thriller', 'anio' => 1991, 'duracion' => 118],
        ['id' => 2, 'titulo' => 'Casablanca',                     'genero' => 'drama',    'anio' => 1942, 'duracion' => 102],
        ['id' => 3, 'titulo' => 'Mad Max: Furia en la carretera', 'genero' => 'accion',   'anio' => 2015, 'duracion' => 120],
        ['id' => 4, 'titulo' => 'El padrino',                     'genero' => 'drama',    'anio' => 1972, 'duracion' => 175],
        ['id' => 5, 'titulo' => 'Aterriza como puedas',           'genero' => 'comedia',  'anio' => 1980, 'duracion' => 87],
        ['id' => 6, 'titulo' => 'Apocalypse Now',                 'genero' => 'belica',   'anio' => 1979, 'duracion' => 147],
        ['id' => 7, 'titulo' => 'La ventana indiscreta',          'genero' => 'suspense', 'anio' => 1954, 'duracion' => 112],
        ['id' => 8, 'titulo' => 'El resplandor',                  'genero' => 'terror',   'anio' => 1980, 'duracion' => 147],
    ];
}