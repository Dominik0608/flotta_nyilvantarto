@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-8">
      @if ($permission)
        <table class="table">
          <tr>
            <td>Típus</td>
            <td><input type="text" id="brand" value="{{$vehicle->brand}}" class="form-control" disabled required></td>
          </tr>
          <tr>
            <td>Rendszám</td>
            <td><input type="text" id="plate" value="{{$vehicle->plate}}" class="form-control" disabled required></td>
          </tr>
          <tr>
            <td>Km óra állás</td>
            <td><input type="text" id="mileage" value="{{$vehicle->mileage}}" class="form-control" disabled required maxlength="7"></td>
          </tr>
          <tr>
            <td>Évjárat</td>
            <td><input type="text" id="year" value="{{$vehicle->year}}" class="form-control" disabled required maxlength="4"></td>
          </tr>
          <tr>
            <td>Státusz</td>
            <td>
              <select id="status" class="form-control" disabled>
                <option value="1" {{$vehicle->status == 1 ? "selected" : ""}}>Aktív</option>
                <option value="0" {{$vehicle->status == 0 ? "selected" : ""}}>Inaktív</option>
              </select>
            </td>
          </tr>
          @if (Auth::user()->admin)
            <tr>
              <td>Munkatárs</td>
              <td>
                <select id="user" class="form-control" disabled>
                  @foreach ($users as $user)
                    <option value="{{$user->id}}" {{$vehicle->user == $user->id ? "selected" : ""}}>{{$user->name}}</option>
                  @endforeach
                </select>
              </td>
            </tr>
          @endif
        </table>
        <button class="btn btn-primary" type="button" id="edit">
          Módosítás
        </button>
        <button class="btn btn-success" type="button" id="save" style="display: none;">
          Mentés
        </button>
        <button class="btn btn-danger" type="button" id="delete" style="float: right;">
          Törlés
        </button>
        <div class="alert mb-0 mt-3" id="alert" style="display: none;"></div>
      @else
        <div class="alert alert-danger">
          Nincs jogosultságod a jármű megtekintéséhez!
        </div>
        <a class="btn btn-primary" href="/vehicles">
          Vissza
        </a>
      @endif
    </div>
  </div>
</div>

<script>
  $("#mileage").bind('keyup paste', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  $("#year").bind('keyup paste', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  $("#edit").click(function() {
    $("#edit").hide();
    $("#save").show();

    $("#brand").prop("disabled", false);
    $("#plate").prop("disabled", false);
    $("#mileage").prop("disabled", false);
    $("#year").prop("disabled", false);
    $("#status").prop("disabled", false);
    $("#user").prop("disabled", false);
  });

  $("#save").click(function() {
    $("#save").append('<span class="spinner-border spinner-border-sm"></span>');
    $("#save").prop("disabled", true);
    
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      type: 'POST',
      url: window.location.href, // /vehicles/{id}
      data: {
        brand: $('#brand').val(),
        plate: $('#plate').val(),
        mileage: $('#mileage').val(),
        year: $('#year').val(),
        status: $('#status').val(),
        user: $('#user').val() ?? 0,
      },
      success: function (data) {
        $('#alert').text(data.text);
        $('#alert').removeClass('alert-danger');
        $('#alert').removeClass('alert-success');
        $('#alert').addClass('alert-' + data.type);
        $('#alert').show();

        $("#save").hide();
        $("#edit").show();
        $("#save .spinner-border").remove();
        $("#save").prop("disabled", false);

        $("#brand").prop("disabled", true);
        $("#plate").prop("disabled", true);
        $("#mileage").prop("disabled", true);
        $("#year").prop("disabled", true);
        $("#status").prop("disabled", true);
        $("#user").prop("disabled", true);
      },
      error: function (data) {
        $('#alert').text('Hiba lépett fel a mentés során!');
        $('#alert').removeClass('alert-success');
        $('#alert').addClass('alert-danger');
        $('#alert').show();
      }
    });
  });

  $("#delete").click(function() {
    console.log('delete');
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      type: 'POST',
      url: window.location.href + '/delete', // /vehicles/{id}/delete
      data: {
        user_id: "{{Auth::user()->id}}"
      },
      success: function (data) {
        $('#alert').text(data.text);
        $('#alert').removeClass('alert-danger');
        $('#alert').removeClass('alert-success');
        $('#alert').addClass('alert-' + data.type);
        $('#alert').show();

        if (data.type == "success") {
          window.location.href = "/vehicles?delete=success";
        }
      },
      error: function (data) {
        $('#alert').text('Hiba lépett fel a törlés során!');
        $('#alert').addClass('alert-error');
        $('#alert').show();
      }
    });
  });
</script>
@endsection