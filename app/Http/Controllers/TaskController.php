<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Tasks_users_rl;
use App\Models\Department;
use App\Models\User;
use App\Models\Person;
use App\Models\Group;
use Auth;
use DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = DB::table('tasks')
            ->join('users as usuarioAsig','usuarioAsig.id','tasks.asign_a')
            ->join('persons as perAsig', 'perAsig.id', '=', 'usuarioAsig.persona_id')
            ->leftJoin('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
            ->leftJoin('persons as perSoli', 'perSoli.id', '=', 'usuarioSolici.persona_id')
            ->join('departments', 'departments.id', '=', 'tasks.department_id')
            ->where('tasks.usuario_solicitante','=',Auth::user()->id)
            ->select('tasks.*','perAsig.name as NombreAsig','perAsig.last_name as ApellidoAsig','perSoli.name as NombreSoli','perSoli.last_name as ApellidoSoli','departments.namedt',)
            ->get(); 
        return view('tasks.index', compact('tasks'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $departmentt = Department::all();

        $opcion_rrp = DB::table('option')
            ->join('sub_option', 'sub_option.cabe_opcion', '=', 'option.id_subopcion')
            ->where('option.nombre_opcion','=','REPETIR_CADA')
            ->select('sub_option.*')
            ->get();

        $userss = DB::table('users')
            ->join('persons', 'persons.id', '=', 'users.persona_id')
            ->join('departments', 'departments.id', '=', 'users.deparment_id')
            ->where('users.estado','=','ACTIVO')
            ->select('persons.*','departments.*')
            ->get();

        $datos = [
            'departma' => $departmentt,
            'opciones' => $userss,
        ];
        return view('tasks.create', compact('datos','opcion_rrp'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

            $tasks = array();
            $tasks = new Task;
            $tasks->asunto          = $request->input('asunto');
            $tasks->descripcion     = $request->input('descripcion');
            $tasks->fecha_entrega   = $request->input('fecha_entrega');
            $tasks->department_id   = $request->input('departamento');
            $tasks->asign_a         = $request->input('asign_a');
            $tasks->ciclo           = $request->input('rcada');
            $tasks->usuario_solicitante     = Auth::user()->id;
            $tasks->estado          = 'PENDIENTE POR APROBAR';
            $tasks->save();

        $files = $request->file('file');
        if (!empty($files)) {
            for ($i = 0; $i < count($files); $i++) {
        
                $file   = $files[$i];
                $nombre = $files[$i]->getClientOriginalName();
                $path   = $file->storeAs('/public/archivos_adjuntos',$nombre);


                if ($file !== null) {
                    $tasks_rl = new Tasks_users_rl;
                    $tasks_rl->id_tasks = $tasks->id;
                    $tasks_rl->file = $path;
                    $tasks_rl->id_users = Auth::user()->id;
                    $tasks_rl->save();
                }
            }
        }

        $notificationa=array(
            'message' => 'Tarea ingresada con éxito',
            'alert-type' => 'success'
        );
        return redirect()->route('tasks.index', $tasks->id)
            ->with($notificationa);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
}
