<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Crew;
use Session;
use Illuminate\Support\Facades\DB;

class CrewController extends Controller
{
    // POST search
    public function celeb_search(Request $request){
        $name = $request->name;
        $cate = $request->cate;
        $nation = $request->nation;

        $search = '';
        $s = '';
        if ($name) {
            $s = 'name-'.$name;
            $search = DB::table('crews')->whereRaw('crew_name like "%'.$name.'%"')
                                ->join('countries','country_id','=','nation');
        } else if ($cate){
            $s = 'cate-'.$cate;
            switch ($cate) {
                case '0_0': // Actress
                    $search = DB::table('crews')->where('position','=',0)->where('gender','=','0')
                                ->join('countries','country_id','=','nation');
                    break;
                case '0_1': // Actors
                    $search = DB::table('crews')->where('position','=',0)->where('gender','=','1')
                                ->join('countries','country_id','=','nation');
                    break;
                case '1': // Directors
                    $search = DB::table('crews')->where('position','=',1)
                                ->join('countries','country_id','=','nation');
                    break;
                case '2': // Writers
                    $search = DB::table('crews')->where('position','=',2)
                                ->join('countries','country_id','=','nation');
                    break;
            }
        } else{
            $s = 'nation-'.$nation;
            $search = DB::table('crews')->where('nation','=',$nation)
                        ->join('countries','country_id','=','nation');
        }
        return redirect()->route('celeb_list','search?='.$s)->with(['search' => $search->paginate(5,['*'],'list')]);
    }
}
