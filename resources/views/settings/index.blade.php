@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
          <form action="/settings/save" method="post">
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
              </table>
            </div>
          </form>
  
          <button class="btn btn-success" type="button" id="save">
            Mentés
          </button>
          <div class="alert mb-0 mt-3" id="alert" style="display: none;"></div>
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
      url: '/settings/save',
      data: {
        id: {{Auth::user()->id}},
        name: $('#name').val(),
        email: $('#email').val(),
        phone: $('#phone').val(),
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
</script>

@endsection