<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

class Appointment extends Model
{
    protected string $table = 'appointments';

    public function create(array $data): int
    {
        return $this->insert([
            'patient_id' => (int) $data['patient_id'],
            'service_id' => (int) $data['service_id'],
            'appointment_date' => $data['appointment_date'],
            'appointment_time' => $data['appointment_time'],
            'status' => $data['status'] ?? 'pending',
            'notes' => $data['notes'] ?? null,
        ]);
    }

    public function updateAppointment(int $id, array $data): bool
    {
        return $this->update($id, [
            'appointment_date' => $data['appointment_date'],
            'appointment_time' => $data['appointment_time'],
            'service_id' => (int) $data['service_id'],
            'status' => $data['status'],
            'notes' => $data['notes'] ?? null,
        ]);
    }

    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    public function findByPatient(int $patientId): array
    {
        $stmt = $this->db->prepare(
            "SELECT a.*, s.title as service_title, s.duration 
             FROM {$this->table} a
             JOIN services s ON a.service_id = s.id
             WHERE a.patient_id = ?
             ORDER BY a.appointment_date DESC, a.appointment_time DESC"
        );
        $stmt->execute([$patientId]);
        return $stmt->fetchAll();
    }

    public function getByPatient(int $patientId): array
    {
        return $this->findByPatient($patientId);
    }

    public function findByDate(string $date): array
    {
        $stmt = $this->db->prepare(
            "SELECT a.*, p.first_name, p.last_name, p.phone, s.title as service_title, s.duration
             FROM {$this->table} a
             JOIN patients p ON a.patient_id = p.id
             JOIN services s ON a.service_id = s.id
             WHERE a.appointment_date = ?
             ORDER BY a.appointment_time"
        );
        $stmt->execute([$date]);
        return $stmt->fetchAll();
    }

    public function findUpcoming(int $limit = 10): array
    {
        $stmt = $this->db->prepare(
            "SELECT a.*, p.first_name, p.last_name, p.phone, s.title as service_title
             FROM {$this->table} a
             JOIN patients p ON a.patient_id = p.id
             JOIN services s ON a.service_id = s.id
             WHERE a.appointment_date >= CURDATE() AND a.status != 'cancelled'
             ORDER BY a.appointment_date, a.appointment_time
             LIMIT ?"
        );
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    public function isTimeSlotAvailable(string $date, string $time, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} 
                WHERE appointment_date = ? AND appointment_time = ? 
                AND status != 'cancelled'";
        
        $params = [$date, $time];
        
        if ($excludeId !== null) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchColumn() == 0;
    }

    public function getAvailableSlots(string $date, int $serviceId): array
    {
        // Récupérer la durée du service
        $stmtService = $this->db->prepare("SELECT duration FROM services WHERE id = ?");
        $stmtService->execute([$serviceId]);
        $serviceDuration = $stmtService->fetchColumn();
        
        // Récupérer les horaires du jour
        $dayOfWeek = date('l', strtotime($date));
        $dayNames = [
            'Monday' => 'Lundi',
            'Tuesday' => 'Mardi',
            'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi',
            'Friday' => 'Vendredi',
            'Saturday' => 'Samedi',
            'Sunday' => 'Dimanche'
        ];
        
        $stmtSchedule = $this->db->prepare(
            "SELECT opening_time, closing_time, is_closed FROM schedules WHERE day_of_week = ?"
        );
        $stmtSchedule->execute([$dayNames[$dayOfWeek]]);
        $schedule = $stmtSchedule->fetch();
        
        if (!$schedule || $schedule['is_closed']) {
            return [];
        }
        
        // Générer les créneaux disponibles
        $slots = [];
        $currentTime = strtotime($schedule['opening_time']);
        $closingTime = strtotime($schedule['closing_time']);
        
        while ($currentTime < $closingTime) {
            $timeSlot = date('H:i:s', $currentTime);
            
            if ($this->isTimeSlotAvailable($date, $timeSlot)) {
                $slots[] = date('H:i', $currentTime);
            }
            
            $currentTime += SLOT_DURATION * 60;
        }
        
        return $slots;
    }
}
