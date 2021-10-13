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
                                <img class="card-img-top" src="data:image/jpeg;base64,{{chunk_split(base64_encode($currentMovie->poster))}}" class="img-fluid rounded-start" alt="">
                            </div>
                            <div class="col-md-9">
                                <div class="card-body d-inline-block">
                                    <h3 class="card-title text-left fw-bold">{{$currentMovie->name}}</h3>
                                    <h4 class="card-title text-left text-muted">Режиссёр: {{$currentMovie->director}}</h4>
                                    <h4 class="card-title text-left text-muted">Год: {{$currentMovie->year}}</h4>
                                    <p class="text-left">{{$currentMovie->synopsys}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btn-closeModal" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-success">Редактировать</button>
                <button type="button" class="btn btn-danger">Удалить</button>
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
