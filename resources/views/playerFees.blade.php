
@extends(Auth::user()->accountType == "P" ? 'layouts.playerSide' : 'layouts.managerSide')

<link rel="stylesheet" href={{ asset('css/playerProfileM.css') }}>

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Fees</div>

                    <div class="card-body">
                        <table>
                            <tr class="columnSpacing">
                                <td>Balance: £{{ $thisUser->player->balance }}</td>
                            </tr>


                        </table>

                        @if($thisUser->player->balance < 0 && Auth::user()->accountType == "P")
                            <form class="balanceContainer" method="POST" action="{{ route("fee.pay") }}">
                                @csrf
                                <input type="number" name="amountToPay" id="amountToPay" min="1" max="{{ abs($thisUser->player->balance) }}">
                                <button type="submit">Pay</button>
                            </form>
                        @elseif($thisUser->player->balance < 0 && Auth::user()->accountType == "M")
                            <a href="/sendReminder/{{ $thisUser->id }}">
                                <button class="reminderButton">Send Reminder</button>
                            </a>
                        @endif

                        <table class="statsTable">
                            <tr class="statsTableCR">
                                <td class="statsTableCR">
                                    <b>Transaction Type</b>
                                </td>
                                <td class="statsTableCR">
                                    <b>Amount</b>
                                </td>
                                <td class="statsTableCR">
                                    <b>Date</b>
                                </td>

                            </tr>

                            @foreach($transactions as $currentTransaction)
                                <tr class="statsTableCR">
                                    <td class="statsTableCR">
                                        {{ $currentTransaction->transaction_type }}
                                    </td>
                                    <td class="statsTableCR">
                                        £{{ $currentTransaction->amount }}
                                    </td>
                                    <td class="statsTableCR">
                                        {{ $currentTransaction->created_at->diffForHumans() }}
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
@endsection
