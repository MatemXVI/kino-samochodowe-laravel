@extends('app')

@section('title', "Kup bilet")

@section('content')
    <h2>Wybierz sposób płatności</h2>
    <form action="{{ route("ticket.summary") }}" method="post">
        @csrf
        <table align="center" id="platnosc">
            <tr><td><label><input type="radio" name="platnosc" value="Karta płatnicza" required>Karta płatnicza</label><img src={{ Storage::url("img/ticket/visa_mastercard.png") }} height="34"></td></tr>
            <tr><td><label><input type="radio" name="platnosc" value="Google Pay">Google Pay</label><img src={{ Storage::url("img/ticket/google_pay.png") }} height="34"></td></tr>
            <tr><td><label><input type="radio" name="platnosc" value="BLIK">BLIK</label><img src={{ Storage::url("img/ticket/blik.png") }} height="34"></td></tr>
            <tr><td><label><input type="radio" name="platnosc" value="Przelew online">Przelew online</label><img src={{ Storage::url("img/ticket/payu.png") }} height="34"></td></tr>
            <tr><td><label><input type="radio" name="platnosc" value="Paypal">Paypal</label><img src={{ Storage::url("img/ticket/paypal.png") }} height="34"></td></tr>
        </table>
        <input type="hidden" name="numer_miejsca_parkingowego" value= {{ $parkingSpotNumber }}  >
        <input type="hidden" name="id_seansu" value={{ $screeningId }}  >
        <input type="submit" value="Wybierz płatność">
    </form><br>
        @error('platnosc')
            <div style="color:red; margin-top:10px;">{{ $message }}</div>
        @enderror
@endsection
