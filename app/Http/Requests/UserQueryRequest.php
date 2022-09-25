<?php

namespace App\Http\Requests;

use App\Enums\ValuesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;

class UserQueryRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'only_names' => [
                'sometimes',
                new Enum(ValuesEnum::class)
            ],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function () {
            if (!is_null($this->password)) {
                $this->merge(['password' => Hash::make($this->password)]);
            }
            if ($this->only_names && strtolower($this->only_names) !== "false") {
                $this->merge(['only_names' => true]);
             } else {
                $this->merge(['only_names' => false]);
             }
        });
    }
}
