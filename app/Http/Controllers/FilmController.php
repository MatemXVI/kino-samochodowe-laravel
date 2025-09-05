<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\FilmImage;
use App\Models\Screening;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
Carbon::setLocale("pl");

class FilmController extends Controller
{

    private function getPathPoster($id){
        return "img/films/".$id."/poster/";
    }

    private function getPathImages($id){
        return "img/films/".$id."/images/";
    }

    public function show(Film $film){
        $title = $film->title;
        $screenings = Screening::with(["film","venue"])->where("film_id", $film->id)->orderBy("date")->get();
        $images = FilmImage::where("film_id", $film->id)->get();
        $path_poster = $this->getPathPoster($film->id);
        $path_images = $this->getPathImages($film->id);
        return view('main.films.show', compact('film','title', 'screenings', 'images','path_images', 'path_poster'));
    }

    public function index(Request $request){
        $venueId = $request->query("miejsce_seansu");
        $date = $request->query("data");
        $all =  $request->query("wszystko");
        $queryFilms = "SELECT DISTINCT films.* FROM `films` INNER JOIN screenings ON screenings.film_id = films.id ";
        $queryDate = "SELECT screenings.id, DATE_FORMAT(screenings.hour, '%H:%i') AS hour FROM `screenings` INNER JOIN films ON films.id = screenings.film_id WHERE films.id= ? ";

        //pasek select z miejscami
        if($venueId){
            $venues = Venue::orderByRaw('(id = ?) DESC, city', [$venueId])->get();
            $isVenue = Venue::find($venueId);
        }else{
            $venues = Venue::orderBy("city")->get();
        }

        if(!$venueId || $isVenue === null){
                if($date){
                    $films = DB::select($queryFilms."WHERE screenings.date = ? ORDER BY screenings.date", [$date]);
                    foreach ($films as $film){
                        $hours = DB::select($queryDate."AND screenings.date = ? ORDER BY `hour` ASC", [$film->id, $date]);
                        $film->hours = $hours;
                        $film->path = $this->getPathPoster($film->id);
                    }

                 }else{
                    $films = DB::select($queryFilms);
                    foreach ($films as $film){
                        $hours = DB::select($queryDate."ORDER BY `hour` ASC", [$film->id]);
                        $film->hours = $hours;
                        $film->path = $this->getPathPoster($film->id);
                    }

                }
        }else{
                if($date){
                    $films = DB::select($queryFilms."WHERE screenings.date = ? AND screenings.venue_id = ? ORDER BY screenings.date", [$date, $venueId]);
                    foreach($films as $film){
                        $hours = DB::select($queryDate." AND screenings.venue_id = ? AND screenings.date = ? ORDER BY `hour` ASC", [$film->id, $venueId, $date]);
                        $film->hours = $hours;
                        $film->path = $this->getPathPoster($film->id);
                    }

                }
                else{
                    $films = DB::select($queryFilms."WHERE screenings.venue_id = ?", [$venueId]);
                    foreach($films as $film){
                        $hours = DB::select($queryDate."AND screenings.venue_id = ? ORDER BY `hour` ASC", [$film->id, $venueId]);
                        $film->hours = $hours;
                        $film->path = $this->getPathPoster($film->id);
                    }
                }
            }
        return view("main.films.index", compact("venues", "venueId", "films"));
    }

}
