@extends('layouts.app')
@section('content')
<style>
    
</style>
<body>
    <h1>Upload de fichiers MP3</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('upload.form') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="mp3_file">Choisir un fichier MP3</label>
        <input type="file" name="mp3_file" id="mp3_file" accept=".mp3">
        <button type="submit">Upload</button>
    </form>
</body>
@endsection
