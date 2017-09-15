<?php

namespace App\Http\Controllers\Account;

use App\File;
use App\Http\Controllers\Controller;
use App\Http\Requests\File\StoreFileRequest;
use App\Http\Requests\File\UpdateFileRequest;

class FilesController extends Controller
{
    /**
     * Show the finished files that belong to the user.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $files = auth()->user()->files()->latest()->finished()->get();

        return view('account.files.index', [
            'files' => $files
        ]);
    }

    /**
     * Create a file.
     *
     * @param File $file
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create(File $file)
    {
        if (! $file->exists) {
            $file = $this->createAndReturnSkeletonFile();
            return redirect()->route('account.files.create.finish', $file);
        }

        $this->authorize('touch', $file);

        return view('account.files.create', [
            'file' => $file
        ]);
    }

    /**
     * Store a file.
     *
     * @param StoreFileRequest $request
     * @param File $file
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreFileRequest $request, File $file)
    {
        $this->authorize('touch', $file);

        $file->fill($request->only(['title', 'overview_short', 'overview', 'price']));
        $file->finished = true;
        $file->save();

        return redirect()->route('account.files.index')
            ->with('success', 'File uploaded successfully and submitted for review.');
    }

    /**
     * Show edit view.
     *
     * @param File $file
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(File $file)
    {
        $this->authorize('touch', $file);

        return view('account.files.edit', [
            'file' => $file,
            'approval' => $file->approvals->first()
        ]);
    }

    /**
     * Update model method.
     *
     * @param File $file
     */
    public function update(File $file, UpdateFileRequest $request)
    {
        $this->authorize('touch', $file);

        $approvalProperties = $request->only(File::APPROVAL_PROPERTIES);

        if ($file->needsApproval($approvalProperties)) {
            $file->createApproval($approvalProperties);

            return back()->withSuccess('Changes applied successfully! The changes have been submitted for approval and will be reviewed shortly.');
        }

        $file->update($request->only(['live', 'price']));

        return back()->withSuccess('File successfully updated!');
    }

    /**
     * Create a skeleton for the file.
     *
     * @return mixed
     */
    protected function createAndReturnSkeletonFile()
    {
        return auth()->user()->files()->create([
            'title' => 'default file name',
            'overview_short' => 'default short overview',
            'overview' => 'default overview',
            'price' => 0,
            'finished' => false
        ]);
    }
}
