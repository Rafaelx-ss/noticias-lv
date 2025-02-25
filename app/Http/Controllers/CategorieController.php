<?php

namespace App\Http\Controllers;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index()
    {
    try {
        $objects = Categorie::all();

        return response()->json([
            'success' => true,
            'data' => $objects
        ], 200

    );
    }
    catch (\Exception $e){
        return response()->json([
            'success' => false,
            'message' => 'Error al obtener la categoria',
             'error' => $e->getMessage()
        ],500);
    }


   
    }

    public function store (request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string|max:255'
            ]);
            // $object = new Categorie();
            // $object->nombre = $request->nombre;
            // $object->descripcion = $request->descripcion;
            // $object->save();

            $categoria = Categorie::create ([
                'nombre'=>$request ->nombre,
                'descripcion'=>$request->descripcion
            ]);

            return response()->json([
                'success' => true,
                'data' => $categoria
            ], 200

        );
        }
        catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar categoria',
                 'error' => $e->getMessage()
            ],500);
        }
    }

    public function show(int $id):JsonResponse
    {
        try {
            $categoria = Categorie::findOrFail($id);
            return response()->json([
                'success'=>true,
                'data'=>$categoria
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success'=>false,
                'message'=>'Ocurri[o un error inesperado, intente nuevamente.'
            ], 500);
        }
    }

    public function update(request $request, int $id)
    {
        try {
            $categoria = Categorie::findOrFail($id);

            $validated = $request->validate([
                'nombre' => 'sometimes|required|string|max:255|unique:categories,nombre,' . $id,
                'descripcion' => 'sometimes|required|string|max:255|unique:categories,descripcion,' . $id
            ]);
    
            // Actualizar solo si hay cambios
            $categoria->fill($validated);
            if ($categoria->isDirty()) {
                $categoria->save();
            }

            return response()->json([
                'success'=>true,
                'message'=>'Categoria creado exitosamente',
                'data'=>$categoria
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success'=>false,
                'message'=>'Categoria no creado exitosamente',
                'error'=>$e->getMessage()
            ], 500);        
        }
    }


    public function destroy(int $id)
    {
        try {
            $type =  Categorie::findOrFail($id);
            $type->delete();

            return response()->json([
                'success'=>true,
                'message'=>'Categoria eliminada exitosamente',
            ], 200); 
        } catch (NotFoundExcepcion $e) {
            return response()->json([
                'success'=>false,
                'message'=>'Categoria no fue encontrado',
            ], 401); 
        } catch (Throwable $e) {
            return response()->json([
                'success'=>false,
                'message'=>'Ocurri[o un error inesperado, intentelo nuevamente',
            ], 500); 
        }
    }
    
}
