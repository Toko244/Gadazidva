<?php

namespace App\DTOs;

class DriverProfileDTO
{
    public function __construct(
        public readonly int $userId,
        public readonly int $vehicleTypeId,
        public readonly ?string $vehicleMake,
        public readonly ?string $vehicleModel,
        public readonly ?int $vehicleYear,
        public readonly ?string $vehiclePlateNumber,
        public readonly ?string $vehicleColor,
        public readonly ?float $vehicleCapacity,
        public readonly ?string $bio,
        public readonly float $baseRatePerKm = 0.0,
        public readonly float $baseRateFixed = 0.0,
        public readonly bool $isActive = true,
        public readonly array $images = [],
    ) {}

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'vehicle_type_id' => $this->vehicleTypeId,
            'vehicle_make' => $this->vehicleMake,
            'vehicle_model' => $this->vehicleModel,
            'vehicle_year' => $this->vehicleYear,
            'vehicle_plate_number' => $this->vehiclePlateNumber,
            'vehicle_color' => $this->vehicleColor,
            'vehicle_capacity' => $this->vehicleCapacity,
            'bio' => $this->bio,
            'base_rate_per_km' => $this->baseRatePerKm,
            'base_rate_fixed' => $this->baseRateFixed,
            'is_active' => $this->isActive,
        ];
    }

    public static function fromRequest(array $data): self
    {
        return new self(
            userId: $data['user_id'],
            vehicleTypeId: $data['vehicle_type_id'],
            vehicleMake: $data['vehicle_make'] ?? null,
            vehicleModel: $data['vehicle_model'] ?? null,
            vehicleYear: $data['vehicle_year'] ?? null,
            vehiclePlateNumber: $data['vehicle_plate_number'] ?? null,
            vehicleColor: $data['vehicle_color'] ?? null,
            vehicleCapacity: $data['vehicle_capacity'] ?? null,
            bio: $data['bio'] ?? null,
            baseRatePerKm: $data['base_rate_per_km'] ?? 0.0,
            baseRateFixed: $data['base_rate_fixed'] ?? 0.0,
            isActive: $data['is_active'] ?? true,
            images: $data['images'] ?? [],
        );
    }
}
