<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Mp3File;


class Mp3Controller extends Controller
{
    public function showUploadForm()
    {
        return view('upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'mp3_file' => 'required|mimes:mp3',
        ]);

        $file = $request->file('mp3_file');
        $fileName = $file->getClientOriginalName();

        // Stockez le fichier dans public/files/mp3
        $file->storeAs('public/files/mp3', $fileName);

        // Enregistrez les informations du fichier dans la base de données
        Mp3File::create([
            'name' => $fileName,
            'path' => 'public/files/mp3/' . $fileName,
        ]);

        return redirect()->route('upload.form')->with('success', 'Fichier MP3 téléchargé avec succès.');
    }
}
