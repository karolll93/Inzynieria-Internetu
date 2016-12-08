<?php

namespace App\Http\Controllers;

class LeagueController extends Controller {

    public function all() {
        return view('leagues.all');
    }

}