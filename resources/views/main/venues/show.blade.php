@extends('app')

@section('title', 'Miejsce seansu')

@section('content')

    <div class="z_miejscami">
        <div id="wybor_miejsca">
            <form method="get">
                <select class="select_index" name="id_miejsca" onchange="window.location.href = '/venues/' + this.value">
                    @if($id)
                        @foreach($venues as $venue)
                            <option value="{{ $venue->id }}"> {{ $venue->city }}, ul.{{ $venue->street }} </option>
                        @endforeach
                    @else
                        <option value=''>Wybierz miejsce seansu</option>
                        @foreach($venues as $venue)
                            <option value="{{ $venue->id }}"> {{ $venue->city }}, ul.{{ $venue->street }} </option>
                        @endforeach
                    @endif
                </select>
            </form>
        </div>
        @if($id)
        <div id="informacje_miejsce">
            <div class="linia"><b>Miejscowość:</b> {{ $venues[0]->city }} ul. {{ $venues[0]->street }} <hr></div>
            <div class="linia"><b>Rodzaj miejsca:</b> {{ $venues[0]->place_type }}<hr></div>
            <div class="linia"><b>Ilość miejsc:</b> {{ $venues[0]->parking_spot_count }}<hr></div>
            @if( $venues[0]->additional_info != NULL)
                <div class="linia">{{ $venues[0]->additional_info }} <hr></div>
            @endif
        </div>
            <h3>Zdjęcia miejsca:</h3>
            <div id="zdjecia">
                @foreach($images as $image)
                    <div class="zdjecie"><img src = {{ Storage::url($path.$image->image_filename) }} width="500px" height="250px"></div>
                @endforeach
            </div>
        <div style="clear:both"></div>
        <div>
            <h3>Najbliższe seanse:</h3>
            @foreach($screenings as $screening)
                <a href={{ route('screenings.show',  $screening->id)}} title="Informacje o seansie">{{ $screening->name }}
                <a href={{ route('tickets.parking', ['id_seansu' => $screening->id]) }} > <b>{{ $screening->hour }}</b></a>
                <div class='krotki_opis'>
                    {{ $screening->date }} | {{ $screening->name }} <hr>
                </div>
            @endforeach
        @endif
    </div>

@endsection
