<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'activities', function ( Blueprint $table ) {

            $table->bigIncrements('id');
            $table->unsignedInteger( 'project_id' );

            // 'morphs' is identical to the following two lines..
            $table->nullableMorphs( 'subject' );
            // $table->unsignedInteger( 'subject_id' );
            // $table->string( 'subject_type' );

            $table->text( 'changes' )->nullable();

            $table->string( 'description' );
            $table->timestamps();

            $table->foreign( 'project_id' )->references( 'id' )->on( 'projects' )->onDelete( 'cascade' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
