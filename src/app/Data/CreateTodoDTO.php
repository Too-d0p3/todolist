<?php

namespace App\Data;

class CreateTodoDTO
{
    public function __construct(
        public string $title,
        public bool $done = false,
    ) {}
}
