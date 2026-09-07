@if (session('success'))
    <div class="alert alert-success"><span>✅</span><span>{{ session('success') }}</span></div>
@endif
@if (session('error'))
    <div class="alert alert-danger"><span>⚠️</span><span>{{ session('error') }}</span></div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <span>⚠️</span>
        <span>
            @foreach ($errors->all() as $error)
                {{ $error }}@if (! $loop->last)<br>@endif
            @endforeach
        </span>
    </div>
@endif
