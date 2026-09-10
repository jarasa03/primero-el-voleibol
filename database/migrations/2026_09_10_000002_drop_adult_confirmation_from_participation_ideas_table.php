<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('participation_ideas', function (Blueprint $table): void {
            $table->dropColumn('adult_confirmed_at');
        });
    }

    public function down(): void
    {
        Schema::table('participation_ideas', function (Blueprint $table): void {
            $table->timestamp('adult_confirmed_at')->nullable()->after('consented_at');
        });
    }
};
