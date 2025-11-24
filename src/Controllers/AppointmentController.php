<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Service;
use App\Utils\Database;

class AppointmentController
{
    private Appointment $appointmentModel;
    private Patient $patientModel;
    private Service $serviceModel;

    public function __construct()
    {
        $db = Database::getInstance();
        $this->appointmentModel = new Appointment($db);
        $this->patientModel = new Patient($db);
        $this->serviceModel = new Service($db);
    }

    public function book(): void
    {
        $services = $this->serviceModel->findActive();
        $errors = [];
        $success = false;
        
        // Pré-remplir les informations si le patient est connecté
        $patientInfo = null;
        if (\App\Utils\Auth::check() && !\App\Utils\Auth::isAdmin()) {
            $user = \App\Utils\Auth::user();
            $patientInfo = $this->patientModel->findByEmail($user['email']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
                $errors[] = 'Token de sécurité invalide';
            } else {
                $errors = $this->validateBookingForm($_POST);

                if (empty($errors)) {
                    // Vérifier ou créer le patient
                    $patient = $this->patientModel->findByEmail($_POST['email']);
                    
                    if (!$patient) {
                        $patientId = $this->patientModel->create([
                            'first_name' => $_POST['first_name'],
                            'last_name' => $_POST['last_name'],
                            'email' => $_POST['email'],
                            'phone' => $_POST['phone'],
                        ]);
                    } else {
                        $patientId = $patient['id'];
                    }

                    // Créer le rendez-vous
                    try {
                        $appointmentId = $this->appointmentModel->create([
                            'patient_id' => $patientId,
                            'service_id' => $_POST['service_id'],
                            'appointment_date' => $_POST['appointment_date'],
                            'appointment_time' => $_POST['appointment_time'],
                            'notes' => $_POST['notes'] ?? '',
                        ]);
                        
                        $success = true;
                        $_POST = []; // Réinitialiser le formulaire
                    } catch (\Exception $e) {
                        $errors[] = 'Erreur lors de la prise de rendez-vous';
                    }
                }
            }
        }

        require TEMPLATE_PATH . '/front/booking.php';
    }

    public function getAvailableSlots(): void
    {
        header('Content-Type: application/json');
        
        $date = $_GET['date'] ?? '';
        $serviceId = (int) ($_GET['service_id'] ?? 0);
        
        if (empty($date) || $serviceId === 0) {
            echo json_encode(['error' => 'Paramètres manquants']);
            return;
        }
        
        $slots = $this->appointmentModel->getAvailableSlots($date, $serviceId);
        echo json_encode(['slots' => $slots]);
    }

    private function validateBookingForm(array $data): array
    {
        $errors = [];

        if (empty($data['first_name']) || strlen($data['first_name']) < 2) {
            $errors[] = 'Le prénom est requis';
        }

        if (empty($data['last_name']) || strlen($data['last_name']) < 2) {
            $errors[] = 'Le nom est requis';
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email invalide';
        }

        if (empty($data['phone']) || !preg_match('/^[0-9\s\-\+\(\)]{10,}$/', $data['phone'])) {
            $errors[] = 'Numéro de téléphone invalide';
        }

        if (empty($data['service_id']) || !is_numeric($data['service_id'])) {
            $errors[] = 'Veuillez sélectionner un service';
        }

        if (empty($data['appointment_date'])) {
            $errors[] = 'Veuillez sélectionner une date';
        } elseif (strtotime($data['appointment_date']) < strtotime('today')) {
            $errors[] = 'La date doit être dans le futur';
        }

        if (empty($data['appointment_time'])) {
            $errors[] = 'Veuillez sélectionner une heure';
        }

        // Vérifier la disponibilité du créneau
        if (empty($errors)) {
            if (!$this->appointmentModel->isTimeSlotAvailable($data['appointment_date'], $data['appointment_time'])) {
                $errors[] = 'Ce créneau n\'est plus disponible';
            }
        }

        return $errors;
    }
}
