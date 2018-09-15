<?php namespace App\Core;

use Illuminate\Support\Facades\Lang;
use Pelago\Emogrifier;

/**
 * Class Mailer
 * @package App\Core
 */
class Mailer extends \Illuminate\Mail\Mailer
{
    /**
     * Send a new message using a view.
     *
     * @param  string  $email_to
     * @param  string  $view
     * @param  array   $data
     * @return void
     */
    public function sendTo($email_to, $view, array $data = [])
    {
        $subject = Lang::get('mail.'.$view);

        parent::send(
            'emails.' . $view,
            $data,
            function ($message) use ($email_to, $subject) {
                $message->to($email_to);
                $message->subject($subject);
            }
        );
    }

    /**
     * Render the given view.
     *
     * @param  string  $view
     * @param  array  $data
     * @return string
     */
    protected function getView($view, $data)
    {
        $test = 0;

        $content = $this->views->make($view, $data)->render();
        $css = file_get_contents(resource_path('assets/css/email.css'));
        $inliner = new Emogrifier();
        $inliner->setCss($css);
        $inliner->setHtml($content);
        $content = $inliner->emogrify();

        if ($test) {
            echo $content;
            exit;
        } else {
            return $content;
        }
    }
}
