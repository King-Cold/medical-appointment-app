<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->timestamp('notified_at')->nullable()->after('status');
            $table->boolean('whatsapp_sent')->default(false)->after('notified_at');
            $table->timestamp('reminder_sent_at')->nullable()->after('whatsapp_sent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['notified_at', 'whatsapp_sent', 'reminder_sent_at']);
        });
    }
};
