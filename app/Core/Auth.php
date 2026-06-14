<?php

class Auth
{
    public static function attempt(array $user, string $password): bool
    {
        if (password_verify($password, $user['password'])) {
            self::login($user);
            return true;
        }
        return false;
    }

    public static function login(array $user): void
    {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'nombre' => $user['nombre'],
            'email' => $user['email'],
            'rol' => $user['rol'] ?? 'mozo',
        ];
    }

    public static function check(): bool
    {
        return isset($_SESSION['user']);
    }

    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function role(): ?string
    {
        return $_SESSION['user']['rol'] ?? null;
    }

    public static function logout(): void
    {
        unset($_SESSION['user']);
        session_destroy();
    }
}
