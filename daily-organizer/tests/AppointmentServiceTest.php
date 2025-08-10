<?php

namespace App\Tests;

use App\Domain\Appointment\AppointmentService;
use PHPUnit\Framework\TestCase;

class AppointmentServiceTest extends TestCase
{
    private AppointmentService $service;

    protected function setUp(): void
    {
        $this->service = new AppointmentService();
    }

    public function testCreateAppointment(): void
    {
        $appointment = $this->service->create('john@example.com', 'Dentist', 'Clinic', '2025-01-10 14:00', '2025-01-10 15:00');
        self::assertSame('2025-01-10 14:00', $appointment->getStart()->format('Y-m-d H:i'));
    }

    public function testUpdateAppointment(): void
    {
        $this->service->create('john@example.com', 'Dentist', 'Clinic', '2025-01-10 14:00', '2025-01-10 15:00');
        $this->service->updateLocation('john@example.com', 'Dentist', 'New Clinic');
        $appointment = $this->service->onDate('john@example.com', '2025-01-10')[0];
        self::assertSame('New Clinic', $appointment->getLocation());
    }

    public function testDeleteAppointment(): void
    {
        $this->service->create('john@example.com', 'Dentist', 'Clinic', '2025-01-10 14:00', '2025-01-10 15:00');
        $this->service->delete('john@example.com', 'Dentist');
        self::assertCount(0, $this->service->all('john@example.com'));
    }

    public function testViewCalendar(): void
    {
        $this->service->create('john@example.com', 'Dentist', 'Clinic', '2025-01-10 14:00', '2025-01-10 15:00');
        $appointments = $this->service->onDate('john@example.com', '2025-01-10');
        self::assertSame('Dentist', $appointments[0]->getTitle());
    }
}
