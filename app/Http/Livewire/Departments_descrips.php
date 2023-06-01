<?php

namespace App\Http\Livewire;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Departments_descrip;
use App\Models\Group;
use App\Models\User;
use App\Models\Department;
use DB;

class Departments_descrips extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $departments_id, $subtarea_descrip, $usuario_asignado, $tiempo_demora, $estado;
    public $updateMode = false;

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';

        $userss = DB::table('users')
            ->join('persons', 'persons.id', '=', 'users.persona_id')
            ->join('departments', 'departments.id', '=', 'users.deparment_id')
            ->where('users.estado','=','ACTIVO','AND')
            ->where('users.id','!=',4)
            ->select('persons.*','departments.*','persons.id as idperson','departments.id as idpersondepar')
            ->get();

        $departamento = Department::all();

        $datos = [
            'departma' => $departamento,
            'opciones' => $userss,
        ];

        return view('livewire.departments_descrips.view', [

            'Departments_descrips' => DB::table('departments_descrip')
                ->join('departments', 'departments.id', '=', 'departments_descrip.departments_id')
                ->join('users', 'users.id', '=', 'departments_descrip.usuario_asignado')
                ->join('persons', 'persons.id', '=', 'users.persona_id')
                ->select('departments.namedt as nombredepartamento','persons.*','departments_descrip.*')
                ->where('departments_descrip.estado','=','ACTIVO')
                ->where(function ($query) use ($keyWord) {
                    $query->where('departments_descrip.subtarea_descrip', 'LIKE', $keyWord);
                })
                ->paginate(10),
            'datos' => $datos,

        ]);
    }
	
    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
    }
	
    private function resetInput()
    {		
		$this->departments_id = null;
		$this->subtarea_descrip = null;
		$this->usuario_asignado = null;
		$this->tiempo_demora = null;
    }

    public function store()
    {

        $this->validate([
    		'departments_id' => 'required',
    		'subtarea_descrip' => 'required',
    		'usuario_asignado' => 'required',
    		'tiempo_demora' => 'required',
        ]);

        Departments_descrip::create([ 
			'departments_id' => $this-> departments_id,
			'subtarea_descrip' => $this-> subtarea_descrip,
			'usuario_asignado' => $this-> usuario_asignado,
			'tiempo_demora' => $this-> tiempo_demora,
			'estado' => 'ACTIVO'
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Departments_descrip Successfully created.');
    }

    public function edit($id)
    {
        $record = Departments_descrip::findOrFail($id);

        $this->selected_id = $id; 
		$this->departments_id = $record-> departments_id;
		$this->subtarea_descrip = $record-> subtarea_descrip;
		$this->usuario_asignado = $record-> usuario_asignado;
		$this->tiempo_demora = $record-> tiempo_demora;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
    		'departments_id' => 'required',
    		'subtarea_descrip' => 'required',
    		'usuario_asignado' => 'required',
    		'tiempo_demora' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Departments_descrip::find($this->selected_id);
            $record->update([ 
    			'departments_id' => $this-> departments_id,
    			'subtarea_descrip' => $this-> subtarea_descrip,
    			'usuario_asignado' => $this-> usuario_asignado,
    			'tiempo_demora' => $this-> tiempo_demora
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Departments_descrip Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Departments_descrip::where('id', $id);
            $record->update([ 
                'estado' => 'INACTIVO',
            ]);

        }
    }
}
