<?php

namespace App\Interfaces;

interface TodoAdapterInterface
{
    public function adapt(array $data): array;
}
