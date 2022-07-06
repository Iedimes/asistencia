<?php

namespace App\Http\Requests\Admin\Functionary;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreFunctionary extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.functionary.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'ci' => ['required', 'integer'],
            'full_name' => ['required', 'string'],
            'user_name' => ['required', 'string'],
            
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
