@extends('layouts.app')

<link rel="stylesheet" href={{ asset('css/registerClubPage.css') }}>

@section('content')
<div class="registerClubFormContainer">
    <form class="registerClubFormStyle" method="POST" action="{{ route('clubs.create') }}">
        @if(session('message'))
            <div style="color: whitesmoke; text-underline: whitesmoke"><u>{{ session('message') }}</u></div>
        @endif
        @csrf
        Club Name:
        <input type="text" name="clubName"><br>
        Club Creator Name:
        <input type="text" name="creatorName"><br>
        Teams:
        <br>
        <input type="checkbox" value="under9" name="teams[]"> Under 9's <br>
        <input type="email" name="under9ManagerEmail" placeholder="Manager Email"><br>

        <input type="checkbox" value="under10" name="teams[]"> Under 10's <br>
        <input type="email" name="under10ManagerEmail" placeholder="Manager Email"><br>

        <input type="checkbox" value="under11" name="teams[]"> Under 11's <br>
        <input type="email" name="under11ManagerEmail" placeholder="Manager Email"><br>

        <input type="checkbox" value="under12" name="teams[]"> Under 12's <br>
        <input type="email" name="under12ManagerEmail" placeholder="Manager Email"><br>

        <input type="checkbox" value="under13" name="teams[]"> Under 13's <br>
        <input type="email" name="under13ManagerEmail" placeholder="Manager Email"><br>

        <input type="checkbox" value="under14" name="teams[]"> Under 14's <br>
        <input type="email" name="under14ManagerEmail" placeholder="Manager Email"><br>

        <input type="checkbox" value="under15" name="teams[]"> Under 15's <br>
        <input type="email" name="under15ManagerEmail" placeholder="Manager Email"><br>

        <input type="checkbox" value="under16" name="teams[]"> Under 16's <br>
        <input type="email" name="under16ManagerEmail" placeholder="Manager Email"><br>

        <input type="checkbox" value="under18" name="teams[]"> Under 18's <br>
        <input type="email" name="under18ManagerEmail" placeholder="Manager Email"><br>

        <input type="checkbox" value="under21" name="teams[]"> Under 21's <br>
        <input type="email" name="under21ManagerEmail" placeholder="Manager Email"><br>

        <input type="checkbox" value="seniors" name="teams[]"> Seniors <br>
        <input type="email" name="seniorsManagerEmail" placeholder="Manager Email"><br>

        <button type="submit">Submit</button>
    </form>

</div>
@endsection


