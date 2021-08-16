@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-12 registration">
      <div class="card">
        <div class="card-header">Regisztráció</div>

        <div class="card-body">
          <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group row">
              <label for="name" class="col-md-12 col-form-label">Név</label>

              <div class="col-md-12">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus maxlength="40">

                @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="email" class="col-md-12 col-form-label">E-mail</label>

              <div class="col-md-12">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" maxlength="100">

                @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="password" class="col-md-12 col-form-label">Jelszó</label>

              <div class="col-md-12">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

                @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="phone" class="col-md-12 col-form-label">Telefon</label>

              <div class="col-md-12">
                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" maxlength="20">

                @error('phone')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="form-check mt-2">
              <input type="checkbox" class="form-check-input" id="aszf" name="aszf" required>
              <label class="form-check-label" for="aszf">Az ÁSZF-et elfogadom</label>
            </div>

            <div class="form-group row mb-0 mt-3">
              <div class="col-md-12 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">
                  Regisztráció
                </button>
              </div>
            </div>

            <div class="form-group row mb-0 mt-3">
              <div class="col-md-12 d-flex justify-content-center">
                <a href="/login" class="btn btn-primary">
                  Bejelentkezés
                </a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
