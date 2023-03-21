@extends('layouts.master')

{{-- Access to user feature without sigin --}}
@if (session('fail'))
    <script>
        alert('You Must Be Login First');
    </script>
@endif

@section('contents')
    <div class="slider movie-items">
        <div class="container">
            <div class="row">
                <div class="social-link">
                    <p>Follow us: </p>
                    <a href="#"><i class="ion-social-facebook"></i></a>
                    <a href="#"><i class="ion-social-twitter"></i></a>
                    <a href="#"><i class="ion-social-googleplus"></i></a>
                    <a href="#"><i class="ion-social-youtube"></i></a>
                </div>
                <div class="slick-multiItemSlider">
                    @foreach ($new_movies as $movie)
                        <div class="movie-item">
                            <div class="mv-img">
                                <a href="{{$movie->series != NULL ? URL::Route('series_single', $movie->slug) : URL::Route('movie_single', $movie->slug)}}"><img src="{{ Voyager::image($movie->image) }}" alt=""
                                        width="285" height="437"></a>
                            </div>
                            <div class="title-in">
                                {{-- <div class="cate">
                                    <span class="blue"><a href="#">Sci-fi</a></span>
                                </div> --}}
                                <h6><a href="{{$movie->series != NULL ? URL::Route('series_single', $movie->slug) : URL::Route('movie_single', $movie->slug)}}">{{ $movie->title }}</a></h6>
                                {{-- <p><i class="ion-android-star"></i><span>{{$movie->avg_star}}</span> /10</p> --}}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="movie-items">
        <div class="container">
            <div class="row ipad-width">
                <div class="col-md-8">
                    <div class="title-hd">
                        <h2>Movies</h2>
                        <a href="#" class="viewall">View all <i class="ion-ios-arrow-right"></i></a>
                    </div>
                    <div class="tabs">
                        <ul class="tab-links">
                            <li class="active"><a href="#tab1">#Popular</a></li>
                            <li><a href="#tab3"> #Top rated </a></li>
                            <li><a href="#tab4"> #Most reviewed</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab1" class="tab active">
                                <div class="row">
                                    <div class="slick-multiItem">
                                        @foreach ($popular_movies as $movie)
                                            <div class="slide-it">
                                                <div class="movie-item">
                                                    <div class="mv-img">
                                                        <img src="{{ Voyager::image($movie->image) }}"
                                                            alt="" width="185" height="284">
                                                    </div>
                                                    <div class="hvr-inner">
                                                        <a href="{{$movie->series != NULL ? URL::Route('series_single', $movie->slug) : URL::Route('movie_single', $movie->slug)}}"> Read
                                                            more <i class="ion-android-arrow-dropright"></i> </a>
                                                    </div>
                                                    <div class="title-in">
                                                        <h6><a href="{{$movie->series != NULL ? URL::Route('series_single', $movie->slug) : URL::Route('movie_single', $movie->slug)}}">{{ $movie->title}}</a></h6>
                                                        {{-- <p><i class="ion-android-star"></i><span>{{$movie->avg_star}}</span> /10</p> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div id="tab3" class="tab">
                                <div class="row">
                                    <div class="slick-multiItem">
                                        @foreach ($top_rates as $item)
                                            <div class="slide-it">
                                                <div class="movie-item">
                                                    <div class="mv-img">
                                                        <img src="{{Voyager::image($item->image)}}"
                                                            alt="" width="185" height="284">
                                                    </div>
                                                    <div class="hvr-inner">
                                                        <a href="#"> Read
                                                            more <i class="ion-android-arrow-dropright"></i> </a>
                                                    </div>
                                                    <div class="title-in">
                                                        <h6><a href="{{$item->series != NULL ? URL::Route('series_single', $item->slug) : URL::Route('movie_single', $item->slug)}}">{{$item->title}}</a></h6>
                                                        {{-- <p><i class="ion-android-star"></i><span>{{$item->avg_star}}</span> /10</p> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div id="tab4" class="tab">
                                <div class="row">
                                    <div class="slick-multiItem">
                                        @foreach ($top_reviews as $item)
                                            <div class="slide-it">
                                                <div class="movie-item">
                                                    <div class="mv-img">
                                                        <img src="{{Voyager::image($item->image)}}"
                                                            alt="" width="185" height="284">
                                                    </div>
                                                    <div class="hvr-inner">
                                                        <a href="#"> Read
                                                            more <i class="ion-android-arrow-dropright"></i> </a>
                                                    </div>
                                                    <div class="title-in">
                                                        <h6><a href="{{$item->series != NULL ? URL::Route('series_single', $item->slug) : URL::Route('movie_single', $item->slug)}}">{{$item->title}}</a></h6>
                                                        {{-- <p><i class="ion-android-star"></i><span>{{$item->avg_star}}</span> /10</p> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="title-hd">
                        <h2>coming soon</h2>
                        <a href="#" class="viewall">View all <i class="ion-ios-arrow-right"></i></a>
                    </div>
                    <div class="tabs">
                        <ul class="tab-links-2">
                            <li class="active"><a href="#tab22"> #Coming soon</a></li>
                        </ul>
                        <div class="row">
                            <div class="slick-multiItem">
                                @foreach ($coming_soon as $item)
                                    <div class="slide-it">
                                        <div class="movie-item">
                                            <div class="mv-img">
                                                <img src="{{ Voyager::image($item->image) }}"
                                                    alt="" width="185" height="284">
                                            </div>
                                            <div class="hvr-inner">
                                                <a href="#"> Read
                                                    more <i class="ion-android-arrow-dropright"></i> </a>
                                            </div>

                                            <div class="title-in">
                                                <h6><a href="#">{{$item->title}}</a></h6>
                                                {{-- <p><i class="ion-android-star"></i><span>7.4</span> /10</p> --}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="sidebar">
                        <div class="ads">
                            <img src="{{ asset('assets/images/uploads/ads1.png') }}" alt="" width="336"
                                height="296">
                        </div>
                        <div class="celebrities">
                            <h4 class="sb-title">Spotlight Celebrities</h4>
                            @foreach ($spot_celeb as $item)
                                <div class="celeb-item">
                                    <a href="#"><img src="{{Voyager::image($item->image)}}"
                                            alt="" width="70" height="70"></a>
                                    <div class="celeb-author">
                                        <h6><a href="#">{{$item->crew_name}}</a></h6>
                                        <span>{{$item->position == 0 ? 'ACTOR' : ($item->position == 1 ? 'DIRECTOR' : 'WRITER')}}</span>
                                    </div>
                                </div>
                            @endforeach

                            <a href="{{route('celeb_list')}}" class="btn">See all celebrities<i class="ion-ios-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="trailers">
        <div class="container">
            <div class="row ipad-width">
                <div class="col-md-12">
                    <div class="title-hd">
                        <h2>in theater</h2>
                        <a href="#" class="viewall">View all <i class="ion-ios-arrow-right"></i></a>
                    </div>
                    <div class="videos">
                        <div class="slider-for-2 video-ft">
                            @foreach ($theaters as $theater)
                                <div>
                                    <iframe class="item-video" src="#"
                                        data-src="https://www.youtube.com/embed/{{$theater->trailer}}"></iframe>
                                </div>
                            @endforeach
                        </div>
                        <div class="slider-nav-2 thumb-ft">
                            @foreach ($theaters as $theater)
                                <div class="item">
                                    <div class="trailer-img">
                                        <img src="{{ Voyager::image($theater->image) }}"
                                            alt="photo by Barn Images" width="4096" height="2737">
                                    </div>
                                    <div class="trailer-infor">
                                        <h4 class="desc">{{$theater->name}}</h4>
                                        <p>Release date: <span>{{$theater->release_date ? $theater->release_date : 'Updating!'}}</span></p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <!-- latest new v1 section-->
    <div class="latestnew">
        <div class="container">
            <div class="row ipad-width">
                <div class="col-md-8">
                    <div class="ads">
                        <img src="{{ asset('assets/images/uploads/ads2.png') }}" alt="" width="728"
                            height="106">
                    </div>
                    <div class="title-hd">
                        <h2>Latest news</h2>
                    </div>
                    <div class="tabs">
                        <ul class="tab-links-3">
                            <li class="active"><a href="#tab31">#Movies </a></li>
                            <li><a href="#tab32"> #TV Shows </a></li>
                            <li><a href="#tab33"> #Celebs</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab31" class="tab active">
                                <div class="row">
                                    <div class="blog-item-style-1">
                                        <img src="{{ asset('assets/images/uploads/blog-it1.jpg') }}" alt=""
                                            width="170" height="250">
                                        <div class="blog-it-infor">
                                            <h3><a href="#">Brie Larson to play first female white house candidate
                                                    Victoria Woodull in Amazon film</a></h3>
                                            <span class="time">13 hours ago</span>
                                            <p>Exclusive: <span>Amazon Studios </span>has acquired Victoria Woodhull, with
                                                Oscar winning Room star <span>Brie Larson</span> polsed to produce, and play
                                                the first female candidate for the presidency of the United States. Amazon
                                                bought it in a pitch package deal. <span> Ben Kopit</span>, who wrote the
                                                Warner Bros film <span>Libertine</span> that has...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="tab32" class="tab">
                                <div class="row">
                                    <div class="blog-item-style-1">
                                        <img src="{{ asset('assets/images/uploads/blog-it2.jpg') }}" alt=""
                                            width="170" height="250">
                                        <div class="blog-it-infor">
                                            <h3><a href="#">Tab 2</a></h3>
                                            <span class="time">13 hours ago</span>
                                            <p>Exclusive: <span>Amazon Studios </span>has acquired Victoria Woodhull, with
                                                Oscar winning Room star <span>Brie Larson</span> polsed to produce, and play
                                                the first female candidate for the presidency of the United States. Amazon
                                                bought it in a pitch package deal. <span> Ben Kopit</span>, who wrote the
                                                Warner Bros film <span>Libertine</span> that has...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="tab33" class="tab">
                                <div class="row">
                                    <div class="blog-item-style-1">
                                        <img src="{{ asset('assets/images/uploads/blog-it1.jpg') }}" alt=""
                                            width="170" height="250">
                                        <div class="blog-it-infor">
                                            <h3><a href="#">Tab 3</a></h3>
                                            <span class="time">13 hours ago</span>
                                            <p>Exclusive: <span>Amazon Studios </span>has acquired Victoria Woodhull, with
                                                Oscar winning Room star <span>Brie Larson</span> polsed to produce, and play
                                                the first female candidate for the presidency of the United States. Amazon
                                                bought it in a pitch package deal. <span> Ben Kopit</span>, who wrote the
                                                Warner Bros film <span>Libertine</span> that has...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="morenew">
                        <div class="title-hd">
                            <h3>More news on Blockbuster</h3>
                            <a href="#" class="viewall">See all Movies news<i
                                    class="ion-ios-arrow-right"></i></a>
                        </div>
                        <div class="more-items">
                            <div class="left">
                                <div class="more-it">
                                    <h6><a href="#">Michael Shannon Frontrunner to play Cable in “Deadpool 2”</a>
                                    </h6>
                                    <span class="time">13 hours ago</span>
                                </div>
                                <div class="more-it">
                                    <h6><a href="#">French cannibal horror “Raw” inspires L.A. theater to hand out
                                            “Barf Bags”</a></h6>

                                    <span class="time">13 hours ago</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="more-it">
                                    <h6><a href="#">Laura Dern in talks to join Justin Kelly’s biopic “JT Leroy”</a>
                                    </h6>
                                    <span class="time">13 hours ago</span>
                                </div>
                                <div class="more-it">
                                    <h6><a href="#">China punishes more than 300 cinemas for box office cheating</a>
                                    </h6>
                                    <span class="time">13 hours ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="sidebar">
                        <div class="sb-facebook sb-it">
                            <h4 class="sb-title">Find us on Facebook</h4>
                            <iframe src="#"
                                data-src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Ftemplatespoint.net%2F%3Ffref%3Dts&tabs=timeline&width=300&height=315px&small_header=true&adapt_container_width=false&hide_cover=false&show_facepile=true&appId"
                                width="300" height="315" style="border:none;overflow:hidden"></iframe>
                        </div>
                        <div class="sb-twitter sb-it">
                            <h4 class="sb-title">Tweet to us</h4>
                            <div class="slick-tw">
                                <div class="tweet item" id="">
                                    <!-- Put your twiter id here -->
                                </div>
                                <div class="tweet item" id="">
                                    <!-- Put your 2nd twiter account id here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end of latest new v1 section--> --}}
@endsection

@section('title')
    {{ $title }}
@endsection
