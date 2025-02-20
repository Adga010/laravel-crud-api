<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateStudentRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     * Aquí se retorna true para permitir el acceso.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Define las reglas de validación para los datos enviados en la solicitud de actualización.
     *
     * @return array
     */
    public function rules()
    {
        // Obtenemos el ID del estudiante desde la ruta para excluirlo en la validación de email único.
        $studentId = $this->route('id');

        return [
            // Se usa "sometimes|required" para permitir actualizaciones parciales.
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:student,email,' . $studentId,
            'phone' => 'sometimes|required|numeric|digits:10',
            'age' => 'sometimes|required|integer|min:0',
            'language' => 'sometimes|required|string|max:50',
        ];
    }

    /**
     * Define mensajes de error personalizados para ciertas reglas de validación.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'phone.numeric' => 'The phone number must be numeric.',
            'phone.digits' => 'The phone number must contain exactly 10 digits.',
        ];
    }

    /**
     * Este método se ejecuta cuando la validación falla.
     * Lanza una excepción que retorna una respuesta JSON con los errores y un código HTTP 400.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400)
        );
    }
}
