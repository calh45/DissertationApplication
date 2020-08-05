@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }} Manager</div>

                <div class="card-body">
                    @if($errors->any())
                        <div style="right: 50%; color: red; text-underline: whitesmoke"><u>{{$errors->first()}}</u></div>
                    @endif
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form_group row">
                            <label for="teamIdCode" class="col-md-4 col-form-label text-md-right">Team ID Code: </label>
                            <div class="col-md-6">
                                <input id="teamId" type="number" class="form-control" name="teamId" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Register Player</div>

                <div class="card-body">
                    @if($errors->any())
                        <div style="right: 50%; color: red; text-underline: whitesmoke"><u>{{$errors->first()}}</u></div>
                    @endif
                    <form method="POST" action="{{ route("playerRegister") }}">
                        @csrf

                        <div class="form-group row">
                            <label for="playerName" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="playerName" type="text" class="form-control @error('playerName') is-invalid @enderror" name="playerName" value="{{ old('playerName') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="playerEmail" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="playerEmail" type="email" class="form-control @error('playerEmail') is-invalid @enderror" name="playerEmail" value="{{ old('playerEmail') }}" required autocomplete="email">

                                @error('playerEmail')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="playerPassword" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="playerPassword" type="password" class="form-control @error('playerPassword') is-invalid @enderror" name="playerPassword" required autocomplete="new-password">

                                @error('playerPassword')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="playerPassword-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="playerPassword-confirm" type="password" class="form-control" name="playerPassword_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form_group row">
                            <label for="playerTeamId" class="col-md-4 col-form-label text-md-right">Team ID Code: </label>
                            <div class="col-md-6">
                                <input id="playerTeamId" type="number" class="form-control" name="playerTeamId" required>
                            </div>
                        </div>

                        <div class="form_group row">
                            <label for="playerPosition" class="col-md-4 col-form-label text-md-right">Position </label>
                            <div class="col-md-6">
                                <input id="playerPosition" type="text" class="form-control" name="playerPosition" required>
                            </div>
                        </div>

                        <div class="form_group row">
                            <label for="playerAge" class="col-md-4 col-form-label text-md-right">Age </label>
                            <div class="col-md-6">
                                <input id="playerAge" type="number" class="form-control" name="playerAge" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
