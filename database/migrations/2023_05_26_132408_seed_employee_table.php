<?php

use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        User::query()
            ->create([
                'phone'                    => '0000000000',
                'name'                     => 'Администратор',
                'email'                    => 'not-exist@example.com',
                'password_last_updated_at' => now(),
                'password'                 => Hash::make('password'),
            ])
            ->employee()->create([
                'type' => Employee::TYPE_ADMIN,
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        User::truncate();
    }
};
