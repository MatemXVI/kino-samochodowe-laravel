@extends('app')

@section('title', 'Seanse')

@section('scripts')

		<script>
			function disable(checkbox,form){
				if(document.getElementById(checkbox).checked == true){
					document.getElementById(form).disabled = false
				}else{
					document.getElementById(form).disabled = true
				}
			}
		</script>

@endsection

@section('left-select')
    <div class="pasek_z_menu">
        <div class ="wybor1">
            <form method="get" id="repertuar">
                <select class="select_index" name="film" onchange="this.form.submit()">
                    @if($filmId)
                        @foreach($films as $film)
                            <option value={{ $film->id }} > {{ $film->title }} </option>
                        @endforeach
                        <option value=''>Wszystkie filmy</option>
                    @else
                        <option value=''>Wszystkie filmy</option>
                        @foreach($films as $film)
                            <option value={{ $film->id }} > {{ $film->title }} </option>
                        @endforeach
                    @endif
                </select>
        </div>
    <div class = "menu">

@endsection

@section('right-select')

    </div>
    <div class ="wybor">
            <select class="select_index" name="miejsce_seansu" onchange="this.form.submit()">
            @if($venueId)
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
        </div>
    <div style="clear:both"></div>
</div>

@endsection

@section('content')
    <div class="tydzien">
        <div class="dni">
            <ul>
                @for ($i = 0; $i < 7; $i++)
                <?php $day = \Carbon\Carbon::today()->addDays($i); ?>
                <li class="dzien">
                    <button type="submit" class="przycisk" name="date" value="{{ $day->format('Y-m-d') }}">
                        <div>{{ mb_convert_case($day->translatedFormat('D'), MB_CASE_TITLE, 'UTF-8') }}</div>
                        <div>{{ $day->format('d.m') }}</div>
                    </button>
                </li>
                @endfor
            </ul>
        </div>
        <div class="data_pasek">Wybierz inną datę: <label><input type="checkbox" id="chbx_data" onclick="disable('chbx_data','data')"><input type="date" id="data" name='date' title="Wybierz datę" onchange="this.form.submit()" disabled></label></div>
        <div class="all">
            <button type='submit' class='przycisk' name="wszystko"><b>Pokaż seanse na tydzień</b></button>
        </div>
    </form>
@if($screenings->isNotEmpty())
        @if($venueId)
            <h3>Seanse w: {{ $venues[0]->city }}, ul.{{ $venues[0]->street }} </h3>
        @endif
    </div>
    <div class="movies">
    {{-- Wszystkie miejsca i wszystkie filmy --}}
    <?php $i = 0; ?>
    @foreach($screenings as $screening)
            @if($i == 0)
                <div class = "linia_repertuaru">
            @endif
		<div class="repertuar">
            <div><img src={{ Storage::url($screening->path.$screening->poster_filename) }} alt='' width='261' height='377'></div>
            <a href="{{ route('screenings.show', $screening->id) }}" title='Informacje o seansie'>{{ $screening->name }}</a>
            <a href="{{ route('tickets.parking', ['id_seansu' => $screening->id]) }}" > <b>{{ $screening->hour }}</b></a>
                <div class='krotki_opis'>
                    {{ $screening->date }} | {{ $screening->name }} | {{ $screening->venue->city }} | {{ $screening->venue->street }}
                </div>
        </div>
            <?php $i++ ?>
            @if($i%3==0)
                </div><div style='clear:both'></div><hr>
            @endif
        @endforeach
            @if($i%3!=0)
                </div><div style='clear:both'></div><hr>
                <?php $i = 0; ?>
            @endif

    </div>
@else
<h2>Brak seansów!</h2>
@endif

@endsection
