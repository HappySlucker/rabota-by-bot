<?php

declare(strict_types=1);

namespace App\Bot\DTO;

class Account
{
    public function __construct(
        public readonly string $country,
        public readonly string $phone,
        public readonly string $password,
    ) {
    }

    public static function fromArray(array $data): Account
    {
        return new self(
            $data['country'],
            $data['phone'],
            $data['password'],
        );
    }
}
