<?php

namespace App\Controllers;

use App\Models\EmployeeModel;

class Admin extends BaseController
{

    protected $bd, $builder;

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('users');
    }

    public function index()
    {
        $data['title'] = 'User List';

        $this->builder->select('users.id as userid, username, email, name');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->builder->where('auth_groups.name', 'user');

        $query = $this->builder->get();

        $data['users'] = $query->getResult();

        return view('admin/index', $data);
    }


    public function employeedata()
    {
        $data['title'] = "Employee Lists";

        // Mengambil data karyawan menggunakan model EmployeeModel
        $employeeModel = new EmployeeModel();
        $data['employees'] = $employeeModel->findAll(); // Mengambil semua data karyawan

        return view('admin/employeedata', $data);
    }


    public function detail($id = 0)
    {
        $employeeModel = new \App\Models\EmployeeModel();
        $data['employee'] = $employeeModel->find($id);

        if (!$data['employee']) {
            return redirect()->to('/admin/employeedata');
        }

        $data['title'] = 'Employee Detail';
        return view('admin/detail', $data);
    }



    public function createemployee($id = 0)
    {
        $data['title'] = 'User Detail';

        return view('admin/createemployee', $data);
    }

    public function saveEmployee()
    {
        $validationRules = [
            'nama' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'nomor_telepon' => 'required',
            'jabatan' => 'required',
            'foto' => 'uploaded[foto]|mime_in[foto,image/jpeg,image/jpg]|max_size[foto,300]',
            'gaji' => 'required',
            'tanggal_bergabung' => 'required',
            'status_pernikahan' => 'required|in_list[Sudah Menikah,Belum Menikah]'
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->to('/admin/createemployee')->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama' => $this->request->getVar('nama'),
            'alamat' => $this->request->getVar('alamat'),
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
            'nomor_telepon' => $this->request->getVar('nomor_telepon'),
            'jabatan' => $this->request->getVar('jabatan'),
            'gaji' => $this->request->getVar('gaji'),
            'tanggal_bergabung' => $this->request->getVar('tanggal_bergabung'),
            'status_pernikahan' => $this->request->getVar('status_pernikahan'),
        ];

        $file = $this->request->getFile('foto');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads', $newName);
            $data['foto'] = $newName;
        }

        $employeeModel = new \App\Models\EmployeeModel();
        $employeeModel->save($data);

        return redirect()->to('/admin/employeedata');
    }

    public function deleteemployee($id = null)
    {
        // Cek apakah ID ada
        if ($id === null) {
            return redirect()->to('/admin/employeedata');
        }

        // Hapus karyawan berdasarkan ID
        $employeeModel = new \App\Models\EmployeeModel();
        $employeeModel->delete($id);

        // Redirect kembali ke halaman daftar karyawan
        return redirect()->to('/admin/employeedata');
    }

    public function editemployee($employeeId)
    {

        $data['title'] = 'Edit Employee';
        $employeeModel = new \App\Models\EmployeeModel();
        $data['employee'] = $employeeModel->getEmployee($employeeId);

        return view('admin/editemployee', $data);
    }

    public function updateemployee()
    {
        // Aturan validasi
        $validationRules = [
            'id' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'nomor_telepon' => 'required',
            'jabatan' => 'required',
            'gaji' => 'required',
            'tanggal_bergabung' => 'required',
            'status_pernikahan' => 'required|in_list[Sudah Menikah,Belum Menikah]',
        ];

        // Periksa apakah gambar diunggah
        if ($this->request->getFile('foto')->isValid() && !$this->request->getFile('foto')->hasMoved()) {
            $validationRules['foto'] = 'uploaded[foto]|max_size[foto,300]|is_image[foto]';
        }

        // Validasi input
        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id' => $this->request->getVar('id'),
            'nama' => $this->request->getVar('nama'),
            'alamat' => $this->request->getVar('alamat'),
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
            'nomor_telepon' => $this->request->getVar('nomor_telepon'),
            'jabatan' => $this->request->getVar('jabatan'),
            'gaji' => $this->request->getVar('gaji'),
            'tanggal_bergabung' => $this->request->getVar('tanggal_bergabung'),
            'status_pernikahan' => $this->request->getVar('status_pernikahan'),
        ];

        // Proses penggantian gambar hanya jika ada gambar baru yang diunggah
        if (array_key_exists('foto', $validationRules)) {
            // Hapus gambar lama jika ada
            $employeeModel = new \App\Models\EmployeeModel();
            $oldEmployee = $employeeModel->find($data['id']);

            if ($oldEmployee && !empty($oldEmployee['foto']) && file_exists(FCPATH . 'uploads/' . $oldEmployee['foto'])) {
                unlink(FCPATH . 'uploads/' . $oldEmployee['foto']);
            }

            // Pindahkan gambar baru
            $newImage = $this->request->getFile('foto');
            $newImageName = $newImage->getRandomName();
            $newImage->move(ROOTPATH . 'public/uploads', $newImageName);

            // Simpan nama gambar baru di dalam data yang akan diupdate
            $data['foto'] = $newImageName;
        }

        // Update data karyawan
        $employeeModel = new \App\Models\EmployeeModel();
        $employeeModel->update($data['id'], $data);
        $id = $this->request->getVar('id');

        return redirect()->to('/admin/detail/' . $id);
    }
}
