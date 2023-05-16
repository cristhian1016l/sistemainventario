<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Validation\TeamValidation;
use App\Models\Team;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $productors = DB::select("SELECT w.id, CONCAT(w.lastname, ' ', w.name) AS names FROM workers w 
                                INNER JOIN worker_type wt ON w.worker_type_id = wt.id
                                WHERE wt.id = 3");
        
        $data = ['productors' => $productors];

        return view('team.index', $data);
    }    

    public function returnTeams()
    {
        $teams = DB::select("SELECT t.id, w.id as productor_id, t.name, CONCAT(w.lastname, ' ', w.name) as names FROM teams t
                            INNER JOIN workers w ON t.productor_id = w.id");
        return $teams;
    }

    // RETURN DATA LIKE JSON

    public function getTeams()
    {
        return response()->json(['teams' => $this->returnTeams() ]);
    }

    public function insert(Request $request)
    {

        $TeamValidation = new TeamValidation;

        $validator = $TeamValidation->validateInsertAndUpdate($request);
        
        if($validator->fails()){
            return response()->json([
                'status' => 500,
                "msg" => "El equipo no fue creado",
                'errors' => $validator->errors()->all()
            ]);
        }else{
            try{
                DB::beginTransaction();
                $team = new Team();
                $team->name = mb_strtoupper($request->team, 'utf-8');
                $team->productor_id = $request->productor_id;
                $team->save();
                DB::commit();
                return response()->json([
                    'status' => 200,
                    'msg' => "Equipo agregado correctamente"
                ]);
            }catch(\Exception $th){
                DB::rollback();
                return response()->json([
                    'status' => 500,
                    'msg' => $th->getMessage(),
                ]);
            }
        }

    }
}
