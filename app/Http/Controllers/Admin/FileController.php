<?php

namespace App\Http\Controllers\Admin;

use App\File;
use App\Http\Controllers\Controller;

class FileController extends Controller
{
    /**
     * Show the file.
     *
     * @param File $file
     */
    public function show(File $file)
    {
        $this->replaceFilePropertiesWithUnapprovedChanges($file);

        return view('files.show', [
            'file' => $file,
            'uploads' => $file->uploads
        ]);
    }

    /**
     * Replace file properties with unapproved changes.
     *
     * @param File $file
     */
    protected function replaceFilePropertiesWithUnapprovedChanges(File $file)
    {
        if ($file->approvals->count()) {
            $file->fill($file->approvals->first()->toArray());
        }
    }
}
