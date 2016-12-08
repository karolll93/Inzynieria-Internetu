<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardCountryController extends Controller {

    public function index(Request $request) {
        $message = $request->session()->pull('message');
        $countries = DB::select("select * from panstwa order by p_nazwa");
        return view('dashboard.countries.index', [
            'message' => $message,
            'countries' => $countries
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
        $title = "Dodaj nowe państwo";
        $country = [];
        if ($id) {
            $mode = "edytuj";
            $title = "Edytuj państwo";
            $results = DB::select("select * from panstwa where p_id = :id limit 1", ['id' => $id]);
            if (!$results) abort(404);
            $country = $results[0];
        }
        $message = $request->session()->pull('message');
        $name = $country ? $country->p_nazwa : '';
        $short = $country ? $country->p_skrot : '';
        $errors = [];
        if ($request->isMethod('post')) {
            $name = trim($request->input('name'));
            if (!$name) {
                $errors[] = 'Nazwa państwa jest obowiązkowa.';
            }
            $short = trim($request->input('short'));
            if (!$short) {
                $errors[] = 'Skrót państwa jest obowiązkowy.';
            }
            if (count($errors) == 0) {
                if (!$country) {
                    $save = DB::insert('insert into panstwa (p_nazwa, p_skrot) values (?, ?)', [$name, $short]);
                    $message = 'Państwo '.$name.' zostało dodane. Możesz teraz dodać kolejne.';
                } else {
                    $save = DB::update('update panstwa set p_nazwa = :name, p_skrot = :short where p_id = :id', [
                        'name' => $name,
                        'short' => $short,
                        'id' => $country->p_id
                    ]);
                    $message = 'Zapisano zmiany.';
                }
                if ($save) {
                    $request->session()->put('message', $message);
                    return redirect($request->getUri());
                }
            }
        }
        return view('dashboard.countries.addOrEdit', [
            'mode' => $mode,
            'title' => $title,
            'name' => $name,
            'short' => $short,
            'errors' => $errors,
            'url' => $request->getUri(),
            'message' => $message
        ]);
    }

    public function delete(Request $request, $id) {
        $results = DB::select("select * from panstwa where p_id = :id limit 1", ['id' => $id]);
        if (!$results) abort(404);
        $delete = DB::delete("delete from panstwa where p_id = :id limit 1", ['id' => $id]);
        if ($delete) {
            $message = 'Państwo '.$results[0]->p_nazwa.' zostało usunięte.';
            $request->session()->put('message', $message);
        }
        return redirect(route("dashboard.countries"));
    }

}