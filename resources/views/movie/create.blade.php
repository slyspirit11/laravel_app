@include('layout.header')
@include('movie.navbar')

<div class="container">
    <form action="{{ action('App\Http\Controllers\MovieController@store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-4">
                <label for="validationTitle" class="form-label">Название</label>
                <input type="text" name="title" class="form-control" id="validationTitle" value="Кино" required autocomplete="off">
            </div>
        </div>
        @error('title') {{$message}} @enderror
        <div class="row g-3">
            <div class="col-md-4">
                <label for="validationServer02" class="form-label">Режиссёр</label>
                <input type="text" name="director" class="form-control" id="validationServer02" value="Человек" required>
            </div>
        </div>
        @error('director') {{$message}} @enderror
        <div class="row g-3">
            <div class="col-md-4">
                <label for="validationServerUsername" class="form-label">Год</label>
                <div class="input-group">
                    <input type="number" name="year" class="form-control" id="validationServerUsername"  value="2000" required>
                </div>
            </div>
        </div>
        @error('year') {{$message}} @enderror
        <div class="row g-3">
            <div class="col-md-6">
                <label for="validationSynopsys" class="form-label">Описание</label>
                <textarea type="textarea" name="synopsys" class="form-control is-valid" id="validationSynopsys" rows="4"></textarea>
            </div>
        </div>
        @error('synopsys') {{$message}} @enderror
        <div class="row g-3">
            <div class="col-md-3">
                <label for="validationPoster" class="form-label">Постер</label>
                <input type="file" name="poster" class="form-control is-valid" id="validationPoster" accept=".jpg, .jpeg, .png">
            </div>
            <div class="col-md-3">
                @error('poster') {{$message}} @enderror
            </div>
            <div class="col-12 g-3">
                <button class="btn btn-primary" type="submit">Добавить</button>
            </div>
        </div>
    </form>
</div>

@include('layout.footer')
