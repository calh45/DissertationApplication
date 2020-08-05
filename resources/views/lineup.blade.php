@extends(Auth::user()->accountType == "P" ? 'layouts.playerSide' : 'layouts.managerSide')

<link rel="stylesheet" href={{ asset('css/lineup.css') }} >

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $event->name }} -- {{ $event->location }}</div>

                    <div class="card-body">
                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                <p class="errorMessage"> <b> {{ $error }} </b></p>
                            @endforeach

                        @endif
                        <form method="POST" action="{{ route("lineup.create", ["eventId" => $event->id]) }}">
                            @csrf
                            <button type="submit">Update</button>
                            <table>
                                <tr>
                                    <td class="playerContainer">
                                        @foreach($positions as $position)

                                            @if($position === "12")
                                                <br>
                                                <div>Subs:</div>
                                            @endif
                                            <label for="{{ $position }}"> {{ $position }}: </label>
                                            <select class="playerChoice" name="{{ $position }}" id="{{ $position }}">
                                                @if((int)$position > 11)
                                                    <option value="none">None</option>
                                                @endif

                                                @foreach($goalkeepers as $goalkeeper)
                                                    <option value="{{ $goalkeeper->user->id }}">{{ $goalkeeper->user->name }} -- GK</option>
                                                @endforeach

                                                @foreach($defenders as $defender)
                                                    <option value="{{ $defender->user->id }}">{{ $defender->user->name }} -- DF</option>
                                                @endforeach

                                                @foreach($midfielders as $midfielder)
                                                    <option value="{{ $midfielder->user->id }}">{{ $midfielder->user->name }} -- MF</option>
                                                @endforeach

                                                @foreach($forwards as $forward)
                                                    @if(count($forward->user->availabilities->where("event_id", "=", $event->id)) === 0)
                                                        <option value="{{ $forward->user->id }}">{{ $forward->user->name }} -- FW</option>
                                                    @endif
                                                @endforeach

                                            </select>
                                            <br>
                                        @endforeach
                                    </td>

                                    <td class="pitchContainer">
                                        <select id="pictureSelect" name="pictureSelect" onchange="changePic(this)">
                                            <option value="/images/pitches/4-4-2.png">4-4-2</option>
                                            <option value="/images/pitches/4-3-3.png">4-3-3</option>
                                            <option value="/images/pitches/4-2-3-1.png">4-2-3-1</option>
                                            <option value="/images/pitches/4-1-2-1-2.png">4-1-2-1-2</option>
                                            <option value="/images/pitches/3-5-2.png">3-5-2</option>
                                        </select>

                                        <div>
                                            <img class="pitchContainer" id="pitch" src="/images/pitches/4-4-2.png">
                                        </div>
                                    </td>
                                </tr>
                            </table>

                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

<script>

    function changePic(newImage) {
        var image = document.getElementById("pitch");
        image.src = newImage.options[newImage.selectedIndex].value;
    }
</script>
