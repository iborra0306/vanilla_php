<?php
declare(strict_types=1);
// Código común de la videoteca. Cada página lo carga con:
//   require_once __DIR__ . '/../../src/videoteca/comun.php';

// ---------- Constantes ----------
const NOMBRE_CENTRO = 'CIFP Carlos III';
const GENEROS = ['comedia', 'accion', 'thriller', 'drama', 'suspense', 'belica', 'terror'];

// ---------- Salida segura ----------

/** Escapa un texto para pintarlo en HTML. Se usa en TODO lo que sale por pantalla. */
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

// ---------- Sesión ----------

/** Abre (o retoma) la sesión con la cookie protegida, como en 4.1. */
function iniciarSesion(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start([
            'cookie_httponly' => true,
            'cookie_samesite' => 'Lax',
        ]);
    }
}

// ---------- Usuarios ----------

/**
 * Usuarios de la aplicación, indexados por su email.
 * La contraseña se guarda solo como hash (password_hash()).
 *
 * @return array<string, array{firstName: string, lastName: string, rol: string, password: string}>
 */
function usuarios(): array
{
    return [
        'ana@videoteca.test' => [
            'firstName' => 'Ana',
            'lastName'  => 'López',
            'rol'       => 'socio',
            'password'  => password_hash('socio123', PASSWORD_DEFAULT),
        ],
        'marta@videoteca.test' => [
            'firstName' => 'Marta',
            'lastName'  => 'Ruiz',
            'rol'       => 'admin',
            'password'  => password_hash('admin123', PASSWORD_DEFAULT),
        ],
    ];
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
        header('Location: login.php', true, 303);
        exit;
    }

    return $usuario;
}

/**
 * Como exigirLogin(), pero además exige un rol. Si el usuario no lo tiene,
 * responde 403 (prohibido) y termina.
 *
 * @return array{email: string, firstName: string, lastName: string, rol: string}
 */
function exigirRol(string $rol): array
{
    $usuario = exigirLogin();
    if ($usuario['rol'] !== $rol) {
        http_response_code(403);
        exit('No tienes permiso para ver esta página.');
    }

    return $usuario;
}