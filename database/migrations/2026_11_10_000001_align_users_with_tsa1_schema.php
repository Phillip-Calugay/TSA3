<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'full_name');
            $table->string('username', 50)->nullable()->unique();
            $table->dropUnique(['email']);
            $table->string('full_name', 100)->change();
            $table->string('email', 100)->change();
            $table->dropColumn(['email_verified_at', 'password', 'remember_token']);
        });

        User::whereNull('username')->each(function (User $user) {
            $user->update(['username' => 'user-'.$user->id]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 50)->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->renameColumn('full_name', 'name');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->default('');
            $table->rememberToken();
        });
    }
};
