<?php
declare(strict_types=1);

    require_once __DIR__ . '/RA3_formularios.php';
    require_once __DIR__ . '/ValidadorCurriculo.php';

    const NOMBRE_CENTRO = 'CIFP Carlos III';

    /**
     * Ciclos que ofrece el centro, indexados por su código.
    * En el Bloque 6 saldrán de la base de datos.
    *
    * @return array<string, Ciclo>
    */
    function catalogoCiclos(): array
    {
        return [
            'DAW'  => new Ciclo(1, 'DAW', 'Desarrollo de Aplicaciones Web', Ciclo::GRADO_SUPERIOR),
            'DAM'  => new Ciclo(2, 'DAM', 'Desarrollo de Aplicaciones Multiplataforma', Ciclo::GRADO_SUPERIOR),
            'ASIR' => new Ciclo(3, 'ASIR', 'Administración de Sistemas Informáticos en Red', Ciclo::GRADO_SUPERIOR),
            'SMR'  => new Ciclo(4, 'SMR', 'Sistemas Microinformáticos y Redes', Ciclo::GRADO_MEDIO),
        ];
    }