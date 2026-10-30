<?php 
require_once __DIR__ . '/Autenticador.php';

    function e(string $texto): string
    {
        return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
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
            'prueba@example.com' => [
                'name'     => 'Gabriel',
                'message'  => 'Prueba',
                'address'  => 'Calle Baleares nº 8',
                'phone'    => '635 29 89 48',
                'password' => '$2y$12$T6ommAMmTijlHpojKlh.7.5rE4UUzwClYRGdoBA1AuX1xNOMExaLW', // 1234
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
            header('Location: index.php');
            exit;
        }

        return $usuario;
    }