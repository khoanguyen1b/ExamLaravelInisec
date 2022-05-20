<?php
/**
 * Created by PhpStorm.
 * User: khoa
 * Date: 5/21/22
 * Time: 12:40 AM
 */

namespace App\Models;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailNewPost extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }


    public function build()
    {
        return $this->view('new_post_mail')
            ->subject("New Post");
    }
}
