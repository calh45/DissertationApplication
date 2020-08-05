@extends(Auth::user()->accountType == "P" ? 'layouts.playerSide' : 'layouts.managerSide')

<link rel="stylesheet" href={{ asset('css/calendar.css') }} >

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Calendar</div>

                    @if(Auth::user()->accountType === "M")
                        <div class="formContainer">
                            <form method="POST" action="{{ route("event.create") }}">
                                @csrf
                                <label for="eventName">Event: </label>
                                <input type="text" name="eventName" id="eventName" required>

                                <label for="eventName">Event Type: </label>
                                <select id="eventType" name="eventType" required>
                                    <option id="match" name="match" value="Match">Match</option>
                                    <option id="training" name="training" value="Training">Training</option>
                                </select>

                                <label for="location">Location: </label>
                                <input type="text" name="location" id="location" required> <br>

                                <label for="dateTime">Date and Time: </label>
                                <input type="datetime-local" name="dateTime" id="dateTime" required> <br>

                                <button class="submitButton" type="submit">Create</button>

                            </form>
                        </div>
                    @endif


                    <div class="card-body">
                        <div>
                            <form method="POST" action="{{ route("calendar.change") }}">
                                @csrf
                                <input type="number" min="2020" max="2030" name="yearRequest" id="yearRequest" placeholder="2020">
                                <button type="submit">Year</button>
                            </form>
                        </div>
                        <div class="monthContainer">
                            <div class="monthText"> January </div>
                        </div>

                        <table class="eventContainer">
                            @foreach($jan as $thisEvent)
                                <tr>
                                    <td>
                                        <div class="eventDate">
                                            {{ \Carbon\Carbon::parse($thisEvent->task_date)->day }}
                                            January
                                            {{ \Carbon\Carbon::parse($thisEvent->task_date)->year }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eventName">
                                            <a href="{{ route("calendarEvent", ["id" => $thisEvent->id]) }}">
                                                {{ $thisEvent->name }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eventType">
                                            {{ $thisEvent->event_type }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $thisEvent->location }}
                                    </td>

                                    @if(Auth::user()->accountType=="M")
                                        <td class="deleteButton">
                                            <form method="POST" action="{{ route("event.delete", ["id" => $thisEvent->id]) }}">
                                                @csrf
                                                <button type="submit">Delete</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </table>

                        <div class="monthContainer">
                            <div class="monthText"> February </div>
                        </div>

                        <table class="eventContainer">
                            @foreach($feb as $thisEvent)
                                <tr>
                                    <td>
                                        <div class="eventDate">
                                            {{ \Carbon\Carbon::parse($thisEvent->task_date)->day }}
                                            February
                                            {{ \Carbon\Carbon::parse($thisEvent->task_date)->year }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eventName">
                                            <a href="{{ route("calendarEvent", ["id" => $thisEvent->id]) }}">
                                                {{ $thisEvent->name }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eventType">
                                            {{ $thisEvent->event_type }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $thisEvent->location }}
                                    </td>

                                    @if(Auth::user()->accountType=="M")
                                        <td class="deleteButton">
                                            <form method="POST" action="{{ route("event.delete", ["id" => $thisEvent->id]) }}">
                                                @csrf
                                                <button type="submit">Delete</button>
                                            </form>
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                        </table>

                        <div class="monthContainer">
                            <div class="monthText"> March </div>
                        </div>

                        <table class="eventContainer">
                            @foreach($march as $thisEvent)
                                <tr>
                                    <td>
                                        <div class="eventDate">
                                            {{ \Carbon\Carbon::parse($thisEvent->task_date)->day }}
                                            March
                                            {{ \Carbon\Carbon::parse($thisEvent->task_date)->year }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eventName">
                                            <a href="{{ route("calendarEvent", ["id" => $thisEvent->id]) }}">
                                                {{ $thisEvent->name }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eventType">
                                            {{ $thisEvent->event_type }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $thisEvent->location }}
                                    </td>

                                    @if(Auth::user()->accountType=="M")
                                        <td class="deleteButton">
                                            <form method="POST" action="{{ route("event.delete", ["id" => $thisEvent->id]) }}">
                                                @csrf
                                                <button type="submit">Delete</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </table>

                        <div class="monthContainer">
                            <div class="monthText"> April </div>
                        </div>

                        <table class="eventContainer">
                            @foreach($april as $thisEvent)
                                <tr>
                                    <td>
                                        <div class="eventDate">
                                            {{ \Carbon\Carbon::parse($thisEvent->task_date)->day }}
                                            April
                                            {{ \Carbon\Carbon::parse($thisEvent->task_date)->year }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eventName">
                                            <a href="{{ route("calendarEvent", ["id" => $thisEvent->id]) }}">
                                                {{ $thisEvent->name }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eventType">
                                            {{ $thisEvent->event_type }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $thisEvent->location }}
                                    </td>

                                    @if(Auth::user()->accountType=="M")
                                        <td class="deleteButton">
                                            <form method="POST" action="{{ route("event.delete", ["id" => $thisEvent->id]) }}">
                                                @csrf
                                                <button type="submit">Delete</button>
                                            </form>
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                        </table>

                        <div class="monthContainer">
                            <div class="monthText"> May </div>
                        </div>

                        <table class="eventContainer">
                            @foreach($may as $thisEvent)
                                <tr>
                                    <td>
                                        <div class="eventDate">
                                            {{ \Carbon\Carbon::parse($thisEvent->task_date)->day }}
                                            May
                                            {{ \Carbon\Carbon::parse($thisEvent->task_date)->year }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eventName">
                                            <a href="{{ route("calendarEvent", ["id" => $thisEvent->id]) }}">
                                                {{ $thisEvent->name }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eventType">
                                            {{ $thisEvent->event_type }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $thisEvent->location }}
                                    </td>

                                    @if(Auth::user()->accountType=="M")
                                        <td class="deleteButton">
                                            <form method="POST" action="{{ route("event.delete", ["id" => $thisEvent->id]) }}">
                                                @csrf
                                                <button type="submit">Delete</button>
                                            </form>
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                        </table>

                        <div class="monthContainer">
                            <div class="monthText"> June </div>
                        </div>

                        <table class="eventContainer">
                            @foreach($june as $thisEvent)
                                <tr>
                                    <td>
                                        <div class="eventDate">
                                            {{ \Carbon\Carbon::parse($thisEvent->task_date)->day }}
                                            June
                                            {{ \Carbon\Carbon::parse($thisEvent->task_date)->year }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eventName">
                                            <a href="{{ route("calendarEvent", ["id" => $thisEvent->id]) }}">
                                                {{ $thisEvent->name }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eventType">
                                            {{ $thisEvent->event_type }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $thisEvent->location }}
                                    </td>

                                    @if(Auth::user()->accountType=="M")
                                        <td class="deleteButton">
                                            <form method="POST" action="{{ route("event.delete", ["id" => $thisEvent->id]) }}">
                                                @csrf
                                                <button type="submit">Delete</button>
                                            </form>
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                        </table>

                        <div class="monthContainer">
                            <div class="monthText"> July </div>
                        </div>

                        <table class="eventContainer">
                            @foreach($july as $thisEvent)
                                <tr>
                                    <td>
                                        <div class="eventDate">
                                            {{ \Carbon\Carbon::parse($thisEvent->task_date)->day }}
                                            July
                                            {{ \Carbon\Carbon::parse($thisEvent->task_date)->year }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eventName">
                                            <a href="{{ route("calendarEvent", ["id" => $thisEvent->id]) }}">
                                            {{ $thisEvent->name }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eventType">
                                            {{ $thisEvent->event_type }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $thisEvent->location }}
                                    </td>

                                    @if(Auth::user()->accountType=="M")
                                        <td class="deleteButton">
                                            <form method="POST" action="{{ route("event.delete", ["id" => $thisEvent->id]) }}">
                                                @csrf
                                                <button type="submit">Delete</button>
                                            </form>
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                        </table>

                        <div class="monthContainer">
                            <div class="monthText"> August </div>
                        </div>

                        <table class="eventContainer">
                            @foreach($august as $thisEvent)
                                <tr>
                                    <td>
                                        <div class="eventDate">
                                            {{ \Carbon\Carbon::parse($thisEvent->task_date)->day }}
                                            August
                                            {{ \Carbon\Carbon::parse($thisEvent->task_date)->year }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eventName">
                                            <a href="{{ route("calendarEvent", ["id" => $thisEvent->id]) }}">
                                                {{ $thisEvent->name }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eventType">
                                            {{ $thisEvent->event_type }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $thisEvent->location }}
                                    </td>

                                    @if(Auth::user()->accountType=="M")
                                        <td class="deleteButton">
                                            <form method="POST" action="{{ route("event.delete", ["id" => $thisEvent->id]) }}">
                                                @csrf
                                                <button type="submit">Delete</button>
                                            </form>
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                        </table>

                        <div class="monthContainer">
                            <div class="monthText"> September </div>
                        </div>

                        <table class="eventContainer">
                            @foreach($sept as $thisEvent)
                                <tr>
                                    <td>
                                        <div class="eventDate">
                                            {{ \Carbon\Carbon::parse($thisEvent->task_date)->day }}
                                            September
                                            {{ \Carbon\Carbon::parse($thisEvent->task_date)->year }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eventName">
                                            <a href="{{ route("calendarEvent", ["id" => $thisEvent->id]) }}">
                                                {{ $thisEvent->name }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eventType">
                                            {{ $thisEvent->event_type }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $thisEvent->location }}
                                    </td>

                                    @if(Auth::user()->accountType=="M")
                                        <td class="deleteButton">
                                            <form method="POST" action="{{ route("event.delete", ["id" => $thisEvent->id]) }}">
                                                @csrf
                                                <button type="submit">Delete</button>
                                            </form>
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                        </table>

                        <div class="monthContainer">
                            <div class="monthText"> October </div>
                        </div>

                        <table class="eventContainer">
                            @foreach($oct as $thisEvent)
                                <tr>
                                    <td>
                                        <div class="eventDate">
                                            {{ \Carbon\Carbon::parse($thisEvent->task_date)->day }}
                                            October
                                            {{ \Carbon\Carbon::parse($thisEvent->task_date)->year }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eventName">
                                            <a href="{{ route("calendarEvent", ["id" => $thisEvent->id]) }}">
                                                {{ $thisEvent->name }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eventType">
                                            {{ $thisEvent->event_type }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $thisEvent->location }}
                                    </td>

                                    @if(Auth::user()->accountType=="M")
                                        <td class="deleteButton">
                                            <form method="POST" action="{{ route("event.delete", ["id" => $thisEvent->id]) }}">
                                                @csrf
                                                <button type="submit">Delete</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </table>

                        <div class="monthContainer">
                            <div class="monthText"> November </div>
                        </div>

                        <table class="eventContainer">
                            @foreach($nov as $thisEvent)
                                <tr>

                                    <td>
                                        <div class="eventDate">
                                            {{ \Carbon\Carbon::parse($thisEvent->task_date)->day }}
                                            November
                                            {{ \Carbon\Carbon::parse($thisEvent->task_date)->year }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eventName">
                                            <a href="{{ route("calendarEvent", ["id" => $thisEvent->id]) }}">
                                                {{ $thisEvent->name }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="eventType">
                                            {{ $thisEvent->event_type }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $thisEvent->location }}
                                    </td>

                                    @if(Auth::user()->accountType=="M")
                                        <td class="deleteButton">
                                            <form method="POST" action="{{ route("event.delete", ["id" => $thisEvent->id]) }}">
                                                @csrf
                                                <button type="submit">Delete</button>
                                            </form>
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                        </table>

                        <div class="monthContainer">
                            <div class="monthText"> December </div>
                        </div>

                        <table class="eventContainer">
                            @foreach($dec as $thisEvent)
                                <tr>

                                    <td>
                                        <div class="eventDate">
                                            {{ \Carbon\Carbon::parse($thisEvent->task_date)->day }}
                                            December
                                            {{ \Carbon\Carbon::parse($thisEvent->task_date)->year }}
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route("calendarEvent", ["id" => $thisEvent->id]) }}">
                                            <div class="eventName">
                                                {{ $thisEvent->name }}
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="eventType">
                                            {{ $thisEvent->event_type }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $thisEvent->location }}
                                    </td>

                                    @if(Auth::user()->accountType=="M")
                                        <td class="deleteButton">
                                            <form method="POST" action="{{ route("event.delete", ["id" => $thisEvent->id]) }}">
                                                @csrf
                                                <button type="submit">Delete</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

