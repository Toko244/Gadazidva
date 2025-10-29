<?php

namespace App\DTOs;

class HelperPostDTO
{
    public function __construct(
        public readonly int $driverId,
        public readonly string $title,
        public readonly string $description,
        public readonly string $locationAddress,
        public readonly string $locationCity,
        public readonly ?float $locationLatitude,
        public readonly ?float $locationLongitude,
        public readonly string $requiredDate,
        public readonly ?int $durationHours,
        public readonly int $helpersNeeded,
        public readonly ?float $offeredRate,
        public readonly string $contactPhone,
        public readonly ?string $requirements,
        public readonly string $status = 'active',
        public readonly bool $isPublished = true,
    ) {}

    public function toArray(): array
    {
        return [
            'driver_id' => $this->driverId,
            'title' => $this->title,
            'description' => $this->description,
            'location_address' => $this->locationAddress,
            'location_city' => $this->locationCity,
            'location_latitude' => $this->locationLatitude,
            'location_longitude' => $this->locationLongitude,
            'required_date' => $this->requiredDate,
            'duration_hours' => $this->durationHours,
            'helpers_needed' => $this->helpersNeeded,
            'offered_rate' => $this->offeredRate,
            'contact_phone' => $this->contactPhone,
            'requirements' => $this->requirements,
            'status' => $this->status,
            'is_published' => $this->isPublished,
        ];
    }

    public static function fromRequest(array $data): self
    {
        return new self(
            driverId: $data['driver_id'],
            title: $data['title'],
            description: $data['description'],
            locationAddress: $data['location_address'],
            locationCity: $data['location_city'],
            locationLatitude: $data['location_latitude'] ?? null,
            locationLongitude: $data['location_longitude'] ?? null,
            requiredDate: $data['required_date'],
            durationHours: $data['duration_hours'] ?? null,
            helpersNeeded: $data['helpers_needed'] ?? 1,
            offeredRate: $data['offered_rate'] ?? null,
            contactPhone: $data['contact_phone'],
            requirements: $data['requirements'] ?? null,
            status: $data['status'] ?? 'active',
            isPublished: $data['is_published'] ?? true,
        );
    }
}
