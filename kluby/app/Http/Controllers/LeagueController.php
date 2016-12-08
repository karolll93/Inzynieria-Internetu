<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class LeagueController extends Controller {

    public function all() {
        $leagues = DB::select('SELECT * FROM rozgrywki ORDER by roz_sezon DESC, roz_liga, roz_nazwa');
        return view('leagues.all', [
            'leagues' => $leagues
        ]);
    }

}