<?php

namespace App\Models;

use Exception;
use Log;
use App\Traits\TransformableTrait;
use App\Transformers\FirmProfileTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Firm extends BaseModel
{
    use SoftDeletes;
    use TransformableTrait;

    static function getTransformer()
    {
        return new FirmProfileTransformer();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function contacts()
    {
        return $this->HasMany(Contact::class);
    }

    public function deactivate()
    {
        try {
            if ($this->user) {
                $this->user->delete();
            }

            $this->delete();

        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function reactivate()
    {
        if ($this->user_id !== null) {
            try {
                $user = User::where('id', $this->user_id)->withTrashed()->firstOrFail();
                if ($user) {
                    $user->restore();
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        }

        $this->restore();
    }
}
