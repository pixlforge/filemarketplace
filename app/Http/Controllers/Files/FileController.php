<?php

namespace App\Http\Controllers\Files;

use App\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FileController extends Controller
{
    /**
     * Show
     *
     * @param File $file
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(File $file)
    {
        if (! $file->visible()) {
            return abort(404);
        }

        $uploads = $file->uploads()->approved()->get();

        return view('files.show', [
            'file' => $file,
            'uploads' => $uploads
        ]);
    }
}
