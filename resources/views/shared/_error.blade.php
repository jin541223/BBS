@if(count($errors) > 0)
    <div class="alert alert-danger">
        <div class="mt-2"><b>错误信息：</b></div>
        <ul class="mt-2 mb-2">
            @foreach($errors->all() as $error)
            <li><i class="glyphicon glyphicom-remove"></i>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
