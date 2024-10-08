<?php

namespace App\Interfaces;

interface TodoProviderInterface
{
    public function getTodos(): array;
}
