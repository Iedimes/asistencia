<?php

namespace App\Http\Requests\Admin\Help;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreHelp extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize(): bool
    // {
    //     return Gate::allows('admin.help.create');
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'ci' => ['required', 'integer'],
            'name' => ['required', 'string'],
            'user' => ['nullable', 'string'],
            'dependency' => ['required', 'string'],
            'fone' => ['required', 'string'],
            'problem' => ['required', 'string'],
            'dependency_id' => ['required' , 'integer'],

        ];
    }

    public function messages()
    {
        return [
            'ci.required' => 'Debe cargar el número de cedula de identidad.',
            'ci.integer' => 'El número de cedula debe ser numerico, sin puntos.',
            'name.required' => 'Debe cargar el numero de cedula, el nombre se obtiene de manera automatica.',
            // 'user.required' => 'Debe cargar el numero de cedula, el usuario se obtiene de manera automatica.',
            'dependency.required' => 'Debe cargar el numero de cedula, la dependencia se obtiene de manera automatica.',
            'fone.required' => 'Debe cargar el numero de telefono.',
            'problem.required' => 'Debe cargar el incoveniente que esta presentando.',

            //'ruc' => 'Cargue RUC',
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
