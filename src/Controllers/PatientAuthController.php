<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Patient;
use App\Models\User;
use App\Utils\Auth;

class PatientAuthController
{
    private Patient $patientModel;
    private User $userModel;

    public function __construct()
    {
        $db = \App\Utils\Database::getInstance();
        $this->patientModel = new Patient($db);
        $this->userModel = new User($db);
    }

    public function showLogin(): void
    {
        // Rediriger si déjà connecté en tant que patient
        if (Auth::check() && !Auth::isAdmin()) {
            redirect('/account');
        }
        
        // Si admin connecté, ne pas rediriger automatiquement
        include __DIR__ . '/../../templates/front/login.php';
    }

    public function login(): void
    {
        if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Token de sécurité invalide';
            redirect('/login');
            return;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Vérifier les identifiants via le modèle User
        $user = $this->userModel->verifyCredentials($email, $password);

        if (!$user) {
            $_SESSION['error'] = 'Email ou mot de passe incorrect';
            redirect('/login');
            return;
        }

        // Ne permettre que les patients (pas les admins ni staff)
        if ($user['role'] !== 'patient') {
            $_SESSION['error'] = 'Veuillez utiliser l\'espace administrateur';
            redirect('/login');
            return;
        }

        // Connexion réussie
        Auth::login($user);
        redirect('/account');
    }

    public function showRegister(): void
    {
        // Rediriger si déjà connecté
        if (Auth::check()) {
            redirect('/account');
        }
        
        include __DIR__ . '/../../templates/front/register.php';
    }

    public function register(): void
    {
        if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Token de sécurité invalide';
            redirect('/register');
            return;
        }

        $data = [
            'first_name' => $_POST['first_name'] ?? '',
            'last_name' => $_POST['last_name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'date_of_birth' => $_POST['date_of_birth'] ?? '',
            'gender' => $_POST['gender'] ?? '',
            'address' => $_POST['address'] ?? '',
            'password' => $_POST['password'] ?? '',
            'password_confirm' => $_POST['password_confirm'] ?? '',
        ];

        // Validation
        $errors = [];

        if (empty($data['first_name']) || empty($data['last_name'])) {
            $errors[] = 'Le nom et le prénom sont requis';
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email invalide';
        }

        if (empty($data['phone'])) {
            $errors[] = 'Le téléphone est requis';
        }

        if (empty($data['date_of_birth'])) {
            $errors[] = 'La date de naissance est requise';
        }

        if (strlen($data['password']) < 8) {
            $errors[] = 'Le mot de passe doit contenir au moins 8 caractères';
        }

        if ($data['password'] !== $data['password_confirm']) {
            $errors[] = 'Les mots de passe ne correspondent pas';
        }

        // Vérifier si l'email existe déjà
        if ($this->patientModel->findByEmail($data['email'])) {
            $errors[] = 'Cet email est déjà utilisé';
        }

        if (!empty($errors)) {
            $_SESSION['error'] = implode(', ', $errors);
            redirect('/register');
            return;
        }

        // Créer le patient
        $patientId = $this->patientModel->create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'date_of_birth' => $data['date_of_birth'],
            'gender' => $data['gender'],
            'address' => $data['address'],
        ]);

        if (!$patientId) {
            $_SESSION['error'] = 'Erreur lors de la création du compte';
            redirect('/register');
            return;
        }

        // Créer l'utilisateur associé
        $userId = $this->userModel->create([
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'name' => $data['first_name'] . ' ' . $data['last_name'],
            'role' => 'patient',
        ]);

        if (!$userId) {
            // Supprimer le patient si la création de l'utilisateur échoue
            $this->patientModel->delete($patientId);
            $_SESSION['error'] = 'Erreur lors de la création du compte';
            redirect('/register');
            return;
        }

        $_SESSION['success'] = 'Compte créé avec succès ! Vous pouvez maintenant vous connecter.';
        redirect('/login');
    }

    public function showAccount(): void
    {
        // Vérifier que l'utilisateur est connecté et n'est pas admin
        if (!Auth::check() || Auth::isAdmin()) {
            redirect('/login');
        }
        
        include __DIR__ . '/../../templates/front/account.php';
    }

    public function logout(): void
    {
        Auth::logout();
        redirect('/');
    }
}
