<?php

use App\Models\Lists\Character;
use App\Models\Lists\Pace;
use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pieces', static function (Blueprint $table) {
            $table->foreignIdFor(Character::class)
                ->nullable()
                ->after('theme_id')
                ->constrained('characters');

            $table->foreignIdFor(Pace::class)
                ->nullable()
                ->after('character_id')
                ->constrained('paces');

            $table->foreignIdFor(Setting::class)
                ->nullable()
                ->after('pace_id')
                ->constrained('settings');

            $table->dropColumn('setting_location');
        });
    }

    public function down(): void
    {
        Schema::table('pieces', static function (Blueprint $table) {
            $table->dropForeign(['character_id']);
            $table->dropColumn('character_id');

            $table->dropForeign(['pace_id']);
            $table->dropColumn('pace_id');

            $table->dropForeign(['setting_id']);
            $table->dropColumn('setting_id');

            $table->string('setting_location')->nullable();
        });
    }
};
