@extends('layouts.managerSide')

<link rel="stylesheet" href={{ asset('css/playerProfileM.css') }}>

@section("content")

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create Target</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('target.create', ["playerId" => $player->id]) }}">
                            @csrf
                            <label for="targetName">Target: </label>
                            <select id="targetName" name="targetName" required>
                                @foreach($options as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>

                                @endforeach
                            </select>

                            <label for="targetIncrement">% Increase: </label>
                            <select id="targetIncrement" name="targetIncrement" required>
                                @foreach($increments as $increment)
                                    <option value="{{ (int)$increment }}">{{ $increment }}</option>

                                @endforeach
                            </select>

                            <label for="endDate">End Date: </label>
                            <input type="date" name="endDate" id="endDate" required>

                            <button type="submit">Create</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection