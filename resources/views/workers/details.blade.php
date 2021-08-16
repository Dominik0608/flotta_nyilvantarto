@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
      <div class="col-md-8">
        <form action="/workers/{{$user->id}}" method="post">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td>Név</td>
                <td><input type="text" id="name" class="form-control" value="{{$user->name}}" required maxlength="40"></td>
              </tr>
              <tr>
                <td>E-mail</td>
                <td><input type="text" id="email" class="form-control" value="{{$user->email}}" required maxlength="100"></td>
              </tr>
              <tr>
                <td>Telefon</td>
                <td><input type="text" id="phone" class="form-control" value="{{$user->phone}}" maxlength="20"></td>
              </tr>
              <tr>
                <td>Admin</td>
                <td>
                  <select id="admin" class="form-control">
                    <option value="1" {{$user->admin == 1 ? "selected" : ""}}>Igen</option>
                    <option value="0" {{$user->admin == 0 ? "selected" : ""}}>Nem</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Státusz</td>
                <td>
                  <select id="status" class="form-control">
                    <option value="1" {{$user->status == 1 ? "selected" : ""}}>Aktív</option>
                    <option value="0" {{$user->status == 0 ? "selected" : ""}}>Inaktív</option>
                  </select>
                </td>
              </tr>
            </table>
          </div>
        </form>

        <button class="btn btn-success" type="button" id="save">
          Mentés
        </button>
        <button class="btn btn-danger" type="button" id="delete" style="float: right;">
          Törlés
        </button>
        <div class="alert mb-0 mt-3" id="alert" style="display: none;"></div>

        <h2 class="text-center mt-4 mb-2">{{$user->name}} járművei</h2>
        <div class="table-responsive">
          <table class="table">
            <tr>
              <th>Típus</th>
              <th>Rendszám</th>
              <th>Km óra állás</th>
              <th>Évjárat</th>
            </tr>
            @foreach ($vehicles as $vehicle)
              <tr>
                <td>{{$vehicle->brand}}</td>
                <td>{{$vehicle->plate}}</td>
                <td>{{$vehicle->mileage}}</td>
                <td>{{$vehicle->year}}</td>
              </tr>
            @endforeach
          </table>
        </div>
      </div>
    </div>
</div>

<script>
  $("#save").click(function() {
    $("#alert").hide();
    $("#save").append('<span class="spinner-border spinner-border-sm"></span>');
    $("#save").prop("disabled", true);
    
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      type: 'POST',
      url: window.location.href + '/save', // /workers/{id}/save
      data: {
        name: $('#name').val(),
        email: $('#email').val(),
        phone: $('#phone').val(),
        admin: $('#admin').val(),
        status: $('#status').val(),
      },
      success: function (data) {
        $('#alert').text(data.text);
        $('#alert').removeClass('alert-danger');
        $('#alert').removeClass('alert-success');
        $('#alert').addClass('alert-' + data.type);
        $('#alert').show();

        $("#save .spinner-border").remove();
        $("#save").prop("disabled", false);
      },
      error: function (data) {
        $('#alert').text('Hiba lépett fel a mentés során!');
        $('#alert').removeClass('alert-success');
        $('#alert').addClass('alert-danger');
        $('#alert').show();
        
        $("#save .spinner-border").remove();
        $("#save").prop("disabled", false);
      }
    });
  });

  $("#delete").click(function() {
    $("#alert").hide();
    $("#delete").append('<span class="spinner-border spinner-border-sm"></span>');
    $("#delete").prop("disabled", true);
    
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      type: 'POST',
      url: window.location.href + '/delete', // /workers/{id}/delete
      data: {},
      success: function (data) {
        if (data.type == "success") {
          window.location.href = "/workers?delete=" + data.name;
        }
      },
      error: function (data) {
        $('#alert').text('Hiba lépett fel a törlés során!');
        $('#alert').removeClass('alert-success');
        $('#alert').addClass('alert-danger');
        $('#alert').show();
        $("#delete .spinner-border").remove();
        $("#delete").prop("disabled", false);
      }
    });
  });
</script>

@endsection