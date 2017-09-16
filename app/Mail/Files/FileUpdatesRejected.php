<?php

namespace App\Mail\Files;

use App\File;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FileUpdatesRejected extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $file;

    public $user;

    /**
     * FileApproved constructor.
     * @param $file
     * @param $user
     */
    public function __construct(File $file)
    {
        $this->file = $file;
        $this->user = $file->user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your file updates have been rejected')
            ->view('emails.files.updated.rejected');
    }
}
