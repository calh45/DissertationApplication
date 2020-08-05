@extends('layouts.managerSide')

<link rel="stylesheet" href={{ asset('css/playerProfileM.css') }}>

@section('content')
    <div class="imageContainer">
        <img style="height: 20pc; width: 20pc" src="/images/{{ $player->user->profileImage }}">

    </div>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $player->user->name }}</div>

                    <div class="card-body">
                        <table>
                            <tr class="columnSpacing">
                                <td class="columnSpacing">
                                    Age: <br>
                                    {{ $player->age }}
                                </td>

                                <td class="columnSpacing">
                                    Position: <br>
                                    {{ $player->position }}
                                </td>
                            </tr>
                            <tr class="columnSpacing">
                                <td class="columnSpacing">
                                    Club: <br>
                                    {{ $player->club->clubName }}
                                </td>

                                <td class="columnSpacing">
                                    Team: <br>
                                    {{ $player->team->teamName }}
                                </td>
                            </tr>
                        </table>

                        <table class="statsTable">
                            <tr>
                                <td class="statsTableCR">
                                    <b>Appearances</b>
                                </td>
                                <td class="statsTableCR">
                                    <b>Yellow Cards</b>
                                </td>
                                <td class="statsTableCR">
                                    <b>Red Cards</b>
                                </td>
                                <td class="statsTableCR">
                                    <b>Goals</b>
                                </td>
                                <td class="statsTableCR">
                                    <b>Assists</b>
                                </td>
                                <td class="statsTableCR">
                                    <b>Passes Attempted</b>
                                </td>
                                <td class="statsTableCR">
                                    <b>Passes Completed</b>
                                </td>
                                <td class="statsTableCR">
                                    <b>Fouls</b>
                                </td>
                            </tr>

                            <tr>
                                <td class="statsTableCR">
                                    {{ $player->appearances }}
                                </td>
                                <td class="statsTableCR">
                                    {{ $player->yellowCards }}
                                </td>
                                <td class="statsTableCR">
                                    {{ $player->redCards }}
                                </td>
                                <td class="statsTableCR">
                                    {{ $player->goals }}
                                </td>
                                <td class="statsTableCR">
                                    {{ $player->assists }}
                                </td>
                                <td class="statsTableCR">
                                    {{ $player->passesAttempted }}
                                </td>
                                <td class="statsTableCR">
                                    {{ $player->passesCompleted }}
                                </td>
                                <td class="statsTableCR">
                                    {{ $player->fouls }}
                                </td>
                            </tr>
                        </table>

                        <table class="statsTable">
                            <tr>
                                @foreach($statLabels as $statLabel)
                                    <td class="statsTableCR">
                                        <b>{{ $statLabel }}</b>
                                    </td>
                                @endforeach
                            </tr>

                            <tr>
                                @foreach($stats as $stat)
                                    <td class="statsTableCR">
                                        {{ $stat }}
                                    </td>
                                @endforeach
                            </tr>
                        </table>

                    </div>

                </div>
            </div>
        </div>

    </div>


    <div class="analysisContainer">
        <div class="observationContainer">
            <table class="observationTable">
                <tr>
                   <td class="subHeader">
                       Observations
                   </td>
                </tr>
                @if(count($observations) > 0)
                    @foreach($observations as $observation)
                        <tr class="observation">
                            <td>
                                {{ $observation }}
                            </td>
                        </tr>
                    @endforeach

                @else
                    <td>
                        None
                    </td>
                @endif
            </table>
        </div>

        <div class="targetContainer">
            <table class="targetTable">
                <tr>
                    <td class="subHeader">
                        Existing Targets
                        <a href="{{ route("target.create", ["playerId" => $player->id]) }}">
                            <button class="newTargetButton">New</button>
                        </a>
                    </td>
                </tr>

                <table class="targetTable">
                    @if(count($targets) > 0)
                        @foreach($targets as $target)
                            <tr>
                                <td>{{ $target->target_name }}</td>

                                <td>{{ $target->target_score }}</td>

                                <td>
                                    {{ $target->current_score }}
                                </td>

                                <td>
                                    @if($target->current_score < $target->target_score)
                                        <div class="labeler" style="background-color: red"></div>
                                    @else
                                        <div class="labeler" style="background-color: green"></div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    @else
                        <tr>
                            <td>
                                None
                            </td>
                        </tr>


                    @endif
                </table>


            </table>
        </div>

        <div class="suggestedTargetContainer">
            <table class="observationTable">
                <tr>
                    <td class="subHeader">
                        Suggested Targets
                    </td>
                </tr>

            </table>

            <table class="targetTable">
                @if(count($suggestedTargets) > 0)
                    @foreach($suggestedTargets as $suggestedTarget)
                            <tr>
                                <td>
                                    <form method="POST" action="{{ route('target.create', ["playerId" => $player->id]) }}">
                                        @csrf
                                        {{ $suggestedTarget }}
                                        <input name="targetName" id="targetName" value="{{ $suggestedTarget }}" type="hidden">

                                        <select id="targetIncrement" name="targetIncrement" required>
                                            @for($x = 1; $x <= 100; $x++)
                                                <option value="{{ $x }}">{{ $x }}</option>
                                            @endfor
                                        </select>

                                        <input type="date" name="endDate" id="endDate" required>

                                        <button class="suggestedSubmit" type="submit">Create</button>
                                    </form>

                                </td>
                            </tr>
                        </form>
                    @endforeach

                @else
                    <tr>
                        <td>
                            None
                        </td>
                    </tr>

                @endif
            </table>

        </div>

    </div>

    <div class="fourCornersContainer">
        <form method="POST" action="{{ route("fourCorner.update", ["playerId" => $player->id]) }}">
            @csrf
            <button class="fourCornersSubmit" type="submit">Save</button>
            <table class="fourCornersTable">
                <tr>
                    <th class="fourCornerHeader">
                        <b>Technical</b>
                    </th>
                    <th class="fourCornerHeader">
                        <b>Psychological</b>
                    </th>
                </tr>
                <tr>
                    <td>
                        @if($player->technical == "")
                            <textarea class="fourCornersInput" name="technical" placeholder="Enter Content about technical aspect"></textarea>
                        @else
                            <textarea class="fourCornersInput" name="technical"> {{ $player->technical }}</textarea>
                        @endif
                    </td>
                    <td>
                        @if($player->psychological == "")
                            <textarea class="fourCornersInput" name="psychological" placeholder="Enter Content about psychological aspect"></textarea>
                        @else
                            <textarea class="fourCornersInput" name="psychological"> {{ $player->psychological }}</textarea>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="fourCornerHeader">
                        <b>Physical</b>
                    </th>
                    <th class="fourCornerHeader">
                        <b>Social</b>
                    </th>
                </tr>
                <tr>
                    <td>
                        @if($player->physical == "")
                            <textarea class="fourCornersInput" name="physical" placeholder="Enter Content about physical aspect"></textarea>
                        @else
                            <textarea class="fourCornersInput" name="physical"> {{ $player->physical }}</textarea>
                        @endif
                    </td>
                    <td>
                        @if($player->social == "")
                            <textarea class="fourCornersInput" name="social" placeholder="Enter Content about social aspect"></textarea>
                        @else
                            <textarea class="fourCornersInput" name="social"> {{ $player->social }}</textarea>
                        @endif
                    </td>
                </tr>
            </table>
        </form>

    </div>

@endsection