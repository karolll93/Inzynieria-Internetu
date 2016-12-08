<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class MatchController extends Controller {

    public function league($id) {
        $league = DB::select('SELECT * FROM rozgrywki WHERE roz_id = ? LIMIT 1', [$id]);
        if (!$league) abort(404);
        $league = $league[0];
        $matches = DB::select('SELECT m.*, k1.k_nazwa as gospodarz, k2.k_nazwa as gosc, r.* FROM mecze m
	JOIN rozgrywka_kluby rk1 ON m.m_gospodarz=rk1.rk_id
	JOIN kluby k1 ON rk1.rk_klub=k1.k_id
	JOIN rozgrywka_kluby rk2 ON m.m_gosc=rk2.rk_id
	JOIN kluby k2 ON rk2.rk_klub=k2.k_id
	JOIN rozgrywki r ON m.m_rozgrywka=r.roz_id
	WHERE m_rozgrywka = ?
	ORDER by m_data', [$id]);
        return view('leagues.match', [
            'league' => $league,
            'matches' => $matches
        ]);
    }

}