<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Http\Requests\StoreStudentRequest; // Asegúrate de importar la clase Form Request
use App\Http\Requests\UpdateStudentRequest; // Importa el Form Request de actualización

use App\Http\Resources\StudentResource;


class StudentController extends Controller
{
    /**
     * Muestra la lista de estudiantes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $students = Student::all();

        // Si no se encuentra ningún estudiante, se retorna un array vacío con código 200
        if ($students->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'There is no student data',
                'data' => []
            ], 200);
        }

        // Retorna la colección de estudiantes transformada con StudentResource
        return response()->json([
            'success' => true,
            'message' => 'Student List',
            'data' => StudentResource::collection($students)
        ], 200);
    }

    /**
     * Almacena un nuevo estudiante en la base de datos.
     *
     * @param  \App\Http\Requests\StoreStudentRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreStudentRequest $request)
    {
        // Con StoreStudentRequest, la validación se ejecuta automáticamente.
        // Se obtienen los datos validados.
        $validatedData = $request->validated();

        try {
            // Se crea el registro del estudiante usando los datos validados.
            $student = Student::create($validatedData);
        } catch (\Exception $e) {
            // En caso de error, se captura la excepción y se retorna una respuesta con código 500.
            return response()->json([
                'success' => false,
                'message' => 'Error creating student',
                'error' => $e->getMessage()
            ], 500);
        }

        // Se retorna una respuesta exitosa con los datos del estudiante creado y código 201 (Creado)
        return response()->json([
            'success' => true,
            'message' => 'Student created successfully',
            'data' => $student
        ], 201);
    }

    /**
     * Muestra un estudiante específico por su ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // Se busca el estudiante por su ID
        $student = Student::find($id);

        // Si no se encuentra, se retorna una respuesta con código 404
        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found',
                'data' => null
            ], 404);
        }

        // Si se encuentra, se retorna la información del estudiante con código 200
        return response()->json([
            'success' => true,
            'message' => 'Student found',
            'data' => $student
        ], 200);
    }

    /**
     * Elimina un estudiante por su ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Se busca el estudiante por su ID
        $student = Student::find($id);

        // Si no se encuentra, se retorna una respuesta con código 404
        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found',
                'data' => null
            ], 404);
        }

        try {
            // Se elimina el estudiante
            $student->delete();
        } catch (\Exception $e) {
            // En caso de error al eliminar, se captura la excepción y se retorna un error 500
            return response()->json([
                'success' => false,
                'message' => 'Error deleting student',
                'error' => $e->getMessage()
            ], 500);
        }

        // Se retorna una respuesta exitosa indicando que el estudiante fue eliminado, con código 200
        return response()->json([
            'success' => true,
            'message' => 'Student successfully removed',
            'data' => null
        ], 200);
    }

    // ... Otros métodos (index, store, etc.)

    /**
     * Actualiza los datos de un estudiante existente.
     *
     * @param  \App\Http\Requests\UpdateStudentRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateStudentRequest $request, $id)
    {
        // Se busca el estudiante por su ID
        $student = Student::find($id);

        // Si no se encuentra, se retorna un error 404
        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found',
                'data' => null
            ], 404);
        }

        // Con UpdateStudentRequest, la validación se ejecuta automáticamente.
        // Se obtienen los datos validados.
        $validatedData = $request->validated();

        try {
            // Se actualiza el registro del estudiante con los datos validados.
            $student->update($validatedData);
        } catch (\Exception $e) {
            // En caso de error, se captura la excepción y se retorna una respuesta con código 500.
            return response()->json([
                'success' => false,
                'message' => 'Error updating student',
                'error' => $e->getMessage()
            ], 500);
        }

        // Se retorna una respuesta exitosa con los datos actualizados del estudiante.
        return response()->json([
            'success' => true,
            'message' => 'Student successfully updated',
            'data' => $student
        ], 200);
    }


}
