<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class SuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'methys:superadmin {name} {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new superadmin user with a random 8 character password';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        
        $user = User::where('name', $name)->first();
        if ($user !== null) {
            echo "The user name: $name already exists. Please try again.\n";
            return;
        }
        
        if (strlen($name) < 3) {
            echo "The user name: $name must be more than 3 characters.\n";
            return;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format: $email. Please try again.\n";
            return;
        }
        
        $password = $this->ask('Please enter the password.');
        if (strlen($password) < 6) {
            echo "Invalid password. Must be more than 6 characters. Please try again.\n";
            return;
        }
        
        $confirm_password = $this->ask('Please re-enter the password.');
        if ($password !== $confirm_password) {
            echo "The passwords do not match. Please try again.\n";
            return;
        }
        
        $newuser = factory('App\Models\User')->create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password)
        ]);
        
        $newuser->assignRole('superadmin');
        
        echo "\nSuper admin user $user has been created.\n";
        print_r("
            name: $name,
            email: $email,
            password: $password
        \n");
        
    }
}
