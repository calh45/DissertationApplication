@extends('layouts.managerSide')

<link rel="stylesheet" href={{ asset('css/managerHomePage.css') }}>




@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Finances</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('finances.edit') }}">
                            @csrf
                            Yearly Fee: £
                            <input type="number" name="feeAmount" id="feeAmount" placeholder="{{ $team->subscription }}">

                            <button type="submit">Update</button>
                        </form>
                        Monthly Fee:    £{{ number_format(($team->subscription)/12, 2, '.', '') }} <br>
                        Weekly Fee:     £{{ number_format(($team->subscription)/52, 2, '.', '') }}
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection

