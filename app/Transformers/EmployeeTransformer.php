<?php

namespace App\Transformers;

use App\Models\Employee;
use League\Fractal\TransformerAbstract;

class EmployeeTransformer extends TransformerAbstract
{
    public function transform(Employee $model)
    {
        $retval = [
            'id' => $model->hashId,
            'real_id' => $model->id,
            'name' => $model->name,
            'firm' => $model->firm_id
        ];

        return $retval;
    }
}
