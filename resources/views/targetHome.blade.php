@extends(Auth::user()->accountType == "P" ? 'layouts.playerSide' : 'layouts.managerSide')

<link rel="stylesheet" href={{ asset('css/targetHome.css') }}>

@section('content')


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Target Area: {{ $target->target_name }}

                    </div>

                    <div class="card-body">
                        <div>
                            <table class="targetTable">
                                <tr class="targetTableRow">
                                    <td class="targetTableRow">
                                        <div name="targetStart" id="targetStart">
                                            <label for="targetStart">Start Date: </label>
                                            {{ $target->start_date }}

                                        </div>

                                    </td>

                                    <td class="targetTableRow">
                                        <div name="targetEnd" id="targetEnd">
                                            <label for="targetEnd">End Date: </label>
                                            {{ $target->end_date }}
                                        </div>
                                    </td>
                                </tr>

                                <tr class="targetTableRow">
                                    <td class="targetTableRow">
                                        <div name="startScore" id="startScore">
                                            <label for="startScore">Start Score: </label>
                                            {{ $target->start_score }}
                                        </div>
                                    </td>

                                    <td class="targetTableRow">
                                        <div name="targetScore" id="targetScore">
                                            <label for="targetScore">Target Score: </label>
                                            {{ $target->target_score }}
                                        </div>
                                    </td>

                                    <td class="targetTableRow">
                                        <div name="currentScore" id="currentScore">
                                            <label for="currentScore">Current Score: </label>
                                            {{ $target->current_score }}
                                        </div>
                                    </td>
                                </tr>

                            </table>

                            <div class="reportHeader">
                                Report
                            </div>

                            <div name="targetReport" id="targetReport">
                                @if($target->report == "")
                                    Report will appear here once target has finished

                                @else
                                    {{ $target->report }}
                                @endif
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





@endsection