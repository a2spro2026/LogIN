<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partner_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('nom_complet');
            $table->string('telephone');
            $table->string('ville');
            $table->string('email')->unique();
            $table->string('status')->default('pending'); // pending | approved | rejected
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('partner')->after('email');
            $table->string('telephone')->nullable()->after('role');
            $table->string('ville')->nullable()->after('telephone');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'telephone', 'ville']);
        });

        Schema::dropIfExists('partner_registrations');
    }
};
