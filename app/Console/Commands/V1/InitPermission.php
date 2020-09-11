<?php

namespace App\Console\Commands\V1;

class InitPermission extends Base
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'v1:init-permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init permission system data';

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
        $permissions = ['view', 'create', 'update', 'delete'];
        
        $repository = new \App\Repositories\Admin\V1\PermissionRepository();

        foreach ($permissions as $permission) {
            $repository->store([
                'name'       => $permission,
                'guard_name' => 'admin'
            ]);
            
            $repository->store([
                'name'       => $permission,
                'guard_name' => 'api'
            ]);
        }
    }
}
