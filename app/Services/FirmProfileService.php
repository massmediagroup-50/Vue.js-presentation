<?php

namespace App\Services;

use Log;
use App\Models\Address;
use App\Models\Contact;
use App\Models\Employee;
use App\Models\Firm;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class FirmProfileService
{
    /**
     * @param Firm $firm
     * @param User $user
     * @param array $input
     */
    public function update(Firm $firm, User $user, array $input)
    {
        $this->updateUser($firm, $user, $input['user']);
        $this->updateContacts($firm, $input['contacts']);
        $this->updatePicture($firm, $input);

        $firm->description = $input['description'];
        $firm->slug = $input['slug'];
        $firm->save();
    }

    /**
     * @param Firm $firm
     * @param User $user
     * @param array $input
     */
    public function updateUser(Firm $firm, User $user, array $input)
    {
        $settings = [
            'email' => $input['email'],
            'name' => $input['name']
        ];

        if (isset($input['password']) && !empty($input['password'])) {
            $settings['password'] = bcrypt($input['password']);
        }

        $user->update($settings);

        $firm->update(['name' => $user->name]);
    }

    /**
     * @param Firm $firm
     * @param array $input
     */
    public function updateContacts(Firm $firm, array $input)
    {
        foreach ($input as $type => $item) {
            $contact = $firm->contacts->firstWhere('type', strtoupper($type));

            if ($contact) {
                $contact->update(['value' => $item]);
            } else {
                $contact = new Contact([
                    'type' => strtoupper($type),
                    'value' => $item
                ]);

                $firm->contacts()->save($contact);
            }
        }
    }

    /**
     * @param Firm $firm
     * @param array $input
     */
    public function updatePicture(Firm $firm, array $input)
    {
        if (isset($input['deletePicture']) && $input['deletePicture']) {
            $firm->profile_picture = null;
            $firm->save();
        }

        if (isset($input['createPicture']) && $input['createPicture'] && request()->json('profile.profile_picture')) {
            $image = $this->createImageFromBase64(request()->json('profile.profile_picture'));
            $firm->profile_picture = $image;
            $firm->save();
        }
    }

    /**
     * @param Firm $firm
     * @param array $input
     * @return mixed
     */
    public function addAddress(Firm $firm, array $input)
    {
        return $firm->addresses()->create($input);
    }

    /**
     * @param Firm $firm
     * @param $hashId
     * @throws \Exception
     */
    public function removeAddress(Firm $firm, $hashId)
    {
        if ($hashId) {
            $address = Address::find(decode($hashId));

            if ($address && $address->firm_id == $firm->id) {
                $address->delete();
            }
        }
    }

    /**
     * @param Firm $firm
     * @param array $input
     * @return mixed
     * @throws \Exception
     */
    public function addEmployee(Firm $firm, array $input)
    {
        if (isset($input['id'])) {
            $employee = Employee::find(decode($input['id']));
        } else {
            $employee = new Employee([
                'name' => $input['name']
            ]);
        }

        return $firm->employees()->save($employee);
    }

    /**
     * @param Firm $firm
     * @param $hashId
     * @throws \Exception
     */
    public function removeEmployee(Firm $firm, $hashId)
    {
        if ($hashId) {
            $employee = Employee::find(decode($hashId));

            if ($employee && $employee->firm_id == $firm->id) {
                $employee->delete();
            }
        }
    }

    /**
     * Save image from base64 string
     *
     * @param $image
     * @return bool|string
     */
    private function createImageFromBase64($image)
    {
        $name = 'img_'.time().'.png';
        @list($type, $image) = explode(';', $image);
        @list(, $image) = explode(',', $image);
        if ($image != "") {
            Storage::disk('public')->put($name, base64_decode($image));
            return $name;
        }

        return false;
    }
}
