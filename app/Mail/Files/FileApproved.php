<?php

namespace App\Mail\Files;

use App\File;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FileApproved extends Mailable implements ShouldQueue
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
        return $this->subject("Your file {$this->file->title} has been approved.")
            ->view('emails.files.new.approved');
    }
}
