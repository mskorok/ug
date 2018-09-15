<?php

namespace App\Jobs;

use App\Models\Adventures\Adventure;
use App\Models\Users\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class SendInviteEmail
 * @package App\Jobs
 */
class SendInviteEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Adventure
     */
    protected $adventure;

    protected $view = 'invite';

    protected $email;


    /**
     * SendInviteEmail constructor.
     * @param Adventure $adventure
     * @param User $user
     * @param $email
     */
    public function __construct(Adventure $adventure, User $user, $email)
    {
        $this->user = $user;
        $this->adventure = $adventure;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Mail::sendTo(
            $this->email,
            $this->view,
            [
                'user'  => $this->user, 'adventure' => $this->adventure
            ]
        );
    }
}
