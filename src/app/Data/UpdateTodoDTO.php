<?php

namespace App\Data;

class UpdateTodoDTO
{
    public function __construct(
        public string $title,
        public bool $done = false,
    ) {}
}
