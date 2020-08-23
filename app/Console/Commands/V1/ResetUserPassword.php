<?php

namespace App\Console\Commands\V1;

class ResetUserPassword extends Base
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'v1:reset-user-password {email : user email} {password : user password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset user password';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email      = $this->argument('email');
        $password   = $this->argument('password');
        $repository = new \App\Repositories\Admin\UserRepository();

        $user = $repository->resetPassword($email, $password);

        return $user->id ? 1 : 0;
    }
}
