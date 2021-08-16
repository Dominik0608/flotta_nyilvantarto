<form action="/vehicles" method="GET">
  <div class="row mt-3">
    <div class="col-md-3">
      Autó típus
      <input type="text" name="brand" class="form-control" value="{{app('request')->input('brand')}}">
    </div>
    <div class="col-md-3">
      Rendszám
      <input type="text" name="plate" class="form-control" value="{{app('request')->input('plate')}}">
    </div>
    @if (Auth::user()->admin)
    <div class="col-md-3">
      Munkatárs
      <select id="user" name="user" class="form-control">
        <option value="" {{app('request')->input('user') == "" ? "selected" : ""}}>Mindenki</option>
        @foreach ($users as $user)
          <option value="{{$user->id}}" {{app('request')->input('user') == "$user->id" ? "selected" : ""}}>{{$user->name}}</option>
        @endforeach
      </select>
    </div>
    @endif
    <div class="col-md-3">
      <button class="btn btn-primary mt-4" type="submit">Keresés</button>
    </div>
  </div>
</form>
<div class="table-responsive">
  <table class="table">
    <tr>
      <th>Munkatárs</th>
      <th>Autó típusa</th>
      <th>Rendszám</th>
      <th>Km óra állás</th>
      <th>Évjárat</th>
      <th style="width: 0;"></th>
    </tr>
    @foreach ($vehicles as $vehicle)
      <tr>
        <td>{{$vehicle->name}}</td>
        <td>{{$vehicle->brand}}</td>
        <td>{{$vehicle->plate}}</td>
        <td>{{$vehicle->mileage}}</td>
        <td>{{$vehicle->year}}</td>
        <td><a class="btn btn-primary" href="/vehicles/{{$vehicle->id}}">Részletek</a></td>
      </tr>
    @endforeach
  </table>
  
</div>
@if ($vehicles->links())
  {{$vehicles->links()}}
@endif