@extends('app')

@section('title', "Panel administracyjny")

@section('content')

    <div id='seans_info'>
        <p><b>Seans: </b> {{ $screening->name }} <br><b> Data: </b>{{ $screening->date }} {{ $screening->hour }} <br><b> Film: </b>{{ $screening->film->title }} <br><b> Miejsce seansu: </b>{{ $screening->venue->city }}, {{ $screening->venue->street }} <br><b> Rodzaj miejsca:</b> {{ $screening->venue->place_type }} <br><b> Maksymalna ilość miejsc na seans wynosi: </b>{{ $ilosc_miejsc }} </p>
        @if($ilosc_miejsc_wolnych == 0)
            <p><span style='color:red'><b>Brak miejsc na seans!</b></span></p>
        @elseif($ilosc_miejsc_wolnych < 10)
            <p><span style='color:red'><b>Zostało kilka miejsc parkingowych!</b></span></p>
        @else
            <p>Zostało {{ $ilosc_miejsc_wolnych }} miejsc parkingowych.</p>
        @endif
        <?php $i=1 ?>
    </div>
    <table align='center' id='parking'><tr><td class='rzad'>{{ $i }}</td>
        @foreach($tickets as $ticket)
            @if($ticket->user_id == NULL)
                <td style="background-color:green"><b>{{ $ticket->parking_spot_number }}</b>
                </td>
            @else
            <td style='background-color:red'><a href={{ route("ticket.show", $ticket->id) }} title='Nr biletu: {{ $ticket->id }}'><b>{{ $ticket->parking_spot_number }}</b></a></td>
            @endif
            @if ($ticket->parking_spot_number % 10 == 0)
                <td class='rzad'>{{ $i }}</td></tr>
                <?php $i++; ?>
                @if($ticket->parking_spot_number != $ilosc_miejsc)
                        <tr><td class='rzad'>{{ $i }}</td>
                @endif
            @endif
        @endforeach
        @if($ilosc_miejsc % 10!=0)
            @while($ilosc_miejsc % 10!=0)
                <td class='puste'></td>
                {{ $ilosc_miejsc++ }}
             @endwhile
                <td class='rzad'>{{ $i }}</td></tr>
        @endif
	</table>
        @if(session('message'))
            <span><b>{{ session('message') }}</b></span>
        @endif

@endsection
