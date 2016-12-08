<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class TableController extends Controller {

    private static function sortTable($a, $b) {
        $diff_points = $a->points - $b->points;
        if ($diff_points != 0) return -$diff_points;

        $a_goals = $a->goals_scored - $a->goals_losted;
        $b_goals = $b->goals_scored - $b->goals_losted;

        $diff_goals = $a_goals - $b_goals;
        if ($diff_goals != 0) return -$diff_goals;

        $diff_matches = $a->matches - $b->matches;
        if ($diff_matches != 0) return $diff_matches;

        return strcmp($a->name, $b->name);
    }

    public function league($id) {
        $league = DB::select('SELECT * FROM rozgrywki WHERE roz_id = ? LIMIT 1', [$id]);
        if (!$league) abort(404);
        $league = $league[0];

        $teams = DB::select("select rk_id, k_nazwa from rozgrywka_kluby rk join kluby k on rk.rk_klub=k.k_id where rk_roz = :league_id", ['league_id' => $id]);
        $table = array();
        if (count($teams) > 0) {
            foreach ($teams as $t) {
                $table[$t->rk_id] = (object)[
                    'name' => $t->k_nazwa,
                    'matches' => 0,
                    'points' => 0,
                    'goals_scored' => 0,
                    'goals_losted' => 0
                ];
            }
        }

        $matches = DB::select("select * from mecze where m_rozgrywka = :league_id and m_rozegrany = 't'", ['league_id' => $id]);
        if (count($matches) > 0) {
            foreach ($matches as $m) {
                $host_id = $m->m_gospodarz;
                $guest_id = $m->m_gosc;
            
                $table[$host_id]->matches++;
                $table[$guest_id]->matches++;

                $table[$host_id]->goals_scored += $m->m_bramki1;
                $table[$host_id]->goals_losted += $m->m_bramki2;

                $table[$guest_id]->goals_scored += $m->m_bramki2;
                $table[$guest_id]->goals_losted += $m->m_bramki1;

                if ($m->m_bramki1 > $m->m_bramki2) {
                    $table[$host_id]->points += 3;
                } else if ($m->m_bramki1 == $m->m_bramki2) {
                    $table[$host_id]->points += 1;
                    $table[$guest_id]->points += 1;
                } else if ($m->m_bramki1 < $m->m_bramki2) {
                    $table[$guest_id]->points += 3;
                }
            }
            usort($table, 'self::sortTable');
        }
        
        return view('leagues.table', [
            'league' => $league,
            'teams' => $teams,
            'table' => $table
        ]);
    }

}