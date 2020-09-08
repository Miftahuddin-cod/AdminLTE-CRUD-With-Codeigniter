<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_jurusan extends CI_Model
{
    public function select_all()
    {
        $sql = "SELECT jurusan.id, jurusan.nama, fakultas.nama AS fakultas FROM jurusan INNER JOIN fakultas ON jurusan.id_fakultas=fakultas.id";

        $data = $this->db->query($sql);

        return $data->result();
    }

    public function select_by_id($id)
    {
        $sql = "SELECT * FROM jurusan WHERE id = '{$id}'";

        $data = $this->db->query($sql);

        return $data->row();
    }

    public function select_by_mahasiswa($id)
    {
        $sql = " SELECT mahasiswa.id AS id, mahasiswa.nama AS mahasiswa, mahasiswa.status AS statusMahasiswa, kota.nama AS kota, kelamin.nama AS kelamin, jurusan.nama AS jurusan FROM mahasiswa, kota, kelamin, jurusan WHERE mahasiswa.id_kelamin = kelamin.id AND mahasiswa.id_jurusan = jurusan.id AND mahasiswa.id_kota = kota.id AND mahasiswa.id_jurusan={$id}";

        $data = $this->db->query($sql);

        return $data->result();
    }

    public function insert($data)
    {
        $sql = "INSERT INTO jurusan VALUES('','" . $data['jurusan'] . "', '" . $data['fakultas'] . "')";

        $this->db->query($sql);

        return $this->db->affected_rows();
    }

    public function insert_batch($data)
    {
        $this->db->insert_batch('jurusan', $data);

        return $this->db->affected_rows();
    }

    public function update($data)
    {
        $sql = "UPDATE jurusan SET nama='" . $data['jurusan'] . "', id_fakultas='" . $data['fakultas'] . "' WHERE id='" . $data['id'] . "'";

        $this->db->query($sql);

        return $this->db->affected_rows();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM jurusan WHERE id='" . $id . "'";

        $this->db->query($sql);

        return $this->db->affected_rows();
    }

    public function check_nama($nama)
    {
        $this->db->where('nama', $nama);
        $data = $this->db->get('jurusan');

        return $data->num_rows();
    }

    public function total_rows()
    {
        $data = $this->db->get('jurusan');

        return $data->num_rows();
    }
}

/* End of file M_jurusan.php */
/* Location: ./application/models/M_jurusan.php */