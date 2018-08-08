<?php

namespace App\Transformers;

use App\Models\Contact;
use League\Fractal\TransformerAbstract;

class ContactTransformer extends TransformerAbstract
{

    public function transform(Contact $model)
    {
        return [
            'id' => $model->hashId,
            'type' => $model->type,
            'value' => $model->value,
        ];
    }

}