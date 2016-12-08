<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardPlayerController extends Controller {

    public function index(Request $request) {
        $message = $request->session()->pull('message');
        $players = DB::select("SELECT z.*, p.p_nazwa as panstwo_nazwa FROM zawodnicy z JOIN panstwa p ON z.z_panstwo=p.p_id ORDER BY z.z_nazwisko, z.z_imie");
        return view('dashboard.players.index', [
            'message' => $message,
            'players' => $players
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
        $title = "Dodaj nowego zawodnika";
        $player = [];
        if ($id) {
            $mode = "edytuj";
            $title = "Edytuj zawodnika";
            $results = DB::select("SELECT * FROM zawodnicy where z_id = :id limit 1", ['id' => $id]);
            if (!$results) abort(404);
            $player = $results[0];
        }
        $message = $request->session()->pull('message');
        $first_name = $player ? $player->z_imie : '';
        $last_name = $player ? $player->z_nazwisko : '';
        $country_id = $player ? $player->z_panstwo : NULL;
        $errors = [];
        if ($request->isMethod('post')) {
            $first_name = trim($request->input('first_name'));
            if (!$first_name) {
                $errors[] = 'Imię zawodnika jest obowiązkowe.';
            }
            $last_name = trim($request->input('last_name'));
            if (!$last_name) {
                $errors[] = 'Nazwisko zawodnika jest obowiązkowy.';
            }
            $country_id = (int)$request->input('country_id');
            if (!$country_id) $errors[] = 'Nie wybrano państwa.';
            if (count($errors) == 0) {
                if (!$player) {
                    $save = DB::insert('INSERT INTO zawodnicy (z_imie, z_nazwisko, z_panstwo) VALUES (?, ?, ?)', [$first_name, $last_name, $country_id]);
                    $message = 'Zawodnik '.$first_name.' '.$last_name.' został dodany. Możesz teraz dodać kolejnego.';
                } else {
                    $save = DB::update('UPDATE zawodnicy SET z_imie = :first_name, z_nazwisko = :last_name, z_panstwo = :country_id WHERE z_id = :id LIMIT 1', [
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'country_id' => $country_id,
                        'id' => $player->z_id
                    ]);
                    $message = 'Zapisano zmiany.';
                }
                if ($save) {
                    $request->session()->put('message', $message);
                    return redirect($request->getUri());
                }
            }
        }
        $countries = DB::select("SELECT * FROM panstwa ORDER BY p_nazwa");
        return view('dashboard.players.addOrEdit', [
            'mode' => $mode,
            'title' => $title,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'country_id' => $country_id,
            'countries' => $countries,
            'errors' => $errors,
            'url' => $request->getUri(),
            'message' => $message
        ]);
    }

    public function delete(Request $request, $id) {
        $results = DB::select("SELECT * FROM zawodnicy WHERE z_id = :id limit 1", ['id' => $id]);
        if (!$results) abort(404);
        $delete = DB::delete("DELETE FROM zawodnicy WHERE z_id = :id limit 1", ['id' => $id]);
        if ($delete) {
            $message = 'Zawodnik '.$results[0]->z_imie.' '.$results[0]->z_nazwisko.' został usunięty.';
            $request->session()->put('message', $message);
        }
        return redirect(route("dashboard.players"));
    }

}