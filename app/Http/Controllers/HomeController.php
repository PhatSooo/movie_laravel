<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Movie;
use App\Models\Movie_Rate;

class HomeController extends Controller
{
    public $data = [];

    public function index(){
        $title = 'Index';
        $new_movies = DB::select('select * from movies order by created_at desc limit 10');
        $popular_movies = DB::select('select a.*, b.movie_id, count(b.movie_id) as views from movies a
                                join histories b on a.movie_id = b.movie_id
                                group by b.movie_id
                                order by views DESC
                                limit 10');
        $coming_soon = DB::table('movies')->where('movie_status',3)->limit(10)->get();
        $theaters = DB::table('theaters')->where('status',true)->get();
        $top_rates = DB::select('select b.*, a.movie_id, count(a.movie_id) as views from movie_rates a
                                join movies b on a.movie_id = b.movie_id group by a.movie_id order by views DESC limit 10');
        $top_reviews = DB::select('select b.*, a.movie_id, count(a.movie_id) as reviews from movie_reviews a
                                join movies b on a.movie_id = b.movie_id
                                group by a.movie_id order by reviews DESC limit 10');
        $spot_celeb = DB::select('SELECT DISTINCT d.crew_id, d.crew_name, d.image, d.position, COUNT(b.crew_id) as views/*, COUNT(c.crew_id) as views*/ FROM histories a
                                    JOIN movie_casts b ON a.movie_id = b.movie_id
                                    JOIN movie_directors c ON a.movie_id = c.movie_id
                                    JOIN crews d ON (b.crew_id = d.crew_id OR c.crew_id = d.crew_id)
                                    GROUP BY d.crew_id
                                    ORDER BY views
                                    DESC limit 5');

        return view('pages.index', compact('title','popular_movies','new_movies','theaters','coming_soon','top_rates','top_reviews','spot_celeb'));
    }

    public function movie_list(){
        $title = 'Movie List';
        $movies_list = Movie::select('*')->where('movie_status',1)->paginate(5,['*'],'list');
        $movies_grid = Movie::select('*')->where('movie_status',1)->paginate(16,['*'],'list');

        // GET genres for search
        $genres = DB::table('genres')->get();
        return view('pages.movielist', compact('title','movies_list','movies_grid','genres'));
    }

    public function series_list(){
        $title  = 'Single Seri';
        $movies = DB::select('select * from movies where series IS NOT NULL');

        // GET genres for search
        $genres = DB::table('genres')->get();
        return view('pages.serieslist', compact('title','movies','genres'));
    }

    public function celeb_list(){
        $title = 'Celebrities List';
        $crews_list = DB::table('crews')->join('countries','country_id','=','nation')->paginate(9,['*'],'list');
        $crews_grid = DB::table('crews')->join('countries','country_id','=','nation')->paginate(9,['*'],'grid');
        $nations = DB::table('countries')->get();
        return view('pages.celebritylist', compact('title','crews_list','crews_grid','nations'));
    }

    public function error(){
        $this->data['title'] = '404';
        return view('pages.404', $this->data);
    }
}
