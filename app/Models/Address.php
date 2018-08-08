<?php

namespace App\Models;

class Address extends BaseModel
{
    public function firm()
    {
        return $this->belongsToMany();
    }
}
