<?php

namespace App\Console\Commands\V1;

class CreateAdminUser extends Base
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'v1:create-admin {email : admin email} {username : admin username} {password : admin user password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin user';

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
        $username   = $this->argument('username');
        $password   = $this->argument('password');
        $repository = new \App\Repositories\Admin\AdminRepository();

        $user = $repository->store([
            'email'    => $email,
            'password' => $password,
            'username' => $username,
            'status'   => 1
        ]);

        return $user->id ? 1 : 0;
    }
}
