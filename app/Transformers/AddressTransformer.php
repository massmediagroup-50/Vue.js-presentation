<?php

namespace App\Transformers;

use App\Models\Address;
use League\Fractal\TransformerAbstract;

class AddressTransformer extends TransformerAbstract
{

    public function transform(Address $model)
    {
        return [
            'id' => $model->hashId,
            'address' => $model->address,
            'city' => $model->city,
            'postcode' => $model->postcode
        ];
    }
}