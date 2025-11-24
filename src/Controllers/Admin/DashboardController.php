<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Service;
use App\Models\News;
use App\Utils\Auth;
use App\Utils\Database;

class DashboardController
{
    private Appointment $appointmentModel;
    private Patient $patientModel;
    private Service $serviceModel;
    private News $newsModel;

    public function __construct()
    {
        Auth::requireAuth();
        
        $db = Database::getInstance();
        $this->appointmentModel = new Appointment($db);
        $this->patientModel = new Patient($db);
        $this->serviceModel = new Service($db);
        $this->newsModel = new News($db);
    }

    public function index(): void
    {
        $upcomingAppointments = $this->appointmentModel->findUpcoming(5);
        $todayAppointments = $this->appointmentModel->findByDate(date('Y-m-d'));
        
        require TEMPLATE_PATH . '/admin/dashboard.php';
    }

    public function appointments(): void
    {
        $appointments = $this->appointmentModel->findUpcoming(50);
        
        require TEMPLATE_PATH . '/admin/appointments.php';
    }

    public function updateAppointmentStatus(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/admin/appointments');
        }

        $id = (int) ($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? '';

        if ($id && in_array($status, ['pending', 'confirmed', 'cancelled', 'completed'])) {
            $this->appointmentModel->updateStatus($id, $status);
        }

        redirect('/admin/appointments');
    }

    public function patients(): void
    {
        $patients = $this->patientModel->findAll();
        
        require TEMPLATE_PATH . '/admin/patients.php';
    }

    public function services(): void
    {
        $services = $this->serviceModel->findAll();
        
        require TEMPLATE_PATH . '/admin/services.php';
    }

    public function createService(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/admin/services');
        }

        $imagePath = null;

        // Gestion de l'upload d'image
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            $maxSize = 2 * 1024 * 1024; // 2MB

            if (in_array($_FILES['image']['type'], $allowedTypes) && $_FILES['image']['size'] <= $maxSize) {
                $uploadDir = PUBLIC_PATH . '/assets/images/services/';
                
                // Créer le dossier s'il n'existe pas
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $filename = uniqid('service_') . '.' . $extension;
                $destination = $uploadDir . $filename;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                    $imagePath = '/DENTISTE/assets/images/services/' . $filename;
                }
            }
        }

        $this->serviceModel->create([
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'duration' => $_POST['duration'],
            'price' => $_POST['price'],
            'is_active' => isset($_POST['is_active']),
            'image' => $imagePath,
        ]);

        redirect('/admin/services');
    }

    public function news(): void
    {
        $news = $this->newsModel->findAll();
        
        require TEMPLATE_PATH . '/admin/news.php';
    }

    public function createNews(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/admin/news');
        }

        $imagePath = null;

        // Gestion de l'upload d'image
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            $maxSize = 2 * 1024 * 1024; // 2MB

            if (in_array($_FILES['image']['type'], $allowedTypes) && $_FILES['image']['size'] <= $maxSize) {
                $uploadDir = PUBLIC_PATH . '/assets/images/news/';
                
                // Créer le dossier s'il n'existe pas
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $filename = uniqid('news_') . '.' . $extension;
                $destination = $uploadDir . $filename;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                    $imagePath = '/DENTISTE/assets/images/news/' . $filename;
                }
            }
        }

        $this->newsModel->create([
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'excerpt' => $_POST['excerpt'],
            'image' => $imagePath,
            'author_id' => Auth::user()['id'],
            'is_published' => isset($_POST['is_published']),
            'published_at' => isset($_POST['is_published']) ? date('Y-m-d H:i:s') : null,
        ]);

        redirect('/admin/news');
    }
}
