@extends('app')

@section('title', "Kup bilet")

@section('content')

    <div id='seans_info'>
        <p><b>Seans: </b> {{ $screening->name }} <br><b> Data: </b>{{ $screening->date }} {{ $screening->hour }} <br><b> Film: </b>{{ $screening->film->title }} <br><b> Miejsce seansu: </b>{{ $screening->venue->city }}, {{ $screening->venue->street }} <br><b> Rodzaj miejsca:</b> {{ $screening->venue->place_type }} <br><b> Maksymalna ilość miejsc na seans wynosi: </b>{{ $parkingSpotCount }} </p>
        @if($availableParkingSpotCount == 0)
            <p><span style='color:red'><b>Brak miejsc na seans!</b></span></p>
        @elseif($availableParkingSpotCount < 10)
            <p><span style='color:red'><b>Zostało kilka miejsc parkingowych!</b></span></p>
        @else
            <p>Zostało {{ $availableParkingSpotCount }} miejsc parkingowych.</p>
        @endif
        <?php $i=1 ?>
    </div>
    <table align='center' id='parking'><tr><td class='rzad'>{{ $i }}</td>
        @foreach($parkingSpots as $parkingSpot)
            @if($parkingSpot->user_id == NULL)
                <td style="background-color:green">
                    <a href={{ route("ticket.selected", ['id_seansu' => $screening->id, 'numer_miejsca_parkingowego' => $parkingSpot->parking_spot_number ]) }}><b>{{ $parkingSpot->parking_spot_number }}</b></a>
                </td>
            @else
            <td style='background-color:red'><b>{{ $parkingSpot->parking_spot_number }}</b></td>
            @endif
            @if ($parkingSpot->parking_spot_number % 10 == 0)
                <td class='rzad'>{{ $i }}</td></tr>
                <?php $i++; ?>
                @if($parkingSpot->parking_spot_number != $parkingSpotCount)
                        <tr><td class='rzad'>{{ $i }}</td>
                @endif
            @endif
        @endforeach
        @if($parkingSpotCount % 10!=0)
            @while($parkingSpotCount % 10!=0)
                <td class='puste'></td>
                <?php $parkingSpotCount++ ?>
             @endwhile
                <td class='rzad'>{{ $i }}</td></tr>
        @endif
	</table>
        @if(session('message'))
            <span><b>{{ session('message') }}</b></span>
        @endif

@endsection
