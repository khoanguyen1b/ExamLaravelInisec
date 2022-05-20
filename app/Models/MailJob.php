<?php
/**
 * Created by PhpStorm.
 * User: khoa
 * Date: 5/21/22
 * Time: 12:56 AM
 */

namespace App\Models;


use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    public $to;
    public $subject;
    public $cc;
    public $bcc;
    public $sendType;

    public function __construct(Mailable $email, $to, $sendType = null, $subject = null, $cc = null, $bcc = null)
    {
        $this->email = $email;
        $this->subject = $subject ?? $email->subject;
        $this->to = $to;
        $this->cc = $cc;
        $this->bcc = $bcc;
        $this->sendType = $sendType;
    }

    public function handle()
    {
        switch ($this->sendType) {
            case 'default':
                $this->sendByDefault();
                break;
            default:
                $this->sendByDefault();
                break;
        }
    }

    public function sendByDefault()
    {
        try {
            $email = Mail::to($this->to);

            if ($this->cc) {
                $email->cc($this->cc);
            }

            if ($this->bcc) {
                $email->bcc($this->bcc);
            }

            $email->send($this->email);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
