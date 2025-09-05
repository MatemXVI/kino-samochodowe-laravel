@extends('app')

@section('title', 'Kino samochodowe')

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

	<div class="pasek_z_menu" style="margin-left:611px;">
		<div class = "menu">

@endsection

@section('right-select')

            </div>
        </div>
     <div class ="wybor">
        <form method="get" id="repertuar" class="users">
            <select class="select_index" name="miejsce_seansu" onchange="this.form.submit()">
            @if($venueId)
                @foreach($venues as $venue)
                    <option value="{{ $venue->id }}"> {{ $venue->city }}, ul.{{ $venue->street }} </option>
                @endforeach
                <option value=''>Wszystkie miejsca</option>
            @else
                <option value=''>Wszystkie miejsca</option>
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
                    <button type="submit" class="przycisk" name="data" value="{{ $day->format('Y-m-d') }}">
                        <div>{{ mb_convert_case($day->translatedFormat('D'), MB_CASE_TITLE, 'UTF-8') }}</div>
                        <div>{{ $day->format('d.m') }}</div>
                    </button>
                </li>
                @endfor
            </ul>
        </div>
        <div class="data_pasek">Wybierz inną datę: <label><input type="checkbox" id="chbx_data" onclick="disable('chbx_data','data')"><input type="date" id="data" name='data' title="Wybierz datę" onchange="this.form.submit()" disabled></label></div>
        <div class="all">
            <button type='submit' class='przycisk' name="wszystko"><b>Pokaż repertuar na tydzień</b></button>
        </div>
    </form>
        @if($venueId)
            <h3>Filmy w: {{ $venues[0]->city }}, ul.{{ $venues[0]->street }} </h3>
        @endif
    </div>
@if($films != null)
    <div class="movies">
        <?php $i = 0; ?>
        @foreach($films as $film)
                @if($i == 0)
                    <div class = "linia_repertuaru">
                @endif
                <div class="repertuar">
                @if (!empty($film->poster_filename))
                    <div><img src={{ Storage::url($film->path.$film->poster_filename) }}  alt='' width='261' height='377'></div>
                @endif
                <a href="{{ route('films.show', $film->id) }}" title='Informacje o seansie'>{{ $film->title }}</a>

                @foreach($film->hours as $hour)
                    <a href="{{ route('tickets.parking', ['id_seansu' => $hour->id]) }}" > <b>{{ $hour->hour }}</b></a>
                @endforeach

                <div class='krotki_opis'>
                    {{ $film->genre }} | {{ $film->duration }} min | {{ $film->country }} | ( {{ $film->production_year }} )
                </div></div>
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
    <h2>Brak filmów!</h2>
    @endif
@endsection
