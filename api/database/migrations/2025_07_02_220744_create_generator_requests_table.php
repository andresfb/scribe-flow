<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('generator_requests', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)
                ->constrained('users');
            $table->char('status', 1);
            $table->string('type', 25);
            $table->string('service');
            $table->string('model');
            $table->unsignedInteger('total_tokens')
                ->default(0);
            $table->json('request');
            $table->json('content')->nullable();
            $table->json('response')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('generator_requests');
    }
};
