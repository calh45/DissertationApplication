@extends('layouts.managerSide')

<link rel="stylesheet" href={{ asset('css/squadStatistics.css') }}>

@section("content")
    <table class="pageContainer">
        <tr>
            <td class="bestPerformersContainer">
                <div class="bestPerformersOutline">
                    <div class="containerHeader">
                        Best Younger Squad Performers
                    </div>

                    <div class="containerContent">
                        <table>
                            @if(count($bestPerformers) < 1)
                                <tr>
                                    <td>
                                        None Suitable
                                    </td>
                                </tr>

                            @else
                                @foreach($bestPerformers as $bestPerformer)
                                    <tr>
                                        <td class="performerColumn">
                                            <img style="height: 70px; width: 70px" src="images/{{ $bestPerformer->user->profileImage }}">
                                        </td>

                                        <td class="performerColumn">
                                            {{ $bestPerformer->user->name }}
                                        </td>

                                        <td class="performerColumn">
                                            {{ $bestPerformer->team->teamName }}
                                        </td>

                                        <td class="performerColumn">
                                            {{ $bestPerformer->position }}
                                        </td>

                                        <td class="performerColumn">
                                            {{ number_format($bestPerformer->totalScore, "1", ".", "") }}
                                        </td>

                                        <td class="performerColumn">
                                            <a href="{{ route("promote.player", ["playerId" => $bestPerformer->id]) }}">
                                                <button class="promoteButton">
                                                    Promote
                                                </button>
                                            </a>
                                        </td>

                                    </tr>

                                @endforeach

                            @endif
                        </table>
                    </div>

                </div>
            </td>

            <td class="currentlyPromotedContainer">
                <div class="currentlyPromotedOutline">
                    <div class="containerHeader">
                        Currently Promoted Players
                    </div>

                    <div class="containerContent">
                        <table>
                            @if(count($promotions) > 0)

                                @foreach($promotions as $promotion)
                                    <tr>
                                        <td class="performerColumn">
                                            <img style="height: 70px; width: 70px" src="images/{{ $promotion->user->profileImage }}">
                                        </td>

                                        <td class="performerColumn">
                                            {{ $promotion->user->name }}
                                        </td>

                                        <td class="performerColumn">
                                            {{ $promotion->originalTeam->teamName }}
                                        </td>

                                        <td class="performerColumn">
                                            {{ $promotion->user->player->position }}
                                        </td>

                                        <td class="performerColumn">
                                            <a href="{{ route("demote.player", ["promotionId" => $promotion->id]) }}">
                                                <button class="promoteButton">
                                                    Demote
                                                </button>
                                            </a>
                                        </td>


                                    </tr>

                                @endforeach


                            @else
                                <tr>
                                    None Currently
                                </tr>
                            @endif
                        </table>
                    </div>



                </div>
            </td>
        </tr>
    </table>

    <div class="suggestedPromotionContainer">
        <div class="suggestedPromotionsOutline">
            <div class="containerHeader">
                Suggested Promotions
            </div>

            <div class="containerContent">
                @if(count($suggestedPromotions) < 1)
                    <div class="noneSuitable">
                        <b>None Suitable</b>
                    </div>

                @else
                    <table class="suggestedPromotionsTable">
                        <tr>
                            <td>

                            </td>

                            <td class="performerColumn">
                                <b>Name</b>
                            </td>

                            <td class="performerColumn">
                                <b>Team</b>
                            </td>

                            <td class="performerColumn">
                                <b>Position</b>
                            </td>

                            <td class="performerColumn">
                                <b>Reasoning</b>
                            </td>

                            <td class="performerColumn">
                                <b>Teams Average Score</b>
                            </td>

                            <td class="performerColumn">
                                <b>Player Score</b>
                            </td>

                            <td>

                            </td>
                        </tr>

                        @foreach($suggestedPromotions as $suggestedPromotion)
                            <tr>
                                <td class="performerColumn">
                                    <img style="height: 70px; width: 70px" src="images/{{ $suggestedPromotion[0]->player->user->profileImage }}">
                                </td>

                                <td class="performerColumn">
                                    <a class="text-decoration-none" href="/players/{{ $suggestedPromotion[0]->player->id }}">
                                        {{ $suggestedPromotion[0]->player->user->name }}
                                    </a>
                                </td>

                                <td class="performerColumn">
                                    {{ $suggestedPromotion[0]->player->team->teamName }}
                                </td>

                                <td class="performerColumn">
                                    {{ $suggestedPromotion[0]->player->position }}
                                </td>

                                <td class="performerColumn">
                                    This player's {{ $suggestedPromotion[1] }} levels are significantly above the average level of the team
                                </td>

                                <td class="performerColumn">
                                    {{ number_format($suggestedPromotion[2], "1", ".", "") }}
                                </td>

                                <td class="performerColumn">
                                    {{ number_format($suggestedPromotion[3], "1", ".", "") }}
                                </td>

                                <td class="performerColumn">
                                    <a href="{{ route("promote.player", ["playerId" => $suggestedPromotion[0]->player->id]) }}">
                                        <button class="promoteButton">
                                            Promote
                                        </button>
                                    </a>
                                </td>
                            </tr>

                        @endforeach
                    </table>
                @endif

            </div>

        </div>
    </div>



@endsection