<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helper\SendMailHelper;
use Illuminate\Support\Facades\DB;

class Jobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $exit_info;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    // public function __construct($exit_id)
    // {
    //     $this->exit_id = $exit_id;
    // }

    public function __construct($exit_info)
    {
        $this->exit_info = $exit_info; // get object
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $exit_name = $this->exit_info->re_user_name;
        $exit_id = $this->exit_info->re_user_cardid;
        $checker_name = $this->exit_info->re_checker_name;
        $fullUrl = url('/');
        $dataMail = [
            'subject' => 'Lease Management Notification',
            'body' => "
                    <div style='color:#111111'>
                        <p style=\"font-family:'Trebuchet MS';\">Dear $checker_name, <br/> You have an initiation the exit process checklist for $exit_name.</p>
                        <table border=\"1\" style=\"border-collapse: collapse;\">
                            <tbody>
                                <tr>
                                    <td style=\"padding:4px 8px;\">Staff Name:</td>
                                    <td style=\"padding:4px 8px;\"><strong>$exit_name</strong></td>
                                </tr>
                                <tr>
                                    <td style=\"padding:4px 8px;\">Staff ID:</td>
                                    <td style=\"padding:4px 8px;\"><strong>$exit_id</strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <p style=\"font-family:'Trebuchet MS';\">Click this link to view checklist. <br/>
                            <a href=\"$fullUrl\" style=\"font-family:'Trebuchet MS';\" target=\"_blank\">$fullUrl</a>
                        </p>
                    </div>
                "
        ];
        $sendMail = SendMailHelper::sendMailNotification($this->exit_info->re_email, $dataMail);
    }
}
