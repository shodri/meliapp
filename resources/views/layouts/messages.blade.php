<br>
@if (session()->has('success'))
<div class="col-md-12">
    <div class="alert alert-success mt-2">
        {{ session()->get('success') }}
    </div>
</div>
@endif

@if ($errors->any())
<div class="col-md-12">

    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif