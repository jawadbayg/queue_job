<?php

namespace App\Jobs;

use App\Mail\ExportCompletedEmail;
use App\Exports\UsersExport; // Make sure this line is included
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class UsersData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userEmail;

    /**
     * Create a new job instance.
     *
     * @param string $userEmail
     * @return void
     */
    public function __construct($userEmail)
    {
        $this->userEmail = $userEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fileName = 'users_export_' . now()->format('Ymd_His') . '.xlsx';
        $filePath = 'exports/' . $fileName;

        // Use the Excel facade to store the file
        Excel::store(new UsersExport(), $filePath);

        // Send email with the file path
        Mail::to($this->userEmail)->send(new ExportCompletedEmail($filePath));
    }
}


