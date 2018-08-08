<?php

namespace App\Http\Requests;

class UpdateFirmProfileRequest extends CustomFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user.name' => 'required|string',
            'user.email' => 'required|email|unique:users,id,:id',
            'user.password' => 'nullable|min:6|without_spaces',
            'contacts.email' => 'nullable|email',
            'contacts.website' => 'nullable|string',
            'contacts.fax' => 'nullable|string',
            'contacts.phone' => 'nullable|string',
            'description' => 'nullable|string',
            'slug' => 'required|unique:firms,id,:id'
        ];
    }

    public function attributes()
    {
        return [
            'user.firstname' => 'firstname',
            'user.lastname' => 'lastname',
            'user.email' => 'personal email',
            'user.password' => 'password',
            'contacts.email' => 'public email',
            'contacts.website' => 'website',
            'contacts.fax' => 'fax',
            'contacts.phone' => 'phone',
        ];
    }

    /**
     * @return mixed
     */
    protected function validationData()
    {
        return $this->json('profile');
    }
}
