<?php

namespace App\Http\Controllers\Admin;

use App\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        
        return back()->withSuccess("The file {$file->title} changes have been rejected");
    }
}
