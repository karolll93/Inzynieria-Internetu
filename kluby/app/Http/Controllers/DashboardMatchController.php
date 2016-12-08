<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardMatchController extends Controller {

    public function index(Request $request) {
        $message = $request->session()->pull('message');
        $matches = DB::select("SELECT m.*, k1.k_nazwa as gospodarz, k2.k_nazwa as gosc, r.* FROM mecze m
	JOIN rozgrywka_kluby rk1 ON m.m_gospodarz=rk1.rk_id
	JOIN kluby k1 ON rk1.rk_klub=k1.k_id
	JOIN rozgrywka_kluby rk2 ON m.m_gosc=rk2.rk_id
	JOIN kluby k2 ON rk2.rk_klub=k2.k_id
	JOIN rozgrywki r ON m.m_rozgrywka=r.roz_id
	ORDER by m_data");
        $goals = array();
        if (count($matches) > 0) {
            foreach ($matches as $m) {
                $db = DB::select("SELECT Count(*) as ilosc FROM gole WHERE g_mecz = ?", [$m->m_id]);
                $goals[$m->m_id] = $db[0]->ilosc;
            }
        }
        return view('dashboard.matches.index', [
            'message' => $message,
            'matches' => $matches,
            'goals' => $goals
        ]);
    }

    public function add(Request $request) {
        $league_idS = $request->session()->get('league_id');
        if (isset($_POST['league_id']) || $league_idS) return $this->addOrEdit($request, NULL);
        return $this->addFormLeague($request);
    }

    public function edit(Request $request, $id) {
        return $this->addOrEdit($request, $id);
    }

    public function addFormLeague(Request $request) {
        $leagues = DB::select("SELECT * FROM rozgrywki order by roz_sezon DESC, roz_liga, roz_nazwa");
        return view('dashboard.matches.addFormLeague', [
            'leagues' => $leagues,
            'url' => $request->getUri()
        ]);
    }

    private function addOrEdit(Request $request, $id = NULL) {
        $mode = "dodaj";
        $title = "Dodaj nowy mecz";
        $match = [];
        if ($id) {
            $mode = "edytuj";
            $title = "Edytuj mecz";
            $results = DB::select("SELECT * FROM mecze where m_id = :id limit 1", ['id' => $id]);
            if (!$results) abort(404);
            $match = $results[0];
        }
        $message = $request->session()->pull('message');
        $errors = [];
        $league_id = $match ? $match->m_rozgrywka : NULL;
        if (!$league_id) $league_id = $request->session()->pull('league_id');
        if (!$league_id && isset($_POST['league_id'])) $league_id = $_POST['league_id'];
        if (!$league_id) abort(404);

        $place = $match ? $match->m_miejsce : '';
        $viewers = $match ? $match->m_widzow : '';
        $referee = $match ? $match->m_sedzia : '';
        $host_id = $match ? $match->m_gospodarz : NULL;
        $guest_id = $match ? $match->m_gosc : NULL;
        $date = $match ? $match->m_data : '';
        $played = $match ? $match->m_rozegrany == 't' : false;
        $goals1 = $match ? $match->m_bramki1 : '';
        $goals2 = $match ? $match->m_bramki2 : '';

        if ($request->isMethod('post') && $request->input('save')) {
            $league_id = $request->input('league_id');
            if (!$league_id) {
                $errors[] = "Nie wybrano rozgrywki.";
            }
            $host_id = trim($request->input('host_id'));
            if (!$host_id) {
                $errors[] = 'Gospodarz jest obowiązkowy.';
            }
            $guest_id = trim($request->input('guest_id'));
            if (!$guest_id) {
                $errors[] = 'Gość jest obowiązkowy.';
            }
            if ($host_id == $guest_id) {
                $errors[] = 'Gospodarz i gość nie mogą być taci sami.';
            }
            $date = $request->input('date');
            if (!$date || $date == "0000-00-00") {
                $errors[] = "Nie podano daty";
            }
            $played = $request->input('played') == "1";
            $goals1 = $played ? (int)$request->input('goals1') : NULL;
            $goals2 = $played ? (int)$request->input('goals2') : NULL;
            $place = trim($request->input('place'));
            $viewers = (int)trim($request->input('viewers'));
            $referee = trim($request->input('referee'));
            if (count($errors) == 0) {
                if (!$match) {
                    $save = DB::insert('INSERT INTO mecze (m_data, m_miejsce, m_rozegrany, m_bramki1, m_bramki2, m_widzow, m_sedzia, m_gospodarz, m_gosc, m_rozgrywka) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$date, $place, $played ? 't' : 'n', $goals1, $goals2, $viewers, $referee, $host_id, $guest_id, $league_id]);
                    $request->session()->put('league_id', $league_id);
                    $message = 'Mecz został dodany. Możesz teraz dodać kolejny.';
                } else {
                    $save = DB::update('UPDATE mecze SET m_data = :data, m_miejsce = :place, m_rozegrany = :played, m_bramki1 = :goals1, m_bramki2 = :goals2, m_widzow = :viewers, m_sedzia = :referee, m_gospodarz = :host_id, m_gosc = :guest_id WHERE m_id = :id LIMIT 1', [
                        'data' => $date,
                        'place' => $place,
                        'played' => $played ? 't' : 'n',
                        'goals1' => $goals1,
                        'goals2' => $goals2,
                        'viewers' => $viewers,
                        'referee' => $referee,
                        'host_id' => $host_id,
                        'guest_id' => $guest_id,
                        'id' => $id
                    ]);
                    $message = 'Zapisano zmiany.';
                }
                if ($save) {
                    $request->session()->put('message', $message);
                    return redirect($request->getUri());
                }
            }
        }
        $clubs = DB::select("SELECT * FROM rozgrywka_kluby rk JOIN kluby k ON rk.rk_klub=k.k_id WHERE rk_roz = ? ORDER by k_nazwa", [$league_id]);
        $leagues = DB::select("SELECT * FROM rozgrywki order by roz_sezon DESC, roz_liga, roz_nazwa");
        if (!$viewers) $viewers = '';
        return view('dashboard.matches.addOrEdit', [
            'mode' => $mode,
            'title' => $title,
            'errors' => $errors,
            'url' => $request->getUri(),
            'message' => $message,
            'leagues' => $leagues,
            'league_id' => $league_id,
            'host_id' => $host_id,
            'guest_id' => $guest_id,
            'place' => $place,
            'played' => $played,
            'viewers' => $viewers,
            'referee' => $referee,
            'clubs' => $clubs,
            'date' => $date,
            'goals1' => $goals1,
            'goals2' => $goals2
        ]);
    }

    public function delete(Request $request, $id) {
        $results = DB::select("SELECT * FROM mecze WHERE m_id = :id limit 1", ['id' => $id]);
        if (!$results) abort(404);
        $delete = DB::delete("DELETE FROM mecze WHERE m_id = :id limit 1", ['id' => $id]);
        if ($delete) {
            $message = 'Mecz został usunięty.';
            $request->session()->put('message', $message);
        }
        return redirect(route("dashboard.matches"));
    }

    public function goals_add(Request $request, $id) {
        return $this->goals($request, $id, 1);
    }

    public function goals(Request $request, $id, $show_form = 0) {
        $results = DB::select("SELECT m.*, k1.k_nazwa as gospodarz, k2.k_nazwa as gosc, r.* FROM mecze m
	JOIN rozgrywka_kluby rk1 ON m.m_gospodarz=rk1.rk_id
	JOIN kluby k1 ON rk1.rk_klub=k1.k_id
	JOIN rozgrywka_kluby rk2 ON m.m_gosc=rk2.rk_id
	JOIN kluby k2 ON rk2.rk_klub=k2.k_id
	JOIN rozgrywki r ON m.m_rozgrywka=r.roz_id
	WHERE m_id = :id limit 1", ['id' => $id]);
        if (!$results) abort(404);
        $match = $results[0];

        $message = $request->session()->pull('message');
        $errors = [];

        $players_host = [];
        $players_guest = [];
        if ($show_form) {
            if ($request->isMethod('post')) {
                $player_id = (int)$request->input('player_id');
                if (!$player_id) $errors[] = "Nie wybrano zawodnika.";
                $type = $request->input('type');
                $min = (int)$request->input('min');
                if (count($errors) == 0) {
                    $save = DB::insert('INSERT INTO gole (g_min, g_typ, g_mecz, g_kzaw) VALUES (?, ?, ?, ?)', [$min, $type, $match->m_id, $player_id]);
                    $message = 'Gol został dodany. Możesz teraz dodać kolejny.';
                    if ($save) {
                        $request->session()->put('message', $message);
                        return redirect($request->getUri());
                    }
                }
            }
            $players_host = DB::select("SELECT * FROM klub_zawodnicy kz
      JOIN zawodnicy z ON kz.kzaw_zaw=z.z_id
      WHERE kzaw_klub = ? ORDER by z_nazwisko, z_imie", [$match->m_gospodarz]);
            $players_guest = DB::select("SELECT * FROM klub_zawodnicy kz
      JOIN zawodnicy z ON kz.kzaw_zaw=z.z_id
      WHERE kzaw_klub = ? ORDER by z_nazwisko, z_imie", [$match->m_gosc]);
        }

        $goals = DB::select("SELECT * FROM gole g
		JOIN klub_zawodnicy kz ON g.g_kzaw=kz.kzaw_id
		JOIN zawodnicy z ON kz.kzaw_zaw=z.z_id
		JOIN rozgrywka_kluby rk ON kz.kzaw_klub=rk.rk_id
		JOIN kluby k ON rk.rk_klub=k.k_id
		WHERE g_mecz = :id ORDER by g_min, g_id", ['id'=>$id]);
        return view('dashboard.matches.goals', [
            'message' => $message,
            'match' => $match,
            'goals' => $goals,
            'show_form' => $show_form,
            'url' => $request->getUri(),
            'errors' => $errors,
            'players_host' => $players_host,
            'players_guest' => $players_guest
        ]);
    }

    public function goals_delete(Request $request, $id, $goal_id) {
        $results = DB::select("SELECT * FROM mecze WHERE m_id = :id limit 1", ['id' => $id]);
        if (!$results) abort(404);
        $match = $results[0];
        $results = DB::select("SELECT * FROM gole WHERE g_id = :id limit 1", ['id' => $goal_id]);
        if (!$results) abort(404);
        $goal = $results[0];
        if ($goal->g_mecz != $match->m_id) abort(404);
        $delete = DB::delete("DELETE FROM gole WHERE g_id = :id limit 1", ['id' => $goal_id]);
        if ($delete) {
            $message = 'Gol został usunięty.';
            $request->session()->put('message', $message);
        }
        return redirect(route("dashboard.matches.goals",['id'=>$id]));
    }

}