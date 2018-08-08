<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends BaseModel
{
    use SoftDeletes;

    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }
}