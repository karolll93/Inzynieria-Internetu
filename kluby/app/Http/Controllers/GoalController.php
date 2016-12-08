<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class GoalController extends Controller {

    public function league($id) {
        $league = DB::select('SELECT * FROM rozgrywki WHERE roz_id = ? LIMIT 1', [$id]);
        if (!$league) abort(404);
        $league = $league[0];
        $goals = DB::select('SELECT z.z_id, Count(*) as ilosc FROM gole g
  JOIN mecze m ON g.g_mecz=m.m_id
  JOIN klub_zawodnicy kz ON g.g_kzaw=kz.kzaw_id
  JOIN zawodnicy z ON kz.kzaw_zaw=z.z_id
  WHERE m_rozgrywka = ?
  GROUP by z.z_id
  ORDER by ilosc DESC', [$id]);
        $info = array();
        $info_clubs = array();
        if (count($goals) > 0) {
            foreach ($goals as $g) {
                $db = DB::select('SELECT * FROM zawodnicy WHERE z_id = ? LIMIT 1', [$g->z_id]);
                $info[$g->z_id] = $db[0]->z_imie.' '.$db[0]->z_nazwisko;
                $info_clubs[$g->z_id] = DB::select('
                  SELECT * FROM klub_zawodnicy kz
                  JOIN rozgrywka_kluby rk ON kz.kzaw_klub=rk.rk_id
                  JOIN kluby k ON rk.rk_klub=k.k_id
                  WHERE kz.kzaw_zaw=? AND rk_roz=?', [$g->z_id, $league->roz_id]);
            }
        }
        return view('leagues.goals', [
            'league' => $league,
            'goals' => $goals,
            'info' => $info,
            'info_clubs' => $info_clubs
        ]);
    }

}