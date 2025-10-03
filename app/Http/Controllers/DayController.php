<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Day;
use App\Models\Next;
use App\Models\Board;
use App\Models\Ready;
use App\Models\Category;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DayController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index()
    {
        $day = Day::where('status', '!=', 0)->where('deleted_at', null)->get();
        $count = Day::where('status', 2)->where('deleted_at', null)->count();

        return view('list.browse', compact('day', 'count'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            Day::create($request->all());            
            DB::commit();
            return redirect()->route('day.index')->with(['message' => 'Registrado Exitosamente.', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
           DB::rollBack();
            return redirect()->route('day.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);         
        }
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $day = Day::find($request->id);
            $day->update($request->all());
            DB::commit();
            return redirect()->route('day.index')->with(['message' => 'Actualizado Exitosamente.', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('day.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $day = Day::find($request->id);
            $day->update(['status' => 0, 'deleted_at' => Carbon::now()]);
            DB::commit();
            return redirect()->route('day.index')->with(['message' => 'Eliminado Exitosamente.', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('day.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
        
    }
    public function finalize(Request $request)
    {
        $day = Day::find($request->id);
        $day->update(['status' => 1]);
        return redirect()->route('day.index')->with(['message' => 'Finalizado Exitosamente.', 'alert-type' => 'success']);
    }

    public function show($id)
    {
        DB::table('nexts')->delete();
        $ready = Ready::with(['category', 'day'])->where('status',1)->where('deleted_at', null)->where('day_id', $id)->first();
        if($ready){
            $readys = Ready::with('category')->where('status',1)->where('deleted_at', null)->where('day_id', $id)->get();
            $next = Next::create(['ready_id' => $ready->id, 'total' => count($readys)-1, 'lote' => $ready->lote, 'quantity' => $ready->quantity, 'price' => $ready->price, 'category' => $ready->category->name, 'total_weight' => $ready->total_weight]);
            $day = Day::find($id);

            return view('board.board-user', compact('id', 'ready', 'readys', 'next', 'day'));
        }else{
            return redirect()->route('day.index')->with(['message' => 'No tiene registado para realizar el remate.', 'alert-type' => 'error']);
        }
    }


    public function boardUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            $ready = Ready::find($request->id);
            $ready->update($request->all());
            $next = Next::where('ready_id', $ready->id)->first();
            $next->update([
                'price' => $request->price
            ]);

            if($ready->day->type == 1){
                $ready->price_add = ($request->price * $next->quantity) * ($request->commission ? $request->commission / 100 : 0);
            }elseif($ready->day->type == 2){
                $ready->price_add = ($request->price * $next->total_weight) * ($request->commission ? $request->commission / 100 : 0);
            }else{
                $ready->price_add = ($request->price * $next->quantity * ($request->fee ?? 14)) * ($request->commission ? $request->commission / 100 : 0);
            }

            $ready->update();

            $readys = Ready::with('category')->where('status',1)->where('deleted_at', null)->where('day_id', $request->day_id)->get();

            $id = $request->day_id;            
            DB::commit();
            return response()->json([
                'success' => 1,
                'message' => 'Actualizado',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => 1,
                'message' => 'Error inesperado',
            ]);
        }
    }

    public function boardNext(Request $request)
    {
        DB::beginTransaction();
        try {

            $ready = Ready::find($request->id);
            $ready->defending = $request->defending ? 1 : 0;
            $ready->update();

            $next = Next::where('ready_id', $request->id)->first();            

            $readys = Ready::with('category')->where('status',1)->where('deleted_at', null)->where('day_id', $request->day_id)->get();
           
            if($next->position < $next->total)
            {
                $next->update(['position' => $next->position + 1, 'price' => $readys[$next->position+1]->price, 'lote' => $readys[$next->position+1]->lote,
                'quantity' => $readys[$next->position+1]->quantity, 'category' => $readys[$next->position+1]->category->name,
                'ready_id' => $readys[$next->position+1]->id, 'total_weight' => $readys[$next->position+1]->total_weight]);
      
            }
            else
            {
                $next->update(['position' => 0, 'price' => $readys[0]->price, 'lote' => $readys[0]->lote,
                'quantity' => $readys[0]->quantity, 'category' => $readys[0]->category->name,
                'ready_id' => $readys[0]->id, 'total_weight' => $readys[0]->total_weight]);
                
                
            }
            $id = $request->day_id;   

            $ready = Ready::find($readys[0]->id);
            $day = Day::find($id);

            DB::commit();
            return view('board.board-user', compact('id','readys', 'ready', 'next', 'day'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('day.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
        
    }


    public function boardManual($id, $i, $day)
    {
        DB::beginTransaction();
        try {
            DB::table('nexts')->delete();
            $ready = Ready::with('category')->where('status', 1)->where('deleted_at', null)->where('id', $id)->first();
            $readys = Ready::with('category')->where('status',1)->where('deleted_at', null)->where('day_id', $day)->get();

            $next = Next::create(['position' => $i, 'ready_id' => $id, 'total' => count($readys)-1, 'lote' => $ready->lote, 'quantity' => $ready->quantity, 'price' => $ready->price, 'category' => $ready->category->name, 'total_weight' => $ready->total_weight]);
            
            $id = $day;   
            $day = Day::find($id);

            DB::commit();
            return view('board.board-user', compact('id', 'next', 'day'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('day.index')->with(['message' => 'Ocurrió un error', 'alert-type' => 'error']);
        }
    }


    public function prinf($id)
    {
        $day = Day::find($id);
        $readys = Ready::with('category')->where('status',1)->where('deleted_at', null)->where('day_id', $id)->get();
        return view('list.prinf', compact('id', 'day', 'readys'));
    }

    public function tv($id)
    {
        $day = Day::find($id);
        return view('board.board', compact('day'));
    }

    public function getBoard()
    {
        return Next::all();
    }

    public function getReady($id){
        $day = Day::with(['readys' => function($q){
            $q->where('status',1)->where('deleted_at', null);
        }, 'readys.category' => function($q){
            $q->where('status',1)->where('deleted_at', null);
        }])->where('id', $id)->first();
        $next = Next::get()->first();
        return view('board.board-ready', compact('id', 'day', 'next'));
    }

}
