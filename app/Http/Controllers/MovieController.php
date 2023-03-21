<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Movie;
use App\Models\History;
use App\Models\Movie_Rate;
use App\Models\Movie_Review;
use App\Models\User_Favorite;
use Session;
use Carbon\Carbon;

class MovieController extends Controller
{
    // GET movie-single
    public function movie_single($slug){
        $title = 'Movie Single';

        $id = DB::select('select movie_id from movies where slug = "'.$slug.'"'); // GET movie_id of film

        // GET all movies
        $movie = DB::select('select * from movies where slug = ?', [$slug]);

        // GET rating of a film by a user
        $get_stars_by_user = DB::select('select movie_rates.stars from movies join movie_rates on movies.movie_id = movie_rates.movie_id
                                        where slug = ? and user_id = ?', [$slug, Session::get('userId')]);
        if (!$get_stars_by_user){
            $get_stars_by_user = json_decode('{ "stars" : 0 }');
            $get_stars_by_user = [0 => $get_stars_by_user];
        }

        $get_rates = DB::select('select count(movie_id) as count_votes, avg(stars) as avg_stars from movie_rates where movie_id = ?', [$id[0]->movie_id]);

        $get_reviews = DB::select('select a.review, a.created_at, b.stars, c.name, c.avatar
                                    from movie_reviews a join movie_rates b on a.movie_id = b.movie_id and a.user_id = b.user_id
                                    join users c on c.id = a.user_id;');

        $get_favorites = User_Favorite::where('user_id', '=', Session::get('userId'))->where('movie_id', '=', $id[0]->movie_id)->first();

        // GET gernes of a film that are showing
        $get_genres = DB::select('select genres.genre_name from movies inner join movie_genres on movies.movie_id = movie_genres.movie_id
                                inner join genres on movie_genres.genre_id = genres.genre_id where slug = ?', [$slug]);

        // GET keywords of film that are showing
        $get_keywords = DB::select('select keywords.keyword_name from movies inner join movie_keywords on movies.movie_id = movie_keywords.movie_id
                                inner join keywords on movie_keywords.keyword_id = keywords.keyword_id where slug = ?', [$slug]);

        // GET actors of film that are showing
        $get_actors = DB::select('select crews.image, crews.crew_name, movie_casts.character_name from movies inner join movie_casts on movies.movie_id = movie_casts.movie_id
                                inner join crews on movie_casts.crew_id = crews.crew_id where slug = ?', [$slug]);

        return view('pages.moviesingle', compact('title','movie','get_genres','get_keywords','get_actors','get_stars_by_user','get_rates','get_reviews','get_favorites'));
    }

    public function favorite($slug,$action){
        $id = DB::select('select movie_id from movies where slug = "'.$slug.'"'); // GET movie_id of film
        if ($action === "true"){
            $res = DB::table('user_favorites')
                    ->where('movie_id',$id[0]->movie_id)
                    ->where('user_id',Session::get('userId'))
                    ->delete();
            if ($res) return back()->with('success');
            return back()->with('fail');
        } else {
            $res = DB::table('user_favorites')->insert([
                'movie_id' => $id[0]->movie_id,
                'user_id' => Session::get('userId')
            ]);
            if ($res) return back()->with('success');
            return back()->with('fail');
        }
    }

    // POST rating movie
    public function rating_movie(Request $request){
        $rate = new Movie_Rate();
        $id = DB::select('select movie_id from movies where slug = "'.$request->slug.'"'); // GET movie_id of film
        $rate->user_id = Session::get('userId'); // GET user_id

        // Check this User has rated this film yet?
        $check_rate = DB::table('movie_rates')
                        ->where('user_id', '=', Session::get('userId'))
                        ->where('movie_id', '=', $id[0]->movie_id)
                        ->get()->count();

        // If no, insert new
        if (!$check_rate){
            $rate->movie_id = $id[0]->movie_id;
            $rate->stars = $request->true_rate;
            $res = $rate->save();
            if($res) return back()->with('success');
            return back()->with('fail');
        }

        // Else yes, just update
        $res = Movie_Rate::where('user_id', '=', Session::get('userId'))
                ->where('movie_id', '=', $id[0]->movie_id)
                ->update(['stars' => $request->true_rate]);
        if ($res)
            return back()->with('success');
        return back()->with('fail');
    }

    // POST write review
    public function review(Request $request){
        $review =  new Movie_Review();
        $id = DB::select('select movie_id from movies where slug = "'.$request->slug.'"');
        $review->user_id = Session::get('userId');
        $review->movie_id = $id[0]->movie_id;
        $review->review = $request->review;

        $res = $review->save();
        if($res) return back()->with('success');
        return back()->with('fail');
    }

    // POST store history
    public function history(Request $request){
        $his = new History();
        $user_id = $request->user_id;
        $movie_id = $request->movie_id;

        $check_his = DB::table('histories')
                        ->where('user_id', '=', $user_id)
                        ->where('movie_id', '=', $movie_id)
                        ->get()->count();
        if (!$check_his){
            $his->user_id = $user_id;
            $his->movie_id = $movie_id;
            $his->save();
        }
        else {
            $check_minute = DB::select('select updated_at from histories where user_id = ? and movie_id = ?', [$user_id,$movie_id]);
            $distance = Carbon::parse($check_minute[0]->updated_at)->diff(Carbon::parse(date('Y-m-d H:i:s')));
            if ($distance->i > 30){
                History::where('user_id', '=', $user_id)
                ->where('movie_id', '=', $movie_id)
                ->update(['updated_at' => date('Y-m-d H:i:s')]);
            }
            else {
                $his->user_id = $user_id;
                $his->movie_id = $movie_id;
                $his->save();
            }
        }
    }

    // GET search
    public function search($type){
        switch($type){
            case '':
        }
    }

    // POST search
    public function movie_search(Request $request){
        $name = $request->movie;
        $genres = $request->genres;
        $rates = $request->rates;
        $fYear = $request->fYear;
        $tYear = $request->tYear;
        $crewId = $request->crewId;
        $search = '';
        $s = '';
        if ($name) {
            $s = 'name-'.$name;
            $search = DB::table('movies')->whereRaw('title like "%'.$name.'%"');
        } else if ($genres){
            $s = implode(',',$genres);
            $search = DB::table('movie_genres')->select('movies.*')
                            ->join('movies','movies.movie_id','=','movie_genres.movie_id')
                            ->groupBy('movie_genres.movie_id')
                            ->whereIn('genre_id',$genres);
        } else if ($rates){
            $s = 'rates-'.$rates;
            switch ($rates) {
                case 'under5':
                    $search = DB::table('movie_rates')->select(['movies.*',DB::raw('avg(stars) as avg_star')])
                            ->join('movies','movie_rates.movie_id','=','movies.movie_id')
                            ->groupBy('movie_rates.movie_id')
                            ->having('avg_star','<',5);
                    break;
                case '5to8':
                    $search = DB::table('movie_rates')->select(['movies.*',DB::raw('avg(stars) as avg_star')])
                            ->join('movies','movie_rates.movie_id','=','movies.movie_id')
                            ->groupBy('movie_rates.movie_id')
                            ->havingBetween('avg_star',[5,8]);
                    break;
                case 'upper8':
                    $search = DB::table('movie_rates')->select(['movies.*',DB::raw('avg(stars) as avg_star')])
                            ->join('movies','movie_rates.movie_id','=','movies.movie_id')
                            ->groupBy('movie_rates.movie_id')
                            ->having('avg_star','>',8);
                    break;
            }
        } else if ($fYear && $tYear) {
            $s = $fYear.'-'.$tYear;
            $search = DB::table('movies')->whereBetween(DB::raw('year(date_release)'),[$fYear,$tYear]);
        } else {
            if ($request->posion == 0){
                $s = 'actor-'.$crewId;
                $search = DB::table('crews')->select('movies.*')
                            ->join('movie_casts','crews.crew_id','=','movie_casts.crew_id')
                            ->join('movies','movie_casts.movie_id','=','movies.movie_id')
                            ->where('crews.crew_id',$crewId);
            }
            else {
                $s = 'crews-'.$crewId;
                $search = DB::table('crews')->select('movies.*')
                            ->join('movie_directors','crews.crew_id','=','movie_directors.crew_id')
                            ->join('movies','movie_casts.movie_id','=','movies.movie_id')
                            ->where('crews.crew_id',$crewId);
            }
        }
        return redirect()->route('movies','search?='.$s)->with(['search' => $search->paginate(5,['*'],'list')]);
    }
}
