<?php

namespace App\Transformers;

use App\Models\Firm;
use League\Fractal\TransformerAbstract;

class FirmProfileTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['employees'];

    protected $availableIncludes = ['user', 'addresses', 'contacts'];

    public function transform(Firm $model)
    {
        $retval = [
            'id' => $model->hashId,
            'name' => $model->name,
            'slug' => $model->slug,
            'deleted_at' => $model->deleted_at,
            'description' => $model->description,
            'profile_picture' => $model->profile_picture
        ];

        return $retval;
    }

    public function includeUser(Firm $profile)
    {
        return $this->item($profile->user, new UserTransformer());
    }

    public function includeAddresses(Firm $profile)
    {
        return $this->collection($profile->addresses, new AddressTransformer());
    }

    public function includeContacts(Firm $profile)
    {
        return $this->collection($profile->contacts, new ContactTransformer());
    }

    public function includeEmployees(Firm $profile)
    {
        return $this->collection($profile->employees, new EmployeeTransformer());
    }
}
