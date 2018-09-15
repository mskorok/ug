<?php


namespace App\Models\Validators;

use App\Models\Users\User;
use Validator;

/**
 * Class UserValidator
 * @package App\Models\Validators
 */
class UserValidator extends Validator
{
    /**
     * @param array $input
     * @return \Illuminate\Validation\Validator
     */
    public static function make(array $input)
    {
        $rules = User::VALIDATION_RULES;
        $validator = Validator::make($input, $rules);

        $validator->sometimes('password', 'required|min:' . config('auth.min_password_length'), function ($input) {
            return (empty($input->social_id) && empty($input->id));
        });

        $except = isset($input['id']) ? ','.$input['id'] : null;

        $validator->sometimes(
            'email',
            'bail|required|max:255|email|unique:users,email'.$except,
            function ($input) {
                return empty($input->social_id);
            }
        );

        return $validator;
    }
}
