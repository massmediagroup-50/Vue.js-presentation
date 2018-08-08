<?php

namespace App\Traits;

trait TransformableTrait {
    static function getTransformer() {
        throw new \Exception('Should override this method');
    }

    public function getHashIdAttribute()
    {
        return encode($this->id);
    }

    public function serialized($includes = [], $excludes = [])
    {
        return static::getSerializedItem($this, $includes, $excludes);
    }

    static function getSerializedItem($item, $includes = [], $excludes = [])
    {
        $transformer = static::getTransformer();
        return fractal()
            ->item($item, $transformer)
            ->parseIncludes($includes)
            ->parseExcludes($excludes)
            ->toArray();
    }

    public function transformed($includes = [], $excludes = [])
    {
        return static::getSerializedItem($this, $includes, $excludes);
    }
}
