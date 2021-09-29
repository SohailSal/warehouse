<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoreTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('enabled')->default('1');
            $table->timestamps();
        });

        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('web')->nullable();
            $table->string('phone')->nullable();
            $table->enum('fiscal',  ['March', 'June', 'September', 'December'])->default('June');
            $table->date('incorp')->nullable();
            $table->tinyInteger('enabled')->default('1');
            $table->timestamps();
        });

        Schema::create('account_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('enabled')->default('1');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('type_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('type_id')->references('id')->on('account_types');
            $table->timestamps();
        });

        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();
            $table->string('name');
            $table->tinyInteger('enabled')->default('1');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('group_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('group_id')->references('id')->on('account_groups');
            $table->timestamps();
        });

        Schema::create('years', function (Blueprint $table) {
            $table->id();
            $table->date('begin');
            $table->date('end');
            $table->tinyInteger('closed')->default('0');
            $table->tinyInteger('enabled')->default('1');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('key');
            $table->string('value')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->timestamps();
        });

        Schema::create('document_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('prefix');
            $table->tinyInteger('enabled')->default('1');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->timestamps();
        });

        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('ref');
            $table->date('date');
            $table->string('description');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('year_id');
            $table->tinyInteger('paid')->default('1');
            $table->tinyInteger('posted')->default('1');
            $table->tinyInteger('approved')->default('1');
            $table->tinyInteger('enabled')->default('1');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('type_id')->references('id')->on('document_types');
            $table->foreign('year_id')->references('id')->on('years');
            $table->timestamps();
        });

        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('year_id');
            $table->decimal('debit',14,2);
            $table->decimal('credit',14,2);
            $table->tinyInteger('enabled')->default('1');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('document_id')->references('id')->on('documents');
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('year_id')->references('id')->on('years');
            $table->timestamps();
        });

        Schema::create('companies_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('company_id')->references('id')->on('companies');
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
        Schema::dropIfExists('companies_users');
        Schema::dropIfExists('entries');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('document_types');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('years');
        Schema::dropIfExists('accounts');
        Schema::dropIfExists('account_groups');
        Schema::dropIfExists('companies');
        Schema::dropIfExists('account_types');
    }
}
