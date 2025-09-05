@extends('app')

@section('title', "Kup bilet")

@section('content')

    <div id="wybor_biletu">
        <h3>{{ $ticket->screening->film->title }}</h3>
        <p>Piątek {{ $ticket->screening->date }} godz. {{ $ticket->screening->hour }}</p>
        <p>{{ $ticket->screening->name }}</p>
        <p>{{ $ticket->screening->venue->city }}, ul. {{ $ticket->screening->venue->street }}</p>
        Numer miejsca: {{ $ticket->parking_spot_number }}
        <p>Koszt biletu: {{ $ticket->screening->price }} zł<br>
        + 1.5 zł opłaty internetowej za zakup</p>
        <form action = {{ route("ticket.payment") }} method="post">
            @csrf
            <input type="hidden" name="numer_miejsca_parkingowego" value= {{ $parkingSpotNumber }}  >
            <input type="hidden" name="id_seansu" value={{ $screeningId }}  >
            <input type="submit" value="Zatwierdź i podaj dane osobowe">
        </form>
    </div>
    @if(session('message'))
        <span><b>{{ session('message') }}</b></span>
    @endif

@endsection
