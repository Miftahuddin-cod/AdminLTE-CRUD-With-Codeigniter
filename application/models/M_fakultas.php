<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_fakultas extends CI_Model
{
    public function select_all()
    {
        $data = $this->db->get('fakultas');

        return $data->result();
    }

    public function select_by_id($id)
    {
        $sql = "SELECT * FROM fakultas WHERE id = '{$id}'";

        $data = $this->db->query($sql);

        return $data->row();
    }

    public function select_by_mahasiswa($id)
    {
        $sql = " SELECT mahasiswa.id AS id, mahasiswa.nama AS mahasiswa, mahasiswa.status AS statusMahasiswa, jurusan.nama AS jurusan, kelamin.nama AS kelamin, fakultas.nama AS fakultas FROM mahasiswa, jurusan, kelamin, fakultas WHERE mahasiswa.id_kelamin = kelamin.id AND jurusan.id_fakultas = fakultas.id AND mahasiswa.id_jurusan = jurusan.id AND jurusan.id_fakultas={$id}";

        $data = $this->db->query($sql);

        return $data->result();
    }

    public function insert($data)
    {
        $sql = "INSERT INTO fakultas VALUES('','" . $data['fakultas'] . "')";

        $this->db->query($sql);

        return $this->db->affected_rows();
    }

    public function insert_batch($data)
    {
        $this->db->insert_batch('fakultas', $data);

        return $this->db->affected_rows();
    }

    public function update($data)
    {
        $sql = "UPDATE fakultas SET nama='" . $data['fakultas'] . "' WHERE id='" . $data['id'] . "'";

        $this->db->query($sql);

        return $this->db->affected_rows();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM fakultas WHERE id='" . $id . "'";

        $this->db->query($sql);

        return $this->db->affected_rows();
    }

    public function check_nama($nama)
    {
        $this->db->where('nama', $nama);
        $data = $this->db->get('fakultas');

        return $data->num_rows();
    }

    public function total_rows()
    {
        $data = $this->db->get('fakultas');

        return $data->num_rows();
    }
}

/* End of file M_fakultas.php */
/* Location: ./application/models/M_fakultas.php */