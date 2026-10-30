<?php 
require_once __DIR__ . '/Autenticador.php';
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

 /**
  * Usuarios de la aplicación, indexados por su email.
  * La contraseña se guarda solo como hash (password_hash()).
  *
  * @return array<string, array{firstName: string, lastName: string, rol: string, password: string}>
  */
 function usuarios(): array
 {
     return [
         'ana.lopez@marcapersonalfp.test' => [
             'firstName' => 'Ana',
             'lastName'  => 'López',
             'rol'       => 'alumno',
             'password'  => '$2y$12$P9SK/RrdeeBL4N12JEPaduixQ5FbBFqcvOfPM0Qbm9aQMb6q8hxMS',
         ],
         'elena.ruiz@marcapersonalfp.test' => [
             'firstName' => 'Elena',
             'lastName'  => 'Ruiz',
             'rol'       => 'docente',
             'password'  => '$2y$12$DB24CRRpRtixPHHu9JGii.Nq.Pzm7Sdgjwck8AGyolvx9nXnKWXLe',
         ],
     ];
 }

 /** Abre (o retoma) la sesión con la cookie protegida, como en 4.1. */
 function iniciarSesion(): void
 {
     session_start([
         'cookie_httponly' => true,
         'cookie_samesite' => 'Lax',
     ]);
 }

 /** @return array{email: string, firstName: string, lastName: string, rol: string}|null */
 function usuarioActual(): ?array
 {
     return $_SESSION['usuario'] ?? null;
 }

 /**
  * Devuelve el usuario de la sesión o, si no hay ninguno, redirige al login y termina.
  *
  * @return array{email: string, firstName: string, lastName: string, rol: string}
  */
 function exigirLogin(): array
 {
     $usuario = usuarioActual();
     if ($usuario === null) {
         header('Location: RA4_login.php');
         exit;
     }

     return $usuario;
 }