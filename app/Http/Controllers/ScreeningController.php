<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use App\Models\Venue;
use App\Models\Screening;
use Carbon\Carbon;
Carbon::setLocale("pl");

class ScreeningController extends Controller
{
    public function show(Screening $screening){
        $screening->load(["venue"]);
        $name = $screening->name;
        $path = $screening->getPath();
        return view('main.screenings.show', compact('screening', 'name', 'path'));
    }

    public function index(Request $request){
        $filmId = $request->query("film");
        $venueId = $request->query("miejsce_seansu");
        $date = $request->query("date");
        $all =  $request->query("wszystko");

        $query = Screening::with(["film", "venue"]);

        //pasek select z filmami
        if($filmId){
            $films = Film::orderByRaw('(id = ?) DESC, title', [$filmId])->get();
            $isFilm = Film::find($filmId);
        }else{
            $films = Film::orderby("title")->get();
        }

        //pasek select z miejscami
        if($venueId){
            $venues = Venue::orderByRaw('(id = ?) DESC, city', [$venueId])->get();
            $isVenue = Venue::find($venueId);
        }else{
            $venues = Venue::orderby("city")->get();
        }


        if(!$venueId || $isVenue === null){
            if(!$filmId|| $isFilm === null){  //wszystkie miejsca i wszystkie filmy
                if($date){
                    $screenings = $query->where("date", $date)->orderBy("date")->get();
                // }else if($all){
                //    return redirect(route("seanse.show")); //jezeli jest zmiena $all, wykonuje się poniższe else
                 }else{
                    $screenings = $query->orderBy("date")->get();
                }
            }else{ //wszystkie miejsca i jeden film
                if($date){
                    $screenings = $query->where("date", $date)->where("film_id", $filmId)->orderBy("date")->get();
                }
                else{
                    $screenings = $query->where("film_id", $filmId)->orderBy("date")->get();
                }
            }
        }else{
            if(!$filmId || $isFilm === null){ //jedno miejsce i wszystkie filmy
                if($date){
                    $screenings = $query->where("date", $date)->where("venue_id", $venueId)->orderBy("date")->get();
                }
                else{
                    $screenings = $query->where("venue_id", $venueId)->orderBy("date")->get();
                }
            }else{ //jedno miejsce i jeden film
                if($date){
                $screenings = $query->where("date", $date)->where("film_id", $filmId)->where("venue_id", $venueId)->orderBy("date")->get();
                }
                else{
                    $screenings = $query->where("film_id", $filmId)->where("venue_id", $venueId)->orderBy("date")->get();
                }
            }
        }
        foreach($screenings as $screening){
            $screening->path = $screening->getPath();
        }

        return view("main.screenings.index", compact("filmId", "venueId", "films", "venues", "screenings"));
    }

}
