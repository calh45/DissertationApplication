@extends('layouts.managerSide')

<link rel="stylesheet" href={{ asset('css/managerHomePage.css') }}>



@section('content')
    <div class="container-Manager">
        <table class="pageTable">
            <tr class="pageRowColumn">
                <td class="pageRowColumn">
                    <div class="tableItem">
                        <div class="sectionHeader">
                            <a class="text-decoration-none" href="{{ route("allPlayers", ["toOrder" => "goals"]) }}">
                                Players
                            </a>
                        </div>

                        <table class="playerTable">
                            <tr>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                            </tr>
                            @foreach($players as $player)
                                <tr class="playerHolder">
                                    <td>
                                        <img style="height: 70px; width: 70px" src="images/{{ $player->user->profileImage }}">
                                    </td>

                                    <td>
                                        <a class="text-decoration-none" href="/players/{{ $player->id }}">
                                            {{ $player->user->name }}
                                        </a>
                                    </td>

                                    <td>
                                        {{ $player->position }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>



                    </div>

                </td>
                <td class="pageRowColumn">

                    <div class="tableItem">
                        <div>Players behind on fee's</div>
                        @if(count($behindFees) > 0)
                            <table class="playerTable">
                                @foreach($behindFees as $thisPlayer)
                                    <tr class="playerHolder">
                                        <td>
                                            <img style="height: 70px; width: 70px" src="images/{{ $thisPlayer->user->profileImage }}">
                                        </td>

                                        <td>
                                            <a class="text-decoration-none" href="/playerFees/{{ $thisPlayer->user->id }}">
                                                {{ $thisPlayer->user->name }}
                                            </a>
                                        </td>

                                        <td>
                                            £{{ $thisPlayer->balance }}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <div class="miniRow">
                                None
                            </div>
                        @endif

                    </div>

                </td>
                <td class="pageRowColumn">

                    <div class="tableItem">
                        <a class="text-decoration-none" href="{{ route("calendar", ["year" => 2020]) }}">
                            Calendar
                        </a>

                        <table class="miniCalendar">
                            @if(count($events) > 0)
                                @foreach($events as $event)
                                    <tr>
                                        <td class="miniRow">
                                            {{ \Carbon\Carbon::parse($event->task_date)->diffForHumans() }}
                                        </td>
                                        <td class="miniRow">
                                            <a class="text-decoration-none" href="{{ route("calendarEvent", ["id" =>$event->id]) }}">
                                                {{ $event->name }}
                                            </a>
                                        </td>
                                        <td class="miniRow">
                                            {{ $event->location }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="miniRow">
                                        None Upcoming
                                    </td>
                                </tr>
                            @endif

                        </table>


                    </div>

                </td>
            </tr>
            <tr class="pageRowColumn">
                <td class="pageRowColumn">

                    <div class="tableItem">
                        <div>Best Performing players</div>

                        @if(count($topPerformers) > 0)
                            <table class="playerTable">
                                @foreach($topPerformers as $topPerformer)

                                    <tr class="playerHolder">
                                        <td>
                                            <img style="height: 70px; width: 70px" src="images/{{ $topPerformer->user->profileImage }}">
                                        </td>
                                        <td>
                                            <a class="text-decoration-none" href="/players/{{ $topPerformer->id }}">
                                                {{ $topPerformer->user->name }}
                                            </a>
                                        </td>

                                        <td>
                                            {{ $topPerformer->position }}
                                        </td>

                                        <td>
                                            {{ number_format($topPerformer->totalScore, "2", ".", "") }}
                                        </td>
                                    </tr>



                                @endforeach
                            </table>

                        @else
                            <div class="miniRow">
                                None
                            </div>
                        @endif
                    </div>


                </td>
                <td class="pageRowColumn">

                    <div class="tableItem">
                        <div>Player Availability Notifications</div>

                        @if(count($availabilities) > 0)
                            <table class="playerTable">
                                @foreach($availabilities as $availability)
                                    <tr class="playerHolder">
                                        <td>
                                            <img style="height: 70px; width: 70px" src="images/{{ $availability->user->profileImage }}">
                                        </td>

                                        <td>
                                            {{ $availability->user->name }}
                                        </td>

                                        <td>
                                            {{ $availability->calendarEvent->name }}
                                        </td>

                                        <td>
                                            {{ $availability->calendarEvent->location }}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>

                        @else
                            <div class="miniRow">
                                None
                            </div>

                        @endif


                    </div>

                </td>
                <td class="pageRowColumn">

                    <div class="tableItem">
                        <div>Players Progress on targets</div>

                        @if(count($targets) > 0)
                            <table class="playerTable">
                                @if(count($targets) > 0)
                                    @foreach($targets as $target)
                                        <tr class="playerHolder">
                                            <td>
                                                {{ \App\Player::find($target->player_id)->user->name }}
                                            </td>

                                            <td>
                                                <a href="{{ route("target", ["targetId" => $target->id]) }}">
                                                    {{ $target->target_name }}
                                                </a>

                                            </td>

                                            <td>
                                                {{ $target->current_score }}
                                            </td>

                                            <td>
                                                @if($target->current_score < $target->target_score)
                                                    <div class="labeler" style="background-color: red">

                                                    </div>

                                                @else
                                                    <div class="labeler" style="background-color: green">

                                                    </div>
                                                @endif
                                            </td>

                                        </tr>

                                    @endforeach
                                @else
                                    <tr>
                                        None set yet, keep checking back to see when new targets are added.
                                    </tr>

                                @endif
                            </table>

                        @endif
                    </div>

                </td>
            </tr>

        </table>

    </div>

@endsection

