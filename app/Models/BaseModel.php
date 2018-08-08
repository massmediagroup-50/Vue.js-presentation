<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $guarded = [];
    
    public function getHashIdAttribute()
    {
        return encode($this->id);
    }
    
    public function toArray()
    {
        $arr = parent::toArray();
        unset($arr['id']);
        $arr['hashId'] = $this->hashId;
        return $arr;
    }

    static function hashId($hashId)
    {
        return self::where('id', decode($hashId));
    }
}
