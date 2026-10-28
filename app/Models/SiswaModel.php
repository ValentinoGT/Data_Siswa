<?php
namespace app\Models;

use CodeIgniter\Model;

class SiswaModel extends Model {
    protected $table = 'siswa';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nis', 'nama', 'jenis_kelamin', 'kelas'];

    public function getSiswa() {
        return $this->findAll();
    }
};