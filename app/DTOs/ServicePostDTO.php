<?php

namespace App\DTOs;

class ServicePostDTO
{
    public function __construct(
        public readonly int $userId,
        public readonly int $cargoTypeId,
        public readonly string $title,
        public readonly string $originAddress,
        public readonly string $originCity,
        public readonly ?float $originLatitude,
        public readonly ?float $originLongitude,
        public readonly string $destinationAddress,
        public readonly string $destinationCity,
        public readonly ?float $destinationLatitude,
        public readonly ?float $destinationLongitude,
        public readonly string $loadingDate,
        public readonly ?float $cargoWeight,
        public readonly ?string $description,
        public readonly string $contactPhone,
        public readonly ?string $contactEmail,
        public readonly string $status = 'active',
        public readonly bool $isPublished = true,
        public readonly array $images = [],
    ) {}

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'cargo_type_id' => $this->cargoTypeId,
            'title' => $this->title,
            'origin_address' => $this->originAddress,
            'origin_city' => $this->originCity,
            'origin_latitude' => $this->originLatitude,
            'origin_longitude' => $this->originLongitude,
            'destination_address' => $this->destinationAddress,
            'destination_city' => $this->destinationCity,
            'destination_latitude' => $this->destinationLatitude,
            'destination_longitude' => $this->destinationLongitude,
            'loading_date' => $this->loadingDate,
            'cargo_weight' => $this->cargoWeight,
            'description' => $this->description,
            'contact_phone' => $this->contactPhone,
            'contact_email' => $this->contactEmail,
            'status' => $this->status,
            'is_published' => $this->isPublished,
        ];
    }

    public static function fromRequest(array $data): self
    {
        return new self(
            userId: $data['user_id'],
            cargoTypeId: $data['cargo_type_id'],
            title: $data['title'],
            originAddress: $data['origin_address'],
            originCity: $data['origin_city'],
            originLatitude: $data['origin_latitude'] ?? null,
            originLongitude: $data['origin_longitude'] ?? null,
            destinationAddress: $data['destination_address'],
            destinationCity: $data['destination_city'],
            destinationLatitude: $data['destination_latitude'] ?? null,
            destinationLongitude: $data['destination_longitude'] ?? null,
            loadingDate: $data['loading_date'],
            cargoWeight: $data['cargo_weight'] ?? null,
            description: $data['description'] ?? null,
            contactPhone: $data['contact_phone'],
            contactEmail: $data['contact_email'] ?? null,
            status: $data['status'] ?? 'active',
            isPublished: $data['is_published'] ?? true,
            images: $data['images'] ?? [],
        );
    }
}
