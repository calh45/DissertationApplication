@extends('layouts.playerSide')

<link rel="stylesheet" href={{ asset('css/playerProfileM.css') }}>

@section('content')
    <div>
        <div class="imageContainer">
            <img style="height: 200px; width: 200px" src="images/{{ \Illuminate\Support\Facades\Auth::user()->profileImage }}">
            <form method="POST"  enctype="multipart/form-data" action="{{ route("picture.change") }}">
                @csrf
                <input type="file" id="imageSave" name="imageSave" > <br>
                <button type="submit">Upload Profile Photo</button>
            </form>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Dashboard</div>

                        <div class="card-body">
                            <table>
                                <tr class="columnSpacing">
                                    <td class="columnSpacing">
                                        Age: <br>
                                        {{ \Illuminate\Support\Facades\Auth::user()->player->age }}
                                    </td>

                                    <td class="columnSpacing">
                                        Position: <br>
                                        {{ \Illuminate\Support\Facades\Auth::user()->player->position }}
                                    </td>
                                </tr>
                                <tr class="columnSpacing">
                                    <td class="columnSpacing">
                                        Club: <br>
                                        {{ \Illuminate\Support\Facades\Auth::user()->player->club->clubName }}
                                    </td>

                                    <td class="columnSpacing">
                                        Team: <br>
                                        {{ \Illuminate\Support\Facades\Auth::user()->player->team->teamName }}
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
                                        {{ \Illuminate\Support\Facades\Auth::user()->player->appearances }}
                                    </td>
                                    <td class="statsTableCR">
                                        {{ \Illuminate\Support\Facades\Auth::user()->player->yellowCards }}
                                    </td>
                                    <td class="statsTableCR">
                                        {{ \Illuminate\Support\Facades\Auth::user()->player->redCards }}
                                    </td>
                                    <td class="statsTableCR">
                                        {{ \Illuminate\Support\Facades\Auth::user()->player->goals }}
                                    </td>
                                    <td class="statsTableCR">
                                        {{ \Illuminate\Support\Facades\Auth::user()->player->assists }}
                                    </td>
                                    <td class="statsTableCR">
                                        {{ \Illuminate\Support\Facades\Auth::user()->player->passesAttempted }}
                                    </td>
                                    <td class="statsTableCR">
                                        {{ \Illuminate\Support\Facades\Auth::user()->player->passesCompleted }}
                                    </td>
                                    <td class="statsTableCR">
                                        {{ \Illuminate\Support\Facades\Auth::user()->player->fouls }}
                                    </td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>



@endsection