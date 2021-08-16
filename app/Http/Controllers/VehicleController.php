<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Vehicle;

class VehicleController extends Controller
{
  public function __construct() {
    $this->middleware('auth');
  }

  public function index(Request $request) {
    if (Auth::user()->admin) {
      $users = User::all();
    }
    
    return view('vehicle.index', [
      'users' => $users ?? false,
      'vehicles' => $this->getVehicles($request->brand, $request->plate, $request->user),
    ]);
  }

  public function getVehicles($brand, $plate, $user) {
    $vehicles = Vehicle::select(['vehicles.*', 'users.name'])->leftJoin('users', 'users.id', '=', 'vehicles.user');
    
    if (!Auth::user()->admin) {
      $vehicles = $vehicles->where('user', Auth::user()->id);
    }

    if ($brand) {
      $vehicles = $vehicles->where('brand', 'like', '%' . $brand . '%');
    }

    if ($plate) {
      $vehicles = $vehicles->where('plate', 'like', '%' . $plate . '%');
    }

    if ($user) {
      $vehicles = $vehicles->where('user', $user);
    }

    $vehicles = $vehicles->simplePaginate(5)->appends(request()->input());
    return $vehicles ?? [];
  }

  public function store(Request $request) {
    $vehicle = new Vehicle;
    $vehicle->brand = $request->brand;
    $vehicle->plate = $request->plate;
    $vehicle->year = $request->year;
    $vehicle->mileage = $request->mileage;
    $vehicle->status = $request->status;
    $vehicle->user = $request->user ? $request->user : Auth::user()->id;
    $result = $vehicle->save();

    if ($result) {
      $return = [
        'type' => 'success',
        'text' => 'Jármű sikeresen rögzítve!'
      ];
    } else {
      $return = [
        'type' => 'danger',
        'text' => 'Hiba lépett fel a rögzítés során!'
      ];
    }
    return Response::json($return);
  }

  public function details($id) {
    $vehicle = Vehicle::find($id);
    if (!$vehicle) {
      return redirect('/vehicles');
    }

    if (Auth::user()->admin) {
      $users = User::all();
    } else {
      $users = array(Auth::user());
    }
    
    return view('vehicle.details', [
      'vehicle' => $vehicle,
      'users' => $users,
      'permission' => (Auth::user()->admin || (Auth::user()->id == $vehicle->user))
    ]);
  }

  public function save($id, Request $request) {
    $vehicle = Vehicle::find($id);
    $vehicle->brand = $request->brand;
    $vehicle->plate = $request->plate;
    $vehicle->year = $request->year;
    $vehicle->mileage = $request->mileage;
    $vehicle->status = $request->status;
    if (Auth::user()->admin) {
      $vehicle->user = $request->user;
    }
    $result = $vehicle->save();

    if ($result) {
      $return = [
        'type' => 'success',
        'text' => 'Jármű sikeresen módosítva!'
      ];
    } else {
      $return = [
        'type' => 'danger',
        'text' => 'Hiba lépett fel a módosítás során!'
      ];
    }
    return Response::json($return);
  }

  public function delete($id, Request $request) {
    $user = User::find($request->user_id);
    $vehicle = Vehicle::find($id);

    if (!$user || !$vehicle) {
      $return = [
        'type' => 'danger',
        'text' => 'Ismeretlen felhasználó vagy jármű!'
      ];
    } elseif ($user->admin == 0 && $user->id != $vehicle->user) {
      $return = [
        'type' => 'danger',
        'text' => 'Nincs jogosultságod a jármű törlésére!'
      ];
    }

    if ($vehicle->delete()) {
      $return = [
        'type' => 'success',
        'text' => 'Jármű sikeresen törölve!'
      ];
    }
    
    return Response::json($return);
  }
}
