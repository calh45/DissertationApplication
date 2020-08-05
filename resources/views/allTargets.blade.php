@extends('layouts.playerSide')

<link rel="stylesheet" href={{ asset('css/allTargets.css') }}>

@section('content')
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Active Targets</div>

                        <div class="card-body">
                            <table class="targetTable">
                                <tr>
                                    <td>
                                        Target
                                    </td>

                                    <td>
                                        Current Score
                                    </td>

                                    <td>
                                        Target Score
                                    </td>
                                    <td>

                                    </td>
                                </tr>
                                @foreach($allTargets as $thisTarget)
                                    <tr class="playerHolder">
                                        <td>
                                            <a href="{{ route("target", ["targetId" => $thisTarget->id]) }}">
                                                {{ $thisTarget->target_name }}
                                            </a>

                                        </td>

                                        <td>
                                            {{ $thisTarget->current_score }}
                                        </td>

                                        <td>
                                            {{ $thisTarget->target_score }}
                                        </td>

                                        <td>
                                            @if($thisTarget->current_score < $thisTarget->target_score)
                                                <div class="labeler" style="background-color: red">

                                                </div>

                                            @else
                                                <div class="labeler" style="background-color: green">

                                                </div>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>



@endsection