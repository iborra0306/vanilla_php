<?php
declare(strict_types=1);

/**
 * Una película del catálogo de la videoteca.
 */
class Pelicula
{
    /** Minutos a partir de los cuales una película se considera larga. */
    public const DURACION_LARGA = 150;

    public int $id;
    public string $titulo;
    public string $genero;
    public int $anio;
    /** Duración en minutos. */
    public int $duracion;

    public function __construct(int $id, string $titulo, string $genero, int $anio, int $duracion)
    {
        $this->id       = $id;
        $this->titulo   = $titulo;
        $this->genero   = $genero;
        $this->anio     = $anio;
        $this->duracion = $duracion;
    }

    /** ¿Dura DURACION_LARGA minutos o más? */
    public function esLarga(): bool
    {
        return $this->duracion >= self::DURACION_LARGA;
    }

    /** La duración como texto, por ejemplo "2 h 15 min" (o "1 h" si no sobran minutos). */
    public function duracionTexto(): string
    {
        $horas   = intdiv($this->duracion, 60);
        $minutos = $this->duracion % 60;

        $partes = [];
        if ($horas > 0) {
            $partes[] = "$horas h";
        }
        if ($minutos > 0) {
            $partes[] = "$minutos min";
        }

        return implode(' ', $partes);
    }
}