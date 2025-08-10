<?php

namespace App\Domain\Appointment;

class AppointmentService
{
    /** @var array<string, array<string, Appointment>> */
    private array $appointments = [];

    public function create(string $owner, string $title, string $location, string $start, string $end): Appointment
    {
        $appointment = new Appointment($owner, $title, $location, new \DateTimeImmutable($start), new \DateTimeImmutable($end));
        $this->appointments[$owner][$title] = $appointment;
        return $appointment;
    }

    public function updateLocation(string $owner, string $title, string $location): ?Appointment
    {
        if (!isset($this->appointments[$owner][$title])) {
            return null;
        }
        $this->appointments[$owner][$title]->setLocation($location);
        return $this->appointments[$owner][$title];
    }

    public function delete(string $owner, string $title): void
    {
        unset($this->appointments[$owner][$title]);
    }

    /**
     * @return Appointment[]
     */
    public function onDate(string $owner, string $date): array
    {
        return array_values(array_filter($this->appointments[$owner] ?? [], fn (Appointment $a) => $a->getStart()->format('Y-m-d') === $date));
    }

    /**
     * @return Appointment[]
     */
    public function all(string $owner): array
    {
        return array_values($this->appointments[$owner] ?? []);
    }
}
