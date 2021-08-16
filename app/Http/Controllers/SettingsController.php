<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class SettingsController extends Controller
{
  public function __construct() {
    $this->middleware('auth');
  }

  public function index() {
    $user = Auth::user();

    return view('settings.index', [
      'user' => $user
    ]);
  }

  public function save(Request $request) {
    $user = User::find($request->id);
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;

    if ($user->save()) {
      $return = [
        'type' => 'success',
        'text' => 'Az adatok sikeresen elmentve!',
      ];
    } else {
      $return = [
        'type' => 'danger',
        'text' => 'Hiba lépett fel a mentés során!',
      ];
    }
    
    return Response::json($return);
  }
}
