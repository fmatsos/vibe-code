<?php

namespace App\Domain\Appointment;

class Appointment
{
    private string $owner;
    private string $title;
    private string $location;
    private \DateTimeImmutable $start;
    private \DateTimeImmutable $end;

    public function __construct(string $owner, string $title, string $location, \DateTimeImmutable $start, \DateTimeImmutable $end)
    {
        $this->owner = $owner;
        $this->title = $title;
        $this->location = $location;
        $this->start = $start;
        $this->end = $end;
    }

    public function getOwner(): string
    {
        return $this->owner;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    public function getStart(): \DateTimeImmutable
    {
        return $this->start;
    }

    public function getEnd(): \DateTimeImmutable
    {
        return $this->end;
    }
}
