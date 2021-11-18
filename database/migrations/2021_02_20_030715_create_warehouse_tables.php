<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {

        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('enabled')->default('1');
            $table->timestamps();
        });

        Schema::create('importers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('stn_no')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('ntn_no')->nullable();
            $table->tinyInteger('enabled')->default('1');

            $table->unsignedBigInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts');


            $table->timestamps();
        });

        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('ntn_no')->nullable();
            $table->tinyInteger('enabled')->default('1');
            $table->timestamps();
        });


        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('file_no');
            $table->string('file_code')->nullable();
            $table->string('gd_no')->nullable();
            $table->string('bond_no')->nullable();
            $table->string('date_bond')->nullable();
            $table->string('description')->nullable();
            $table->string('vessel')->nullable();
            $table->string('gross_wt')->nullable();
            $table->string('net_wt')->nullable();
            $table->string('bl_no')->nullable();
            $table->string('vir_no')->nullable();
            $table->string('index_no')->nullable();
            $table->string('insurance')->nullable();
            $table->string('lc_no')->nullable();
            $table->decimal('amount', 14, 2)->nullable();
            $table->decimal('s_tax', 14, 2)->nullable();
            $table->BigInteger('qty')->nullable();
            $table->tinyInteger('enabled')->default('1');

            $table->unsignedBigInteger('agent_id')->nullable();
            $table->foreign('agent_id')->references('id')->on('agents');

            $table->unsignedBigInteger('importer_id')->nullable();
            $table->foreign('importer_id')->references('id')->on('importers');

            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients');

            $table->timestamps();
        });


        Schema::create('unit_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('enabled')->default('1');
            $table->timestamps();
        });

        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('hscode')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id')->references('id')->on('unit_types');
            $table->tinyInteger('enabled')->default('1');
            $table->unsignedBigInteger('file_id')->nullable();
            $table->foreign('file_id')->references('id')->on('files');
            $table->timestamps();
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('file_id');
            $table->foreign('file_id')->references('id')->on('files');
            $table->date('date');
            $table->decimal('amount', 14, 2)->nullable();
            $table->decimal('s_tax', 14, 2)->nullable();
            $table->tinyInteger('enabled')->default('1');
            $table->timestamps();
        });



        Schema::create('quantities', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('items');
            $table->unsignedBigInteger('file_id')->nullable();
            $table->foreign('file_id')->references('id')->on('files');
            $table->string('qty');
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->tinyInteger('enabled')->default('1');
            $table->timestamps();
        });

        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('file_id');
            $table->foreign('file_id')->references('id')->on('files');
            $table->date('date');
            $table->decimal('amount', 14, 2)->nullable();
            $table->decimal('i_tax', 14, 2)->nullable();
            $table->decimal('s_tax', 14, 2)->nullable();
            $table->decimal('com', 14, 2)->nullable();
            $table->tinyInteger('enabled')->default('1');
            $table->timestamps();
        });


        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->string('description');
            $table->decimal('payee', 14, 2)->nullable();
            $table->string('cheque')->nullable();
            $table->decimal('amount', 14, 2)->nullable();
            $table->tinyInteger('enabled')->default('1');
            $table->timestamps();
        });


        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->timestamps();
        });


        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('file_id');
            $table->foreign('file_id')->references('id')->on('files');
            // $table->unsignedBigInteger('importer_id');
            // $table->foreign('importer_id')->references('id')->on('importers');
            // $table->string('discription');
            // $table->string('bond_no');
            // $table->string('file_no');
            // $table->string('index_no');
            $table->string('Cash_no')->nullable();
            // $table->time('time');
            $table->string('Vehicle_no')->nullable();
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('items');
            $table->string('qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agents');
        Schema::dropIfExists('importers');
        Schema::dropIfExists('clients');
        Schema::dropIfExists('files');
        Schema::dropIfExists('unit_types');
        Schema::dropIfExists('hs_codes');
        Schema::dropIfExists('items');
        Schema::dropIfExists('quantities');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('receipts');
        Schema::dropIfExists('packages');
        Schema::dropIfExists('deliveries');
    }
}
