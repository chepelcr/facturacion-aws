<?php

namespace App\Enums;

enum DataServiceEnum: string {
    public function getName(): string {
        return match ($this) {
            default => "Error"
        };
    }
}
