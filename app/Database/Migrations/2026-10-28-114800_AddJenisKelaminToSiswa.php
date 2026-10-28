<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddJenisKelaminToSiswa extends Migration
{
    public function up()
    {
        $this->forge->addColumn('siswa', [
            'jenis_kelamin' => [
                'type'       => 'CHAR',
                'constraint' => 1,
                'null'       => true,
                'after'      => 'nama',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('siswa', 'jenis_kelamin');
    }
}
