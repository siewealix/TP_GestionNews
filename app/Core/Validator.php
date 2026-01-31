<?php

namespace App\Core;

class Validator
{
    private array $errors = [];

    public function required(string $field, ?string $value, string $message): void
    {
        if (trim((string) $value) === '') {
            $this->errors[$field] = $message;
        }
    }

    public function email(string $field, ?string $value, string $message): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = $message;
        }
    }

    public function minLength(string $field, ?string $value, int $min, string $message): void
    {
        if (strlen((string) $value) < $min) {
            $this->errors[$field] = $message;
        }
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function passes(): bool
    {
        return empty($this->errors);
    }
}
