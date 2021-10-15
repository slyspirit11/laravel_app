@include('layout.header')
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Кинокартина</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container d-flex justify-content-center">
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-3">
                                <img class="card-img-top" src="{{'/images/movies/'.$movie->poster_path}}" class="img-fluid rounded-start" alt="">
                            </div>
                            <div class="col-md-9">
                                <div class="card-body d-inline-block">
                                    <h3 class="card-title text-left fw-bold">{{$movie->title}}</h3>
                                    <h4 class="card-title text-left text-muted">Режиссёр: {{$movie->director}}</h4>
                                    <h4 class="card-title text-left text-muted">Год: {{$movie->year}}</h4>
                                    <p class="text-left">{{$movie->synopsys}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btn-closeModal" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-success position-relative">
                    Редактировать
                    <a href="/movies/{{$movie->id}}/edit" class="stretched-link"></a>
                </button>
                <form action="/movies/{{$movie->id}}" method="post">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-danger">Удалить</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        var modal = $("#exampleModal");
        modal.modal('toggle');
        modal.on('hidden.bs.modal', function () {
            window.location.href='/';
        })
        $("#btn-closeModal").click(function () {
        })
    });
</script>
@include('layout.footer')
