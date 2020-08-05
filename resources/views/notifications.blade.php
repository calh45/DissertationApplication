@extends('layouts.playerSide')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Notifications</div>

                    <table class="notificationsTable">
                        @foreach($thisNotifications as $notification)
                            <tr>
                                <td>
                                    <div class="notificationPicContainer">

                                        @if($notification->type === "Event")
                                            <img style="height: 50px; width: 50px" src="images/stadium.png">
                                        @elseif($notification->type === "Finance")
                                            <img style="height: 50px; width: 50px" src="images/money.png">
                                        @elseif($notification->type === "Target")
                                            <img style="height: 50px; width: 50px" src="images/football.png">
                                        @endif


                                    </div>
                                </td>

                                <td>
                                    {{ $notification->content }}
                                </td>

                                <td>
                                    {{ $notification->created_at->diffForHumans() }}
                                </td>



                            </tr>

                        @endforeach
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection