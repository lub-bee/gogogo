<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-admin
                            {--name= : The admin user name}
                            {--email= : The admin user email}
                            {--password-stdin : Read password from ADMIN_PASSWORD env var or stdin (for CI)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user account';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->option('name') ?: $this->ask('Name');
        $email = $this->option('email') ?: $this->ask('Email');

        $password = $this->resolvePassword();

        // Validate
        $validator = Validator::make(
            compact('name', 'email', 'password'),
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8'],
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'rank' => User::RANK_ADMIN,
        ]);

        $this->info("Admin user created: {$user->email} (ID: {$user->id})");

        return self::SUCCESS;
    }

    /**
     * Resolve the password from interactive input, env var, or stdin.
     */
    private function resolvePassword(): ?string
    {
        if (! $this->option('password-stdin')) {
            return $this->secret('Password');
        }

        // CI / non-interactive: try ADMIN_PASSWORD env var first, then stdin
        $envPassword = env('ADMIN_PASSWORD');
        if ($envPassword !== null && $envPassword !== '') {
            return $envPassword;
        }

        // Read from stdin (pipe)
        $stdin = fopen('php://stdin', 'r');
        if ($stdin === false) {
            return null;
        }

        $line = fgets($stdin);
        fclose($stdin);

        return $line !== false ? trim($line) : null;
    }
}
