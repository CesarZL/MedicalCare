<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Paciente;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telefono' => ['required', 'string', 'max:255', 'unique:users'],
            'curp' => ['required', 'string', 'max:255', 'unique:users'],
            'sexo' => ['required', 'string'],
            'tipo_sangre' => ['required', 'string', 'max:3'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // Crear el usuario
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'curp' => $input['curp'],
            'password' => Hash::make($input['password']),
            'telefono' => $input['telefono'],
        ]);

        // Crear el paciente asociado
        Paciente::create([
            'user_id' => $user->id,
            'sexo' => $input['sexo'],
            'tipo_sangre' => $input['tipo_sangre'],
        ]);

        return $user;
    }
}
