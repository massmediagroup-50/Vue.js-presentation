<?php

namespace App\Models;

class Contact extends BaseModel
{
    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }
}
