@include('layout.header')
@include('movie.navbar')
@forelse($movies as $movie)
    <div class="container d-flex justify-content-center">
        <div class="card mb-3">
            <div class="row п-0">
                <div class="col-md-2">
                    <img class="card-img-top"
                         src="{{'/images/movies/'.$movie->poster_path}}"
                         class="img-fluid rounded-start" alt="">
                </div>
                <div class="col-md-5">
                    <div class="card-body d-inline-block">
                        <h3 class="card-title text-left fw-bold">{{$movie->title}}</h3>
                        <h4 class="card-title text-left text-muted">Режиссёр: {{$movie->director}}</h4>
                        <h4 class="card-title text-left text-muted">Год: {{$movie->year}}</h4>
                        <a href="/movies/{{$movie->id}}" class="btn btn-light stretched-link ">...cпойлер</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    <h3>There is no movie</h3>
@endforelse
<script>
    (function ($) {
        window.onbeforeunload = function (e) {
            window.name += ' [' + location.pathname + '[' + $(window).scrollTop().toString() + '[' + $(window).scrollLeft().toString();
        };
        $.maintainscroll = function () {
            if (window.name.indexOf('[') > 0) {
                var parts = window.name.split('[');
                window.name = $.trim(parts[0]);
                if (parts[parts.length - 3] === location.pathname) {
                    window.scrollTo(parseInt(parts[parts.length - 1]), parseInt(parts[parts.length - 2]));
                }
            }
        };
        $.maintainscroll();
    })(jQuery);
</script>
@include('layout.footer')
