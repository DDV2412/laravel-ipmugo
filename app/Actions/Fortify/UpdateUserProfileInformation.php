<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'username' => ['required', 'string', 'min:6', Rule::unique('users')->ignore($user->id)],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'interest' => ['required', 'string', 'max:255'],
            'affiliation' => ['required'],
            'country' => ['required'],
            'saluation' => ['nullable'],
            'midlename' => ['nullable'],
            'orcid' => ['nullable', Rule::unique('users')->ignore($user->id)],
            'scopus_id' => ['nullable', Rule::unique('users')->ignore($user->id)],
            'publons' => ['nullable', Rule::unique('users')->ignore($user->id)],
            'linkend_in' => ['nullable', Rule::unique('users')->ignore($user->id)],
            'department' => ['required'],
            'address' => ['required'],
            'bio' => ['nullable'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'username' => $input['username'],
                'firstname' => $input['firstname'],
                'lastname' => $input['lastname'],
                'email' => $input['email'],
                'interest' => $input['interest'],
                'affiliation' => $input['affiliation'],
                'country' => $input['country'],
                'saluation' => $input['saluation'],
                'midlename' => $input['midlename'],
                'orcid' => $input['orcid'],
                'scopus_id' => $input['scopus_id'],
                'publons' => $input['publons'],
                'linkend_in' => $input['linkend_in'],
                'department' => $input['department'],
                'address' => $input['address'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        // $user->sendEmailVerificationNotification();
    }
}
