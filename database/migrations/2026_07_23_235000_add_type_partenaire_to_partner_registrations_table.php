<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('partner_registrations', function (Blueprint $table) {
            $table->string('type_partenaire')->nullable()->after('ville'); // agence | freelance
        });
    }

    public function down(): void
    {
        Schema::table('partner_registrations', function (Blueprint $table) {
            $table->dropColumn('type_partenaire');
        });
    }
};
