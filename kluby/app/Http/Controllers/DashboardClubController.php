<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardClubController extends Controller {

    public function index(Request $request) {
        $message = $request->session()->pull('message');
        $clubs = DB::select("SELECT k.*, p.p_nazwa as panstwo_nazwa FROM kluby k JOIN panstwa p ON k.k_panstwo=p.p_id ORDER BY k.k_nazwa");
        return view('dashboard.clubs.index', [
            'message' => $message,
            'clubs' => $clubs
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
        $title = "Dodaj nowy klub";
        $club = [];
        if ($id) {
            $mode = "edytuj";
            $title = "Edytuj klub";
            $results = DB::select("SELECT * FROM kluby where k_id = :id limit 1", ['id' => $id]);
            if (!$results) abort(404);
            $club = $results[0];
        }
        $message = $request->session()->pull('message');
        $name = $club ? $club->k_nazwa : '';
        $country_id = $club ? $club->k_panstwo : NULL;
        $errors = [];
        if ($request->isMethod('post')) {
            $name = trim($request->input('name'));
            if (!$name) {
                $errors[] = 'Nazwa klubu jest obowiązkowe.';
            }
            $country_id = (int)$request->input('country_id');
            if (!$country_id) $errors[] = 'Nie wybrano państwa.';
            if (count($errors) == 0) {
                if (!$club) {
                    $save = DB::insert('INSERT INTO kluby (k_nazwa, k_panstwo) VALUES (?, ?)', [$name, $country_id]);
                    $message = 'Klub '.$name.' został dodany. Możesz teraz dodać kolejny.';
                } else {
                    $save = DB::update('UPDATE kluby SET k_nazwa = :name, k_panstwo = :country_id WHERE k_id = :id LIMIT 1', [
                        'name' => $name,
                        'country_id' => $country_id,
                        'id' => $club->k_id
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
        return view('dashboard.clubs.addOrEdit', [
            'mode' => $mode,
            'title' => $title,
            'name' => $name,
            'country_id' => $country_id,
            'countries' => $countries,
            'errors' => $errors,
            'url' => $request->getUri(),
            'message' => $message
        ]);
    }

    public function delete(Request $request, $id) {
        $results = DB::select("SELECT * FROM kluby WHERE k_id = :id limit 1", ['id' => $id]);
        if (!$results) abort(404);
        $delete = DB::delete("DELETE FROM kluby WHERE k_id = :id limit 1", ['id' => $id]);
        if ($delete) {
            $message = 'Klub '.$results[0]->k_nazwa.' został usunięty.';
            $request->session()->put('message', $message);
        }
        return redirect(route("dashboard.clubs"));
    }

}