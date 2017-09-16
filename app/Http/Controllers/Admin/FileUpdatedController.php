<?php

namespace App\Http\Controllers\Admin;

use App\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\Files\FileUpdatesApproved;
use App\Mail\Files\FileUpdatesRejected;

class FileUpdatedController extends Controller
{
    /**
     * List all the files that have been updated and need to be re-approved.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $files = File::whereHas('approvals')->oldest()->get();

        return view('admin.files.updated.index', [
            'files' => $files
        ]);
    }

    /**
     * Approve the changes.
     *
     * @param File $file
     * @return mixed
     */
    public function update(File $file)
    {
        $file->mergeApprovalProperties();
        $file->approveAllUploads();
        $file->deleteAllApprovals();
        $file->updateToBeVisible();

        Mail::to($file->user)->queue(new FileUpdatesApproved($file));

        return back()->withSuccess("The file {$file->title} changes have been approved.");
    }

    /**
     * Reject the changes.
     *
     * @param File $file
     * @return mixed
     */
    public function destroy(File $file)
    {
        $file->deleteAllApprovals();
        $file->deleteUnapprovedUploads();

        Mail::to($file->user)->queue(new FileUpdatesRejected($file));

        return back()->withSuccess("The file {$file->title} changes have been rejected");
    }
}
