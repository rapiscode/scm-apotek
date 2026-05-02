<?php

namespace App\Models;

use Illuminate\Auth\GenericUser;

class User extends GenericUser
{
    public function getKey(): mixed
    {
        return $this->getAuthIdentifier();
    }

    public function getRouteKey(): string
    {
        return (string) $this->getAuthIdentifier();
    }

    public function __toString(): string
    {
        return $this->getRouteKey();
    }
}
