<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\Utils\Auth;
use App\Utils\Database;

class AuthController
{
    private User $userModel;

    public function __construct()
    {
        $db = Database::getInstance();
        $this->userModel = new User($db);
    }

    public function showLoginForm(): void
    {
        if (Auth::check()) {
            redirect('/admin/dashboard');
        }
        
        require TEMPLATE_PATH . '/admin/login.php';
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/admin/login');
        }

        $error = null;

        if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            $error = 'Token de sécurité invalide';
        } else {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->findByEmail($email);

            if ($user && $this->userModel->verifyPassword($password, $user['password'])) {
                Auth::login($user);
                redirect('/admin/dashboard');
            } else {
                $error = 'Email ou mot de passe incorrect';
            }
        }

        require TEMPLATE_PATH . '/admin/login.php';
    }

    public function logout(): void
    {
        Auth::logout();
        redirect('/admin/login');
    }
}
