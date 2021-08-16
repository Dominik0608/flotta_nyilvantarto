@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
      <div class="col-md-8">
        @if (app('request')->input('delete'))
          <div class="alert alert-success">
            <strong>{{app('request')->input('delete')}}</strong> nevű felhasználó sikeresen törölve!
          </div>
        @endif
        <div class="table-responsive">
          <table class="table">
            <tr>
              <th>Név</th>
              <th>E-mail</th>
              <th>Telefon</th>
              <th>Admin</th>
              <th>Státusz</th>
              <th style="width: 0;"></th>
              <th style="width: 0;"></th>
            </tr>
            @foreach ($users as $user)
              <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->phone}}</td>
                <td>{{$user->admin == 1 ? "Igen" : "Nem"}}</td>
                <td>{{$user->status == 1 ? "Aktív" : "Inaktív"}}</td>
                <td><a class="btn btn-primary" href="/workers/{{$user->id}}">Részletek</a></td>
                <td><a class="btn btn-danger" href="/workers/{{$user->id}}/delete">Törlés</a></td>
              </tr>
            @endforeach
          </table>
          
        </div>
        @if ($users->links())
          {{$users->links()}}
        @endif
      </div>
    </div>
</div>
@endsection