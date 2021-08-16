<form id="newVehicleForm">
  <div class="form-group row">
    <label for="brand" class="col-md-12 col-form-label text-md-right">Típus</label>
    <div class="col-md-12">
      <input id="brand" type="text" class="form-control" required>
    </div>
  </div>

  <div class="form-group row">
    <label for="plate" class="col-md-12 col-form-label text-md-right">Rendszám</label>
    <div class="col-md-12">
      <input id="plate" type="text" class="form-control" required>
    </div>
  </div>

  <div class="form-group row">
    <label for="mileage" class="col-md-12 col-form-label text-md-right">Km óra állás</label>
    <div class="col-md-12">
      <input id="mileage" type="text" class="form-control" required maxlength="7">
    </div>
  </div>

  <div class="form-group row">
    <label for="year" class="col-md-12 col-form-label text-md-right">Évjárat</label>
    <div class="col-md-12">
      <input id="year" type="text" class="form-control" required maxlength="4">
    </div>
  </div>

  <div class="form-group row">
    <label for="status" class="col-md-12 col-form-label text-md-right">Státusz</label>
    <div class="col-md-12">
      <select id="status" class="form-control">
        <option value="1">Aktív</option>
        <option value="0">Inaktív</option>
      </select>
    </div>
  </div>

  @if ($users)
    <div class="form-group row">
      <label for="user" class="col-md-12 col-form-label text-md-right">Kezelő</label>
      <div class="col-md-12">
        <select id="user" class="form-control">
          @foreach ($users as $user)
            <option value="{{$user->id}}">{{$user->name}}</option>
          @endforeach
        </select>
      </div>
    </div>
  @endif

  <div class="form-group row mb-0 mt-3">
    <div class="col-md-12 d-flex justify-content-center">
      <button type="submit" class="btn btn-primary">
        Rögzítés
      </button>
    </div>
  </div>

  <div class="alert mb-0 mt-3" id="alert" style="display: none;"></div>
</form>

<script>
  $("#mileage").bind('keyup paste', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  $("#year").bind('keyup paste', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  $("#newVehicleForm").submit(function(event) {
    event.preventDefault();

    $('#alert').hide();
    $('#alert').removeClass('alert-succes alert-error');

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      type: 'POST',
      url: '/vehicles/add',
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
        $('#alert').addClass('alert-' + data.type);
        $('#alert').show();

        $('#brand').val('');
        $('#plate').val('');
        $('#mileage').val('');
        $('#year').val('');
      },
      error: function (data) {
        $('#alert').text('Hiba lépett fel a rögzítés során!');
        $('#alert').addClass('alert-error');
        $('#alert').show();
      }
    });
  });
</script>