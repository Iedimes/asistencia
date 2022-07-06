<?php

namespace App\Http\Requests\Admin\DetailHelp;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreDetailHelp extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.detail-help.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'help_id' => ['required', 'integer'],
            'user' => ['required'],
            'state' => ['required'],
            'solution' => ['required', 'string'],
            'date' => ['required', 'date'],
            'category' => ['required'],
            'patrimony' => ['nullable'],

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

    public function getStateId()
    {
        return $this->get('state')['id'];
    }

    public function getCategoryId()
    {
        return $this->get('category')['id'];
    }

    public function getUserId()
    {
        return $this->get('user')['id'];
    }
}
