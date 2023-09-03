<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table = 'employees';

    protected $allowedFields = ['nama', 'alamat', 'jenis_kelamin', 'tanggal_lahir', 'nomor_telepon', 'jabatan', 'foto', 'gaji', 'tanggal_bergabung', 'status_pernikahan'];

    public function saveEmployee($data)
    {
        return $this->insert($data);
    }

    public function getEmployee($employeeId)
    {
        return $this->find($employeeId);
    }
}
