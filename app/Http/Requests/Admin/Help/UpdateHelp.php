<?php

namespace App\Http\Requests\Admin\Help;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateHelp extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.help.edit', $this->help);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'ci' => ['sometimes', 'integer'],
            'name' => ['sometimes', 'string'],
            'user' => ['sometimes', 'string'],
            'dependency' => ['sometimes', 'string'],
            'fone' => ['sometimes', 'string'],
            'problem' => ['sometimes', 'string'],
            'dependency_id' => ['required' , 'integer'],

        ];
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();


        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
