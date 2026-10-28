<?php
namespace app\Controllers;

use App\Controllers\BaseController;
use app\Models\SiswaModel;

class siswa extends BaseController {
    public function index() {
        $model = new SiswaModel();
        $data['siswa'] = $model->findAll();

        return view('siswa/index', $data);
    }
}