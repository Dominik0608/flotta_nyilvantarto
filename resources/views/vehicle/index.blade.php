@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
          @if (app('request')->input('delete') == "success")
            <div class="alert alert-success">
              Jármű sikeresen törölve!
            </div>
          @endif
          <p>
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#addVehicleForm">
              Jármű hozzáadása
            </button>
          </p>
          <div class="collapse" id="addVehicleForm">
            <div class="card">
            <div class="card-header">Jármű hozzáadása</div>
              <div class="card-body">
                @include('vehicle.form')
              </div>
            </div>
          </div>
          @include('vehicle.list')
        </div>
    </div>
</div>
@endsection