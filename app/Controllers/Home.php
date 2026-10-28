<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $siswa = db_connect()
            ->table('siswa')
            ->get()
            ->getResultArray();

        return view('siswa_view', ['siswa' => $siswa]);
    }

    public function simpan()
    {
        $rules = [
            'nis'           => 'required',
            'nama'          => 'required',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'kelas'         => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $inserted = db_connect()
            ->table('siswa')
            ->insert([
                'nis'   => trim((string) $this->request->getPost('nis')),
                'nama'  => trim((string) $this->request->getPost('nama')),
                'jenis_kelamin' => (string) $this->request->getPost('jenis_kelamin'),
                'kelas' => trim((string) $this->request->getPost('kelas')),
            ]);

        if (! $inserted) {
            throw new \RuntimeException('Gagal menyimpan data siswa ke database.');
        }

        return redirect()->to(site_url('siswa'))
            ->with('success', 'Data siswa berhasil disimpan.');
    }

    public function edit(int $id)
    {
        $existing = db_connect()
            ->table('siswa')
            ->where('id', $id)
            ->countAllResults();

        if ($existing === 0) {
            return redirect()->to(site_url('siswa'))
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        $rules = [
            'nis'           => 'required',
            'nama'          => 'required',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'kelas'         => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('edit_errors', $this->validator->getErrors())
                ->with('edit_id', $id)
                ->with('edit_input', [
                    'nis'   => (string) $this->request->getPost('nis'),
                    'nama'  => (string) $this->request->getPost('nama'),
                    'jenis_kelamin' => (string) $this->request->getPost('jenis_kelamin'),
                    'kelas' => (string) $this->request->getPost('kelas'),
                ]);
        }

        $updated = db_connect()
            ->table('siswa')
            ->where('id', $id)
            ->update([
                'nis'   => trim((string) $this->request->getPost('nis')),
                'nama'  => trim((string) $this->request->getPost('nama')),
                'jenis_kelamin' => (string) $this->request->getPost('jenis_kelamin'),
                'kelas' => trim((string) $this->request->getPost('kelas')),
            ]);

        if (! $updated) {
            throw new \RuntimeException('Gagal memperbarui data siswa di database.');
        }

        return redirect()->to(site_url('siswa'))
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function hapus(int $id)
    {
        $deleted = db_connect()
            ->table('siswa')
            ->where('id', $id)
            ->delete();

        if (! $deleted) {
            throw new \RuntimeException('Gagal menghapus data siswa dari database.');
        }

        return redirect()->to(site_url('siswa'))
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}
