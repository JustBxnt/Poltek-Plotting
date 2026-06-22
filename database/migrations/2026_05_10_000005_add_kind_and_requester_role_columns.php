<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('buildings', 'kind')) {
            Schema::table('buildings', function (Blueprint $table) {
                $table->string('kind')->default('building')->after('info');
            });

            DB::table('buildings')->update(['kind' => 'building']);
        }

        if (! Schema::hasColumn('bookings', 'requester_role')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->string('requester_role')->nullable()->after('requester_name');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('bookings', 'requester_role')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropColumn('requester_role');
            });
        }

        if (Schema::hasColumn('buildings', 'kind')) {
            Schema::table('buildings', function (Blueprint $table) {
                $table->dropColumn('kind');
            });
        }
    }
};