<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardLeagueController extends Controller {

    public function index(Request $request) {
        $message = $request->session()->pull('message');
        $leagues = DB::select("select * from rozgrywki order by roz_sezon DESC, roz_liga, roz_nazwa");
        $clubs_count = array();
        $promotion_count = array();
        if (count($leagues) > 0) {
            foreach ($leagues as $league) {
                $c_db = DB::select("select count(*) as c from rozgrywka_kluby WHERE rk_roz = ?", [$league->roz_id]);
                $clubs_count[$league->roz_id] = $c_db[0]->c;
                $p_db = DB::select("select count(*) as c from awanse WHERE ag_rozgrywka = ?", [$league->roz_id]);
                $promotion_count[$league->roz_id] = $p_db[0]->c;
            }
        }
        return view('dashboard.leagues.index', [
            'message' => $message,
            'leagues' => $leagues,
            'clubs_count' => $clubs_count,
            'promotion_count' => $promotion_count
        ]);
    }

    public function add(Request $request) {
        return $this->addOrEdit($request, NULL);
    }

    public function edit(Request $request, $id) {
        return $this->addOrEdit($request, $id);
    }

    private function addOrEdit(Request $request, $id = NULL) {
        $mode = "dodaj";
        $title = "Dodaj nową rozgrywkę";
        $league = [];
        if ($id) {
            $mode = "edytuj";
            $title = "Edytuj rozgrywkę";
            $results = DB::select("select * from rozgrywki where roz_id = :id limit 1", ['id' => $id]);
            if (!$results) abort(404);
            $league = $results[0];
        }
        $message = $request->session()->pull('message');
        $league_name = $league ? $league->roz_liga : '';
        $type = $league ? $league->roz_typ : '';
        $name = $league ? $league->roz_nazwa : '';
        $season = $league ? $league->roz_sezon : '';
        $errors = [];
        if ($request->isMethod('post')) {
            $league_name = trim($request->input('league_name'));
            if (!$league_name) {
                $errors[] = 'Liga jest obowiązkowa.';
            }
            $type = trim($request->input('type'));
            if (!$type) {
                $errors[] = 'Typ jest obowiązkowy.';
            }
            $name = trim($request->input('name'));
            if (!$name) {
                $errors[] = 'Nazwa jest obowiązkowa.';
            }
            $season = trim($request->input('season'));
            if (!$season) {
                $errors[] = 'Sezon jest obowiązkowy.';
            }
            if (count($errors) == 0) {
                if (!$league) {
                    $save = DB::insert('insert into rozgrywki (roz_liga, roz_typ, roz_nazwa, roz_sezon) values (?, ?, ?, ?)', [$league_name, $type, $name, $season]);
                    $message = 'Rozgrywka '.$league_name.' została dodana. Możesz teraz dodać kolejną.';
                } else {
                    $save = DB::update('update rozgrywki set roz_liga = :league_name, roz_typ = :type, roz_nazwa = :name, roz_sezon = :season where roz_id = :id', [
                        'league_name' => $league_name,
                        'type' => $type,
                        'name' => $name,
                        'season' => $season,
                        'id' => $league->roz_id
                    ]);
                    $message = 'Zapisano zmiany.';
                }
                if ($save) {
                    $request->session()->put('message', $message);
                    return redirect($request->getUri());
                }
            }
        }
        return view('dashboard.leagues.addOrEdit', [
            'mode' => $mode,
            'title' => $title,
            'league_name' => $league_name,
            'type' => $type,
            'name' => $name,
            'season' => $season,
            'errors' => $errors,
            'url' => $request->getUri(),
            'message' => $message
        ]);
    }

    public function delete(Request $request, $id) {
        $results = DB::select("select * from rozgrywki where roz_id = :id limit 1", ['id' => $id]);
        if (!$results) abort(404);
        $delete = DB::delete("delete from rozgrywki where roz_id = :id limit 1", ['id' => $id]);
        if ($delete) {
            $message = 'Rozgrywka '.$results[0]->roz_liga.' została usunięta.';
            $request->session()->put('message', $message);
        }
        return redirect(route("dashboard.leagues"));
    }

    public function clubs(Request $request, $id) {
        $results = DB::select("select * from rozgrywki where roz_id = :id limit 1", ['id' => $id]);
        if (!$results) abort(404);
        $league = $results[0];
        $clubs = DB::select("select * from rozgrywka_kluby rk join kluby k on rk.rk_klub=k.k_id where rk_roz = ?", [$league->roz_id]);
        $clubs_canAdd = DB::select("SELECT * FROM kluby WHERE (SELECT Count(*) FROM rozgrywka_kluby WHERE rk_roz = ? AND rk_klub = k_id)=0 ORDER by k_nazwa", [$league->roz_id]);
        
        if ($request->isMethod('post')) {
            $club_id = trim($request->input('club'));
            if ($club_id) {
                $insert = DB::insert('insert into rozgrywka_kluby (rk_roz, rk_klub) values (?, ?)', [$id, $club_id]);
                if ($insert) {
                    $message = 'Klub został dodany do tych rozgrywek.';
                    $request->session()->put('message', $message);
                    return redirect(route("dashboard.leagues.clubs", ["id"=>$id]));
                }
            }
        }

        if (count($clubs) > 0) {
            foreach ($clubs as $club) {
                $p_db = DB::select("select count(*) as c from klub_zawodnicy WHERE kzaw_klub = ?", [$club->rk_id]);
                $players_count[$club->k_id] = $p_db[0]->c;
            }
        }

        $message = $request->session()->pull('message');
        return view('dashboard.leagues.clubs', [
            'league' => $league,
            'clubs' => $clubs,
            'message' => $message,
            'clubs_canAdd' => $clubs_canAdd,
            'players_count' => $players_count
        ]);
    }

    public function clubs_delete(Request $request, $id, $club_id) {
        $results = DB::select("select * from rozgrywki where roz_id = :id limit 1", ['id' => $id]);
        if (!$results) abort(404);
        $league = $results[0];
        $results = DB::select("select * from kluby where k_id = :id limit 1", ['id' => $club_id]);
        if (!$results) abort(404);
        $club = $results[0];
        $delete = DB::delete("delete from rozgrywka_kluby where rk_roz = :league_id and rk_klub = :club_id limit 1", ['league_id' => $id, 'club_id'=>$club_id]);
        if ($delete) {
            $message = 'Klub '.$club->k_nazwa.' został usunięty z tych rozgrywek.';
            $request->session()->put('message', $message);
        }
        return redirect(route("dashboard.leagues.clubs", ["id"=>$id]));
    }

    public function promotions(Request $request, $id) {
        $results = DB::select("select * from rozgrywki where roz_id = :id limit 1", ['id' => $id]);
        if (!$results) abort(404);
        $league = $results[0];
        $promotions = DB::select("select * from awanse a JOIN kluby k ON a.ag_klub=k.k_id WHERE ag_rozgrywka = ? order by k_nazwa", [$league->roz_id]);
        $clubs = DB::select("select * from rozgrywka_kluby rk join kluby k on rk.rk_klub=k.k_id where rk_roz = ?", [$league->roz_id]);
        $profit = '';
        $club_id = 0;
        $show_form = false;
        $message = $request->session()->pull('message');
        $message_error = '';
        if ($request->isMethod('post')) {
            $show_form = true;
            $club_id = trim($request->input('club_id'));
            $profit = trim($request->input('profit'));
            if ($club_id && (!empty($profit) && is_numeric($profit)) || empty($profit)) {
                if (!$profit) $profit = 0;
                $insert = DB::insert('insert into awanse (ag_rozgrywka, ag_klub, ag_zysk) values (?, ?, ?)', [$id, $club_id, $profit]);
                if ($insert) {
                    $message = 'Dodano wpis.';
                    $request->session()->put('message', $message);
                    return redirect(route("dashboard.leagues.promotions", ["id"=>$id]));
                }
            } else {
                $message_error = "Nie dodano. Wybierz klub. Zysk powinnien być liczbą.";
            }
        }
        return view('dashboard.leagues.promotions', [
            'league' => $league,
            'promotions' => $promotions,
            'clubs' => $clubs,
            'message' => $message,
            'message_error' => $message_error,
            'profit' => $profit,
            'club_id' => $club_id,
            'show_form' => $show_form
        ]);
    }

    public function promotions_delete(Request $request, $id, $club_id) {
        $results = DB::select("select * from rozgrywki where roz_id = :id limit 1", ['id' => $id]);
        if (!$results) abort(404);
        $league = $results[0];
        $results = DB::select("select * from kluby where k_id = :id limit 1", ['id' => $club_id]);
        if (!$results) abort(404);
        $club = $results[0];
        $delete = DB::delete("delete from awanse where ag_rozgrywka = :league_id and ag_klub = :club_id limit 1", ['league_id' => $id, 'club_id'=>$club_id]);
        if ($delete) {
            $message = 'Usunięto wpis.';
            $request->session()->put('message', $message);
        }
        return redirect(route("dashboard.leagues.promotions", ["id"=>$id]));
    }

    public function clubs_players(Request $request, $id, $club_id) {
        $results = DB::select("select * from rozgrywki where roz_id = :id limit 1", ['id' => $id]);
        if (!$results) abort(404);
        $league = $results[0];
        $results = DB::select("select * from kluby where k_id = :id limit 1", ['id' => $club_id]);
        if (!$results) abort(404);
        $club = $results[0];

        $club_leaguex = DB::select("select * from rozgrywka_kluby where rk_roz = :league_id and rk_klub = :club_id limit 1", ['league_id' => $id, 'club_id' => $club_id]);
        if (!$club_leaguex) abort(404);
        $club_league = $club_leaguex[0];

        $players = DB::select("select * from klub_zawodnicy kz join zawodnicy z on kz.kzaw_zaw=z.z_id where kzaw_klub = ?", [$club_league->rk_id]);
        $players_canAdd = DB::select("SELECT * FROM zawodnicy z WHERE (SELECT Count(*) FROM klub_zawodnicy WHERE kzaw_zaw=z.z_id AND kzaw_klub=:league_id)=0 ORDER by z_nazwisko, z_imie", ["league_id"=>$club_league->rk_id]);
        
        if ($request->isMethod('post')) {
            $player_id = trim($request->input('player'));
            if ($player_id) {
                $insert = DB::insert('insert into klub_zawodnicy (kzaw_zaw, kzaw_klub) values (?, ?)', [$player_id, $club_league->rk_id]);
                if ($insert) {
                    $message = 'Zawodnik został dodany do tego klubu.';
                    $request->session()->put('message', $message);
                    return redirect(route("dashboard.leagues.clubs.players", ["id"=>$id,"club_id"=>$club_id]));
                }
            }
        }

        $message = $request->session()->pull('message');
        return view('dashboard.leagues.clubs-players', [
            'league' => $league,
            'club' => $club,
            'players' => $players,
            'message' => $message,
            'players_canAdd' => $players_canAdd
        ]);
    }

    public function clubs_players_delete(Request $request, $id, $club_id, $player_id) {
        $results = DB::select("select * from rozgrywki where roz_id = :id limit 1", ['id' => $id]);
        if (!$results) abort(404);
        $league = $results[0];
        $results = DB::select("select * from rozgrywka_kluby rk join kluby k on rk.rk_klub=k.k_id where k_id = :id and rk_roz=:league_id limit 1", ['id' => $club_id, 'league_id'=>$id]);
        if (!$results) abort(404);
        $club = $results[0];
        $results = DB::select("select * from zawodnicy where z_id = :id limit 1", ['id' => $player_id]);
        if (!$results) abort(404);
        $player = $results[0];
        $delete = DB::delete("delete from klub_zawodnicy where kzaw_zaw = :player_id and kzaw_klub = :league_club_id limit 1", ['player_id' => $player_id, 'league_club_id'=>$club->rk_id]);
        if ($delete) {
            $message = 'Zawodnik '.$player->z_imie.' '.$player->z_nazwisko.' został usunięty z tego klubu.';
            $request->session()->put('message', $message);
        }
        return redirect(route("dashboard.leagues.clubs.players", ["id"=>$id,"club_id"=>$club_id]));
    }

}