<?php

use App\Helpers\BladeParser;


/**
 * Send email to client. Subject is taken from config emails.subject_<tpl_name>
 *
 * Sends from emails.username and name is set to emails.name
 *
 * If environment is not production then will be sent back to emails.username
 *
 * @param string $email email
 * @param string $tpl blade template name in mails folder
 * @param array $data (Optional) data passed to blade template
 *
 * @throws Exception
 *
 * @return bool
 */
function send_mail($email, $tpl, $data = array())
{
    $env_email = env('TEST_EMAIL', config('mail.username'));
    if (env('APP_ENV') !== 'production' && $env_email !== '') {
        $data['_original_sendmail_to'] = $email;
        $email = $env_email;
    }

    $parser = new BladeParser();
    $subject = config('mail.subject_' . $tpl);
    if ($subject === null) {
        throw new Exception('config for subject not found: mail.subject_' . $tpl);
    }
    $subject = $parser->parse($subject, $data);

    $sent = Mail::send(
        'emails.' . $tpl,
        $data,
        function ($message) use ($email, $subject) {
            $message->from(config('mail.username'), config('mail.name'));
            $message->to($email);
            $message->subject($subject);
        }
    );

    return $sent;
}

/**
 * Send system emails to us. Emails are taken from config emails.info_mail.
 * info_mail might be a string of emails separated by comma without spaces.
 * In that case email is send to multiple recipients.
 * System email subject is taken from config emails.subject_<tpl>
 *
 * Sends from emails.username and name is set to emails.name
 *
 * If environment is not production then will be sent back to emails.username
 *
 * @param string $tpl blade template
 * @param array $data (Optional) data passed to blade template
 *
 * @throws Exception
 *
 * @return bool
 */
function send_info_mails($tpl, $data = array())
{
    // get system emails from emails.info_emails
    $info_emails = config('mail.info_emails');
    if (strpos($info_emails, ',') !== false) {
        $info_emails = explode(',', $info_emails);
    }

    if (env('APP_ENV') !== 'production') {
        $data['_original_sendmail_to'] = $info_emails;
        $info_emails = array(
            env('TEST_INFO_EMAIL_1', config('mail.username')),
            env('TEST_INFO_EMAIL_2', config('mail.username')),
        );
    }

    $parser = new BladeParser();
    $subject = config('mail.subject_' . $tpl);
    if ($subject === null) {
        throw new Exception('config for subject not found: emails.subject_' . $tpl);
    }
    $subject = $parser->parse($subject, $data);

    $sent = Mail::send(
        'emails.' . $tpl,
        $data,
        function ($message) use ($info_emails, $subject) {
            $message->from(config('mail.username'), config('mail.name'));
            $message->to($info_emails);
            $message->subject($subject);
        }
    );

    return $sent;
}
