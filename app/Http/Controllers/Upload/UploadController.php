<?php

namespace App\Http\Controllers\Upload;

use Storage;
use App\File;
use App\Upload;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    /**
     * UploadController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @param File $file
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, File $file)
    {
        $this->authorize('touch', $file);

        $uploadedFile = $request->file('file');

        $upload = $this->storeUpload($file, $uploadedFile);

        Storage::disk('local')->putFileAs(
            'files/' . $file->identifier,
            $uploadedFile,
            $upload->filename
        );

        return response()->json([
            'id' => $upload->id
        ]);
    }

    /**
     * Destroy.
     *
     * @param File $file
     * @param Upload $upload
     */
    public function destroy(File $file, Upload $upload)
    {
        $this->authorize('touch', $file);
        $this->authorize('touch', $upload);

        if ($file->uploads->count() === 1) {
            return response()->json([], 422);
        }

        $upload->delete();
    }

    /**
     * @param File $file
     * @param UploadedFile $uploadedFile
     * @return Upload
     */
    protected function storeUpload(File $file, UploadedFile $uploadedFile)
    {
        $upload = new Upload;

        $upload->fill([
            'filename' => $this->generateFilename($uploadedFile),
            'size' => $uploadedFile->getSize(),
        ]);

        $upload->file()->associate($file);
        $upload->user()->associate(auth()->user());
        $upload->save();

        return $upload;
    }

    /**
     * Generate a name for the uploaded file.
     *
     * @param UploadedFile $uploadedFile
     * @return null|string
     */
    protected function generateFilename(UploadedFile $uploadedFile)
    {
        return $uploadedFile->getClientOriginalName();
    }
}
