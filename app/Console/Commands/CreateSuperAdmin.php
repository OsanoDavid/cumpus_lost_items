<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:super-admin 
                            {--name= : Name of the Super Admin} 
                            {--email= : Email of the Super Admin} 
                            {--password= : Password for the account}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or elevate a user to Super Administrator';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('===============================================');
        $this->info('  Kisii University Super Administrator Setup  ');
        $this->info('===============================================');

        $email = $this->option('email') ?: $this->ask('Enter Super Admin Email');
        while (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Invalid email address format.');
            $email = $this->ask('Enter Super Admin Email');
        }

        $user = \App\Models\User::where('email', $email)->first();

        if ($user) {
            $this->warn("User with email [{$email}] already exists.");
            if ($this->confirm("Do you want to promote this user to Super Administrator?", true)) {
                $user->is_super_admin = true;
                $user->is_admin = true;

                $password = $this->option('password');
                if ($password) {
                    $user->password = \Illuminate\Support\Facades\Hash::make($password);
                }

                $user->save();
                $this->info("✓ User [{$user->name}] has been successfully promoted to Super Administrator!");
            }
            return 0;
        }

        $name = $this->option('name') ?: $this->ask('Enter Super Admin Name', 'Campus Super Admin');
        
        $password = $this->option('password');
        if (!$password) {
            $password = $this->secret('Enter Password (min 8 characters)');
            while (strlen($password) < 8) {
                $this->error('Password must be at least 8 characters long.');
                $password = $this->secret('Enter Password (min 8 characters)');
            }
        }

        $superAdmin = \App\Models\User::create([
            'name' => $name,
            'email' => $email,
            'password' => \Illuminate\Support\Facades\Hash::make($password),
            'is_admin' => true,
            'is_super_admin' => true,
            'phone' => '+254700000000',
            'reason_for_registering' => 'Super Administrator Authority',
            'email_verified_at' => now(),
        ]);

        $this->info("-----------------------------------------------");
        $this->info("✓ Super Administrator successfully created!");
        $this->table(
            ['ID', 'Name', 'Email', 'Role', 'Super Admin Status'],
            [[$superAdmin->id, $superAdmin->name, $superAdmin->email, 'Campus Administration', 'YES (Super User)']]
        );
        $this->info("-----------------------------------------------");

        return 0;
    }
}

