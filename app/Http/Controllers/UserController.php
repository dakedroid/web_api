<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illu minate\Http\Response
     */
    public function index()
    {
        $users = User::all()->toArray();
        return response()->json($users); 
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $user = new User([
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);
            $user->save();
            return response()->json(['status' => true, 'Great thanks'], 200);
        } catch(\Exception $e){
            Log::critical("No se pudo agregar usuario: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()}");
            return response("Algo Salio mal al hacer el store", 500 );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{

            $user = User::find($id);
            if(!$user){
                return response()->json(['No existe este id'], 404);
            }

            return response()->json($user, 200);

        }catch(\Exception $e){
              Log::critical("No se pudo encontrar usuario: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()}");
              return response('Algo salio mal al realizar show', 500);

        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $user = User::find($id);
            if(!$user){
                return response()->json(['No existe este id'], 404);
            }

            $user->delete();
            return response()->json('Usuario Eliminado', 200);

        }catch(\Exception $e){
            Log::critical("No se pudo eliminar el usuario: {$e->getCode},{$e->getLine},{$e->getMessage}");
            return response('Algo salio mal al eliminar', 500);
        }
    }
}
