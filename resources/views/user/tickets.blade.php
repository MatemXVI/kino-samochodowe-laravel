@extends('app')

@section('title', "Panel użytkownika")

@section('content')

        <h2>Bilety:</h2>
         <?php $i = 0 ?>
        <div id='bilety'>
        @foreach($tickets as $ticket)
            {{-- @if($i==0)
                <div class='bilety_kolumna'>
            @endif --}}
            <div class='numer_biletu'><b><a href={{ route("ticket.show",  $ticket->id )}}> {{ $ticket->id }}</a></b></div>
            <?php $i++ ?>
            {{-- @if($i == 10)
                </div>
               <?php // $i=0 ?>
            @endif --}}
        @endforeach
        @if($i != 10)
            </div><div style='clear:both'></div></div>
        @endif
        @if (session('success'))
            <span class="success">{{ session('message') }}</span>
        @endif

@endsection
