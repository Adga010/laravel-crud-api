<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     * En este caso, siempre se autoriza, por lo que se retorna true.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Define las reglas de validación para los datos enviados en la solicitud.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // El nombre es obligatorio, debe ser una cadena y máximo 255 caracteres.
            'name' => 'required|string|max:255',
            // El email es obligatorio, debe tener formato email y ser único en la tabla 'student'.
            'email' => 'required|email|unique:student,email',
            // El teléfono es obligatorio, debe ser numérico y contener exactamente 10 dígitos.
            'phone' => 'required|numeric|digits:10',
            // La edad es obligatoria, debe ser un número entero y no puede ser negativa.
            'age' => 'required|integer|min:0',
            // El lenguaje es obligatorio, debe ser una cadena y máximo 50 caracteres.
            'language' => 'required|string|max:50',
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
            // Mensaje personalizado si el campo 'phone' no es numérico.
            'phone.numeric' => 'The phone number must be numeric.',
            // Mensaje personalizado si el campo 'phone' no tiene exactamente 10 dígitos.
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
                'success' => false,               // Indica que la operación no fue exitosa.
                'message' => 'Validation error',  // Mensaje genérico de error de validación.
                'errors' => $validator->errors(), // Detalles de los errores de validación.
            ], 400) // Código de estado HTTP 400 (Bad Request).
        );
    }
}
