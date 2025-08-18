<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    try {
        // Loguea la entrada
        Log::info('Intentando crear usuario', $request->all());

        // Validación
        $request->validate([
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:3',
        ]);

        // Crear usuario
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
        ]);

        // Loguea éxito
        Log::info('Usuario creado exitosamente', ['user_id' => $user->id]);

        return response()->json([
            'data' => $user,
            'mensaje' => "Usuario guardado con éxito"
        ]);

    } catch (\Exception $e) {
        // Loguea error
        Log::error('Error al crear usuario', [
            'mensaje' => $e->getMessage(),
            'stack'   => $e->getTraceAsString(),
        ]);

        return response()->json([
            'error' => true,
            'mensaje' => 'Ocurrió un error al guardar el usuario'
        ], 500);
    }
}





    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $e = User::find($id);
        if(isset($e)){
              return response()->json([
                    'data'=>$e,
                    'mensaje'=>"Usuario encontrado con exito"
                ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $e = User::find($id);
        if(isset($e)){
            $e->first_name = $request->first_name;
            $e->last_name = $request->last_name;
            $e->email = $request->email;
            $e->password = Hash::make($request->password);
            if($e->save()){
                return response()->json([
                    'data'=>$e,
                    'mensaje'=>"Usuario actualizado con exito"
                ]);
            }
            else{
                return response()->json([
                    'data'=>true,
                    'mensaje'=>"No se actualizo el usuario"
                ]);
            }

        }
        else{
            return response()->json(
                [
                    'error'=>true,
                    'mensaje'=>"No existe el usuario"
                ]
                );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $e = User::find($id);
        if(isset($e)){
            $res=User::destroy($id);
            if($res){
                return response()->json([
                'data'=>$e,
                'mensaje'=>"Usuario eliminado con exito"

            ]); 
            }
        }
        else{
                 return response()->json([
                'data'=>$e,
                'mensaje'=>"Usuario no existe"

            ]); 
        }
    }
}
