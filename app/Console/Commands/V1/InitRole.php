<?php

namespace App\Console\Commands\V1;

class InitRole extends Base
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'v1:init-role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init role system data';

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
        $adminRoles = ['root', 'super_admin', 'admin', 'manager', 'editor'];
        $apiRoles   = ['user', 'guest'];

        $repository = new \App\Repositories\Admin\V1\RoleRepository();

        foreach($adminRoles as $role) {
            $repository->store([
                'name' => $role,
                'guard_name' => 'admin'
            ]);  
        }

        foreach($apiRoles as $role) {
            $repository->store([
                'name' => $role,
                'guard_name' => 'api'
            ]);  
        }
    }
}
