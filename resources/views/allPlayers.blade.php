@extends(Auth::user()->accountType == "P" ? 'layouts.playerSide' : 'layouts.managerSide')

<link rel="stylesheet" href={{ asset('css/allPlayers.css') }} >

@section('content')

<div class="tableContainer">
    <table class="allPlayersTable">
        <tr>
            <td>

            </td>

            @foreach($columns as $column)
                <td>
                    <a class="text-decoration-none" href="{{ route("allPlayers", ["toOrder" => $column]) }}">
                        <b>{{ $column }}</b>
                    </a>
                </td>
            @endforeach

        </tr>

        @foreach($players as $player)
            <tr class="allPlayerHolder">
                <td>
                    {{ $player->user->name }}
                </td>

                @foreach($columnLabels as $columnLabel)
                    @if($columnLabel == "totalScore")
                        <td>
                            {{ number_format($player->$columnLabel, "2", ".", "") }}
                        </td>
                    @else
                        <td>
                            {{ $player->$columnLabel }}
                        </td>
                    @endif

                @endforeach
            </tr>


        @endforeach
    </table>

</div>
@endsection