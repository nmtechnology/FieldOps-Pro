<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-admin {email=admin@fieldengineer.pro} {password=admin123!} {name=Admin User}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update an admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');
        $name = $this->argument('name');

        $user = User::where('email', $email)->first();

        if ($user) {
            $this->info("User $email already exists. Updating to admin status.");
            $user->is_admin = true;
            $user->password = Hash::make($password);
            $user->save();
        } else {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
                'is_admin' => true,
            ]);
            $this->info("Admin user created with email: $email");
        }

        $this->info("Admin user ready. You can log in at " . route('login') . " with:");
        $this->info("Email: $email");
        $this->info("Password: $password");
        $this->warn("Please change the password after your first login for security!");

        return Command::SUCCESS;
    }
}