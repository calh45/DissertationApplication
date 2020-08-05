@extends(Auth::user()->accountType == "P" ? 'layouts.playerSide' : 'layouts.managerSide')

<link rel="stylesheet" href={{ asset('css/matchStats.css') }}>
<script src={{ asset('js/matchStatistics.js') }}></script>


@section('content')
    @if($lineup === "null")
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">No Lineup Selected</div>

                        <div class="card-body">
                            No lineup for this match has been selected
                            <a href="{{ route("lineup", ["eventId" => $event->id]) }}">Please Assign a lineup first</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        @if($matchStatistic == null)
            <div class="eventContainer">
                @if($event->location == "(H)")
                    <div class="homeContainer"> {{ $event->team->club->clubName }} {{ $event->team->teamName }} </div>
                    <div class="homeScore" id="homeScore"></div>
                    <div class="scoreContainer" id="score"> - </div>
                    <div class="awayScore" id="awayScore"></div>
                    <div class="awayContainer"> {{ $event->name }} </div>
                @else
                    <div class="homeContainer"> {{ $event->name }} </div>
                    <div class="homeScore" id="homeScore"></div>
                    <div class="scoreContainer" id="score"> - </div>
                    <div class="awayScore" id="awayScore"></div>
                    <div class="awayContainer"> {{ $event->team->club->clubName }} {{ $event->team->teamName }} </div>
                @endif
            </div>

            @if(Auth::user()->accountType == "M" && \Carbon\Carbon::parse($event->task_date)->toDateString() === \Carbon\Carbon::now()->toDateString())
                <div class="timerContainer">
                    <p class="timer" id="timer"> Timer </p>
                    <button class="timerButton" id="timerButton" onclick="startTimer()">Start</button>
                </div>

            @endif

            <form method="POST" action="{{ route("stats.update", ["lineupId" => $event->id]) }}">
                @csrf
                <table>
                    <tr>
                        <td class="separator">
                            Goalkeepers
                        </td>
                    </tr>
                    <tr>
                        <td class="playerName">

                        </td>
                        <td class="attributeName">
                            YC
                        </td>
                        <td class="attributeName">
                            RC
                        </td>
                        <td class="attributeName">
                            Goals
                        </td>
                        <td class="attributeName">
                            Assists
                        </td>
                        <td class="attributeName">
                            Pass Attempted
                        </td>
                        <td class="attributeName">
                            Pass Completed
                        </td>
                        <td class="attributeName">
                            Fouls
                        </td>

                        <td class="attributeName">
                            Clean Sheet
                        </td>
                        <td class="attributeName">
                            Shot Faced
                        </td>
                        <td class="attributeName">
                            Shot Saved
                        </td>
                        <td class="attributeName">
                            Pen Faced
                        </td>
                        <td class="attributeName">
                            Pen Saved
                        </td>
                        <td class="attributeName">
                            Pen Conceded
                        </td>
                        <td class="attributeName">
                            Cross Claimed
                        </td>
                    </tr>

                    @foreach($players as $player)
                        @if($player != null)
                            @if($player->position === "GK")
                                <tr>
                                    <td class="playerName"> {{ $player->user->name }}</td>
                                    @foreach($playerStats as $playerStat)
                                        <td>
                                            <input class="statInput" type="number" id="{{ $player->id }}{{ $playerStat }}" name="{{ $player->id }}{{ $playerStat }}" min="0"
                                                   @if($playerStat == "yc") max = 2 @elseif($playerStat == "rc") max = 1 @endif>
                                        </td>
                                    @endforeach
                                    @foreach($gkStats as $gkStat)
                                        <td>
                                            <input class="statInput" type="number" id="{{ $player->id }}{{ $gkStat }}" name="{{ $player->id }}{{ $gkStat }}" min="0">
                                        </td>
                                    @endforeach
                                </tr>
                            @endif
                        @endif

                    @endforeach

                    <tr>
                        <td class="separator">
                            Defenders
                        </td>
                    </tr>

                    <tr>
                        <td class="playerName">

                        </td>
                        <td class="attributeName">
                            YC
                        </td>
                        <td class="attributeName">
                            RC
                        </td>
                        <td class="attributeName">
                            Goals
                        </td>
                        <td class="attributeName">
                            Assists
                        </td>
                        <td class="attributeName">
                            Pass Attempted
                        </td>
                        <td class="attributeName">
                            Pass Completed
                        </td>
                        <td class="attributeName">
                            Fouls
                        </td>

                        <td class="attributeName">
                            Clean Sheet
                        </td>
                        <td class="attributeName">
                            Header Won
                        </td>
                        <td class="attributeName">
                            Header Lost
                        </td>
                        <td class="attributeName">
                            Tackle Attempted
                        </td>
                        <td class="attributeName">
                            Tackle Won
                        </td>
                        <td class="attributeName">
                            Shot Blocked
                        </td>
                        <td class="attributeName">
                            Pen Conceded
                        </td>
                    </tr>

                    @foreach($players as $player)
                        @if($player != null)
                            @if($player->position === "DF")
                                <tr>
                                    <td class="playerName"> {{ $player->user->name }}</td>
                                    @foreach($playerStats as $playerStat)
                                        <td>
                                            <input class="statInput" type="number" id="{{ $player->id }}{{ $playerStat }}" name="{{ $player->id }}{{ $playerStat }}" min="0"
                                                   @if($playerStat == "yc") max = 2 @elseif($playerStat == "rc") max = 1 @endif>
                                        </td>
                                    @endforeach
                                    @foreach($dfStats as $dfStat)
                                        <td>
                                            <input class="statInput" type="number" id="{{ $player->id }}{{ $dfStat }}" name="{{ $player->id }}{{ $dfStat }}" min="0">
                                        </td>
                                    @endforeach
                                </tr>
                            @endif

                        @endif
                    @endforeach

                    <tr>
                        <td class="separator">
                            Midfielders
                        </td>
                    </tr>

                    <tr>
                        <td class="playerName">

                        </td>
                        <td class="attributeName">
                            YC
                        </td>
                        <td class="attributeName">
                            RC
                        </td>
                        <td class="attributeName">
                            Goals
                        </td>
                        <td class="attributeName">
                            Assists
                        </td>
                        <td class="attributeName">
                            Pass Attempted
                        </td>
                        <td class="attributeName">
                            Pass Completed
                        </td>
                        <td class="attributeName">
                            Fouls
                        </td>

                        <td class="attributeName">
                            Tackle Attempted
                        </td>
                        <td class="attributeName">
                            Tackle Won
                        </td>
                        <td class="attributeName">
                            Dribble Attempted
                        </td>
                        <td class="attributeName">
                            Successful Dribble
                        </td>
                        <td class="attributeName">
                            Chance Created
                        </td>
                        <td class="attributeName">
                            Shots
                        </td>
                        <td class="attributeName">
                            Shots On Target
                        </td>

                    </tr>

                    @foreach($players as $player)
                        @if($player != null)
                            @if($player->position === "MF")
                                <tr>
                                    <td class="playerName"> {{ $player->user->name }}</td>
                                    @foreach($playerStats as $playerStat)
                                        <td>
                                            <input class="statInput" type="number" id="{{ $player->id }}{{ $playerStat }}" name="{{ $player->id }}{{ $playerStat }}" min="0"
                                            @if($playerStat == "yc") max = 2 @elseif($playerStat == "rc") max = 1 @endif>
                                        </td>
                                    @endforeach
                                    @foreach($mfStats as $mfStat)
                                        <td>
                                            <input class="statInput" type="number" id="{{ $player->id }}{{ $mfStat }}" name="{{ $player->id }}{{ $mfStat }}" min="0">
                                        </td>
                                    @endforeach
                                </tr>
                            @endif

                        @endif

                    @endforeach

                    <tr>
                        <td class="separator">
                            Forwards
                        </td>
                    </tr>
                    <tr>
                        <td class="playerName">

                        </td>
                        <td class="attributeName">
                            YC
                        </td>
                        <td class="attributeName">
                            RC
                        </td>
                        <td class="attributeName">
                            Goals
                        </td>
                        <td class="attributeName">
                            Assists
                        </td>
                        <td class="attributeName">
                            Pass Attempted
                        </td>
                        <td class="attributeName">
                            Pass Completed
                        </td>
                        <td class="attributeName">
                            Fouls
                        </td>

                        <td class="attributeName">
                            Chance Created
                        </td>
                        <td class="attributeName">
                            Shots
                        </td>
                        <td class="attributeName">
                            Shots On Target
                        </td>
                        <td class="attributeName">
                            Headed Goal
                        </td>
                        <td class="attributeName">
                            Pen Taken
                        </td>
                        <td class="attributeName">
                            Pen Scored
                        </td>
                    </tr>

                    @foreach($players as $player)
                        @if($player != null)
                            @if($player->position === "FW")
                                <tr>
                                    <td class="playerName"> {{ $player->user->name }}</td>
                                    @foreach($playerStats as $playerStat)
                                        <td>
                                            <input class="statInput" type="number" id="{{ $player->id }}{{ $playerStat }}" name="{{ $player->id }}{{ $playerStat }}" min="0"
                                                   @if($playerStat == "yc") max = 2 @elseif($playerStat == "rc") max = 1 @endif>
                                        </td>
                                    @endforeach
                                    @foreach($fwStats as $fwStat)
                                        <td>
                                            <input class="statInput" type="number" id="{{ $player->id }}{{ $fwStat }}" name="{{ $player->id }}{{ $fwStat }}" min="0">
                                        </td>
                                    @endforeach
                                </tr>
                            @endif

                        @endif

                    @endforeach

                </table>

                <div class="submitButton">
                    <button type="submit">Submit</button>
                </div>
            </form>
        @else
            <td>Statistics for this match have been collected</td>
        @endif

    @endif

@endsection
