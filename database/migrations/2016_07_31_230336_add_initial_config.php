<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInitialConfig extends Migration
{
    /**
     * This class starts the initial configs of the DB such as starting courses(MIEEC),
     * starting roles (admin), and inserts the admins with default_passwords <- They need to be changed.
     */
    public function up()
    {

        DB::table('courses')->insert(
            array(
                'name' => 'Mestrado Integrado em Eng. Electrotécnica e de Computadores',
                'initials' => 'MIEEC',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
            )
        );

        DB::table('roles')->insert(
            array(
                'designation' => 'admin',
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
            )
        );

        DB::table('users')->insert(
            array(
                'student_id' => 2011154225,
                'username' => 'bluetrickpt',
                'name' => 'Ricardo Mendes',
                'email' => 'ricardo.s.c.mendes@gmail.com',
                'password' => Hash::make('password'),
                'course_id' => 1,
                'role_id' => 1,
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
            )
        );

        DB::table('users')->insert(
            array(
                'student_id' => 2012136620,
                'username' => 'francisco',
                'name' => 'Francisco Couceiro',
                'email' => 'couceiro.f@gmail.com',
                'password' => Hash::make('password'),
                'course_id' => 1,
                'role_id' => 1,
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
            )
        );
    }

    public function down()
    {
        //
    }
}
