@extends('layouts.user')
@section('title')
    {{ $title }}
@endsection

@section('user_name')
    {{ $user->name }}
@endsection

@section('link')
    <li class="active"><a href="#">Home</a></li>
    <li> <span class="ion-ios-arrow-right"></span>FAVORITE MOVIES</li>
@endsection

@section('user_details')
    <li><a href="{{ URL::Route('user_profile', Session::get('userId')) }}">Profile</a></li>
    <li class="active"><a href="#">Favorite movies</a></li>
    <li><a href="{{ URL::Route('user_rate', Session::get('userId')) }}">Rated movies</a></li>
    <li><a href="{{ URL::Route('user_histories', Session::get('userId')) }}">Histories Views</a></li>
@endsection

@section('user_img')
    <img src="{{Voyager::image($user->avatar)}}" alt="">
@endsection

@section('user_contents')
    <div class="topbar-filter user">
        <p>Found <span>{{$favorites_list->count()}} movies</span> in total</p>
        <label>Sort by:</label>
        <select>
            <option value="range">-- Choose option --</option>
            <option value="saab">-- Choose option 2--</option>
        </select>
        <a href="#" id="1" onclick="change(this.id)" class="list"><i class="ion-ios-list-outline active"
                id="list"></i></a>
        <a href="#" id="0" onclick="change(this.id)" class="grid"><i class="ion-grid "
                id="grid"></i></a>
    </div>

    <div id="listView">
        <div class="flex-wrap-movielist user-fav-list">
            @foreach ($favorites_list as $favorite)
                <div class="movie-item-style-2">
                    <img style="width: 100px; height: 153px" src="{{Voyager::image($favorite->image)}}" alt="">
                    <div class="mv-item-infor">
                        <h6><a href="{{$favorite->series != NULL ? URL::Route('series_single', $favorite->slug) : URL::Route('movie_single', $favorite->slug)}}">{{$favorite->title}} <span>({{date_format(new DateTime($favorite->date_release), 'Y')}})</span></a></h6>
                        <p class="rate"><i class="ion-android-star"></i><span>{{round($favorite->avg_stars,1)}}</span> /10</p>
                        {!!$favorite->overview!!}
                        <p class="run-time"> Run Time: {{date('h\h\ i\p', mktime(0, $favorite->runtime))}} . <span>MMPA: PG-13 </span> .
                            <span>Release: {{date_format(new DateTime($favorite->date_release), 'd-M-Y')}} </span></p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="topbar-filter">
            <label>Page:</label>
            <span>{{$favorites_list->currentPage()}} of {{ceil($favorites_list->total()/$favorites_list->perPage())}}:</span>

            <div class="pagination2">
                {{$favorites_list->links()}}
            </div>
        </div>
    </div>

    <div>
        <div id="gridView" style="display: none;">
            <div class="flex-wrap-movielist grid-fav">
                @foreach ($favorites_grid as $item)
                    <div class="movie-item-style-2 movie-item-style-1 style-3">
                        <img style="width: 160px; height: 250px" src="{{Voyager::image($item->image)}}" alt="">
                        <div class="hvr-inner">
                            <a href="{{$item->series != NULL ? URL::Route('series_single', $item->slug) : URL::Route('movie_single', $item->slug)}}"> Read more <i class="ion-android-arrow-dropright"></i> </a>
                        </div>
                        <div class="mv-item-infor">
                            <h6><a href="moviesingle.html">{{$item->title}}</a></h6>
                            <p class="rate"><i class="ion-android-star"></i><span>{{round($item->avg_stars,1)}}</span> /10</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div id="gridViewPagi" style="display: none" class="topbar-filter">
            <label>Page:</label>
            <span>{{$favorites_grid->currentPage()}} of {{ceil($favorites_grid->total()/$favorites_grid->perPage())}}:</span>

            <div class="pagination2">
                {{$favorites_grid->links()}}
            </div>
        </div>
    </div>
    {{-- <div class="topbar-filter">
        <label>Movies per page:</label>
        <select>
            <option value="range">5 Movies</option>
            <option value="saab">10 Movies</option>
        </select>

        <div class="pagination2">
            <span>Page 1 of 2:</span>
            <a class="active" href="#">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#">...</a>
            <a href="#">78</a>
            <a href="#">79</a>
            <a href="#"><i class="ion-arrow-right-b"></i></a>
        </div>
    </div> --}}

    <script>
        function change(id) {
            if (id == 1) {
                document.getElementById("list").classList.add("active");
                document.getElementById("grid").classList.remove("active");
                document.getElementById("listView").style.display = "block";
                document.getElementById("gridView").style.display = "none";
                document.getElementById("gridViewPagi").style.display = "none";
            } else {
                document.getElementById("grid").classList.add("active");
                document.getElementById("list").classList.remove("active");
                document.getElementById("listView").style.display = "none";
                document.getElementById("gridView").style.display = "flex";
                document.getElementById("gridViewPagi").style.display = "flex";
            }
        }
    </script>


@endsection
