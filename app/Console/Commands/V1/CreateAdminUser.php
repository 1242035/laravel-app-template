<?php

namespace App\Console\Commands\V1;

class CreateAdminUser extends Base
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'v1:create-admin';

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
        $email      = $this->input('What is you admin email?');
        $username   = $this->input('What is you admin username?');
        $password   = $this->input('What is you admin password?');
        $repository = \App\Repositories\Admin\AdminRepository();

        $user = $repository->store([
            'email'    => $email,
            'password' => $password,
            'username' => $username
        ]);

        return $user;
    }
}
