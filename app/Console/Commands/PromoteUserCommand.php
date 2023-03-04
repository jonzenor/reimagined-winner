<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

class PromoteUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:promote {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Promote a user to super admin.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $role = Role::where('name', '=', 'Super Admin')->first();        
        $user = User::where('email', '=', $this->argument('email'))->first();

        $user->role_id = $role->id;
        $user->save();

        $this->info("User {$user->name} was promoted to Super Admin");
    }
}
