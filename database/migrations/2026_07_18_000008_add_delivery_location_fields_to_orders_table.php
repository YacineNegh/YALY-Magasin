<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('wilaya_id')->nullable()->after('phone')->constrained()->nullOnDelete();
            $table->foreignId('commune_id')->nullable()->after('wilaya_id')->constrained()->nullOnDelete();
            $table->decimal('items_total', 12, 2)->default(0)->after('status');
            $table->decimal('delivery_price', 10, 2)->default(0)->after('items_total');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['wilaya_id']);
            $table->dropForeign(['commune_id']);
            $table->dropColumn(['wilaya_id', 'commune_id', 'items_total', 'delivery_price']);
        });
    }
};
