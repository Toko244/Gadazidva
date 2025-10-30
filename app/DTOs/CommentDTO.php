<?php

namespace App\DTOs;

class CommentDTO
{
    public function __construct(
        public readonly int $userId,
        public readonly int $servicePostId,
        public readonly string $content,
    ) {}

    /**
     * Convert to array for database operations
     */
    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'service_post_id' => $this->servicePostId,
            'content' => $this->content,
        ];
    }

    /**
     * Create from request data
     */
    public static function fromRequest(array $data): self
    {
        return new self(
            userId: $data['user_id'],
            servicePostId: $data['service_post_id'],
            content: $data['content'],
        );
    }
}
