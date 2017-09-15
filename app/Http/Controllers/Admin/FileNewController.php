<?php

namespace App\Http\Controllers\Admin;

use App\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FileNewController extends Controller
{
    /**
     * Index view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $files = File::unapproved()->finished()->oldest()->get();

        return view('admin.files.new.index', [
            'files' => $files
        ]);
    }

    /**
     * Approve the file.
     *
     * @param File $file
     * @return mixed
     */
    public function update(File $file)
    {
        $file->approve();

        return back()->withSuccess("{$file->title} has been successfully approved.");
    }

    /**
     * Reject the file.
     *
     * @param File $file
     * @return mixed
     */
    public function destroy(File $file)
    {
        $file->delete();
        $file->uploads->each->delete();

        return back()->withSuccess("The file {$file->title} has been rejected.");
    }
}
