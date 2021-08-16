<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Vehicle;

class WorkerController extends Controller
{
  public function __construct() {
    $this->middleware('auth');
    /*if (!Auth::user()->admin) {
      return redirect('/');
    }*/
  }

  public function index() {
    if (!Auth::user()->admin) {
      return redirect('/');
    }

    $users = User::simplePaginate(5);

    return view('workers.index', [
      'users' => $users
    ]);
  }

  public function details($id) {
    $user = User::find($id);
    $vehicles = Vehicle::where('user', $id)->simplePaginate(5);

    return view('workers.details', [
      'user' => $user,
      'vehicles' => $vehicles,
    ]);
  }

  public function save($id, Request $request) {
    $user = User::find($id);
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->admin = $request->admin;
    $user->status = $request->status;
    
    if ($user->save()) {
      $return = [
        'type' => 'success',
        'text' => 'Felhasználó adatai sikeresen mentve!'
      ];
    } else {
      $return = [
        'type' => 'danger',
        'text' => 'Hiba lépett fel a mentés során!'
      ];
    }
    return Response::json($return);
  }

  public function delete($id) {
    $user = User::find($id);
    if ($user->delete()) {
      $return = [
        'type' => 'success',
        'name' => $user->name
      ];
    } else {
      $return = [
        'type' => 'danger',
        'text' => 'Hiba lépett fel a törlés során!',
      ];
    }
    return Response::json($return);
  }
}
