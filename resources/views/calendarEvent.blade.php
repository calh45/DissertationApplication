@extends(Auth::user()->accountType == "P" ? 'layouts.playerSide' : 'layouts.managerSide')

<link rel="stylesheet" href={{ asset('css/calendar.css') }} >

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $event->name }}</div>

                    <div class="card-body">
                        <table>
                            <tr>
                                <td class="focusedEventName">
                                    Opponent:
                                    {{ $event->name }}
                                </td>

                                <td>
                                    Location:
                                    {{ $event->location }}
                                </td>
                            </tr>
                            <tr>
                                <td class="focusedEventName">
                                    Date:
                                    {{ \Carbon\Carbon::parse($event->task_date)->day }}
                                    {{ \Carbon\Carbon::parse($event->task_date)->month }}
                                    {{ \Carbon\Carbon::parse($event->task_date)->year }}
                                </td>

                                @if(Auth::user()->accountType == "P")
                                    <td class="availability">
                                        <form method="POST" action="{{ route("availability.create", ["id" => $event->id]) }}">
                                            @csrf
                                            <label for="availableChoice">Availability: </label>
                                            <select name="availableChoice" id="availableChoice">
                                                <option value="available" id="availableOption" name="availableOption">Available</option>
                                                <option value="unavailable" id="unavailableOption" name="unavailableOption">Unavailable</option>
                                            </select>
                                            <button type="submit">Confirm</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>

                            <tr>
                                <td class="unavailableList">
                                    <div class="unavailableHeader">
                                        Unavailable
                                    </div>
                                    @foreach($unavailable as $thisUnavailable)
                                        <div>{{ $thisUnavailable->user->name }}</div>
                                    @endforeach
                                </td>

                                @if($event->task_date <= \Carbon\Carbon::now())
                                    <td class="matchStats">
                                        <div class="matchStatsHeader">
                                            <a class="links" href="{{ route("matchStats", ["id" => $event->id]) }}">
                                                Match Statistics
                                            </a>
                                        </div>

                                    </td>
                                @endif

                            </tr>

                            <tr>
                                <td class="lineupList">
                                    @if(Auth::user()->accountType == "M")
                                        <a class="links" href="{{ route("lineup", ["eventId" => $event->id]) }}">
                                            <div class="lineupHeader">Lineup</div>
                                        </a>
                                    @else
                                        <div class="lineupHeader">Lineup</div>
                                    @endif

                                    @if($lineup === "null")
                                        <div>Not yet announced</div>

                                    @else
                                        @foreach($positions as $position)
                                            @if($position == "12")
                                                <br>
                                                <div class="lineupHeader">Subs </div>
                                            @endif
                                            <div> {{ $position }} :
                                                @if($players[((int)$position - 1)] != null)
                                                    @if(Auth::user()->accountType == "M")
                                                        <a href="/players/{{ $players[((int)$position - 1)]->player->id }}">
                                                            {{ $players[((int)$position - 1)]->name }}
                                                        </a>
                                                    @else
                                                        {{ $players[((int)$position - 1)]->name }}
                                                    @endif
                                                @else
                                                    None
                                                @endif




                                            </div>
                                        @endforeach


                                </td>

                                <td>
                                    <img src="{{ $lineup->formation }}">
                                </td>

                                @endif
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>


@endsection