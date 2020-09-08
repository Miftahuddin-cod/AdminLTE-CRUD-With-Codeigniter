<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mahasiswa extends AUTH_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_mahasiswa');
        $this->load->model('M_fakultas');
        $this->load->model('M_jurusan');
        $this->load->model('M_kota');
    }

    public function index()
    {
        $data['userdata'] = $this->userdata;
        $data['dataMahasiswa'] = $this->M_mahasiswa->select_all();
        $data['dataJurusan'] = $this->M_jurusan->select_all();
        $data['dataKota'] = $this->M_kota->select_all();

        $data['page'] = "Mahasiswa";
        $data['judul'] = "Data Mahasiswa";
        $data['deskripsi'] = "Manage Data Mahasiswa";

        $data['modal_tambah_mahasiswa'] = show_my_modal('modals/modal_tambah_mahasiswa', 'tambah-mahasiswa', $data);

        $this->template->views('mahasiswa/home', $data);
    }

    public function tampil()
    {
        $data['dataMahasiswa'] = $this->M_mahasiswa->select_all();
        $this->load->view('mahasiswa/list_data', $data);
    }

    public function prosesTambah()
    {
        $this->form_validation->set_rules('nim', 'NIM', 'trim|required');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'trim|required');
        $this->form_validation->set_rules('kota', 'Kota', 'trim|required');
        $this->form_validation->set_rules('jurusan', 'Jurusan', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');

        $data = $this->input->post();
        if ($this->form_validation->run() == TRUE) {
            $result = $this->M_mahasiswa->insert($data);

            if ($result > 0) {
                $out['status'] = '';
                $out['msg'] = show_succ_msg('Data Mahasiswa Berhasil ditambahkan', '20px');
            } else {
                $out['status'] = '';
                $out['msg'] = show_err_msg('Data Mahasiswa Gagal ditambahkan', '20px');
            }
        } else {
            $out['status'] = 'form';
            $out['msg'] = show_err_msg(validation_errors());
        }

        echo json_encode($out);
    }

    public function update()
    {
        $id = trim($_POST['id']);

        $data['dataMahasiswa'] = $this->M_mahasiswa->select_by_id($id);
        $data['dataJurusan'] = $this->M_jurusan->select_all();
        $data['dataKota'] = $this->M_kota->select_all();
        $data['userdata'] = $this->userdata;

        echo show_my_modal('modals/modal_update_mahasiswa', 'update-mahasiswa', $data);
    }

    public function prosesUpdate()
    {
        $this->form_validation->set_rules('nim', 'NIM', 'trim|required');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'trim|required');
        $this->form_validation->set_rules('kota', 'Kota', 'trim|required');
        $this->form_validation->set_rules('jurusan', 'Jurusan', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');

        $data = $this->input->post();
        if ($this->form_validation->run() == TRUE) {
            $result = $this->M_mahasiswa->update($data);

            if ($result > 0) {
                $out['status'] = '';
                $out['msg'] = show_succ_msg('Data Mahasiswa Berhasil diupdate', '20px');
            } else {
                $out['status'] = '';
                $out['msg'] = show_err_msg('Data Mahasiswa Gagal diupdate', '20px');
            }
        } else {
            $out['status'] = 'form';
            $out['msg'] = show_err_msg(validation_errors());
        }

        echo json_encode($out);
    }

    public function delete()
    {
        $id = $_POST['id'];
        $result = $this->M_mahasiswa->delete($id);

        if ($result > 0) {
            echo show_succ_msg('Data Mahasiswa Berhasil dihapus', '20px');
        } else {
            echo show_err_msg('Data Mahasiswa Gagal dihapus', '20px');
        }
    }

    public function export()
    {
        error_reporting(E_ALL);

        include_once './assets/phpexcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();

        $data = $this->M_mahasiswa->select_all_mahasiswa();

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $rowCount = 1;

        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "NIM");
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "Nama");
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "ID Kelamin");
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, "ID Kota");
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, "ID jurusan");
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, "Status");
        $rowCount++;

        foreach ($data as $value) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $value->id);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value->nama);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $rowCount, $value->id_kelamin);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value->id_kota);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value->id_jurusan);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value->status);
            $rowCount++;
        }

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('./assets/excel/Data Mahasiswa.xlsx');

        $this->load->helper('download');
        force_download('./assets/excel/Data Mahasiswa.xlsx', NULL);
    }

    public function import()
    {
        $this->form_validation->set_rules('excel', 'File', 'trim|required');

        if ($_FILES['excel']['name'] == '') {
            $this->session->set_flashdata('msg', 'File harus diisi');
        } else {
            $config['upload_path'] = './assets/excel/';
            $config['allowed_types'] = 'xls|xlsx';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('excel')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = $this->upload->data();

                error_reporting(E_ALL);
                date_default_timezone_set('Asia/Jakarta');

                include './assets/phpexcel/Classes/PHPExcel/IOFactory.php';

                $inputFileName = './assets/excel/' . $data['file_name'];
                $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

                $index = 0;
                foreach ($sheetData as $key => $value) {
                    if ($key != 1) {
                        $check = $this->M_mahasiswa->check_nim($value['A']);

                        if ($check != 1) {
                            $resultData[$index]['id'] = $value['A'];
                            $resultData[$index]['nama'] = ucwords($value['B']);
                            $resultData[$index]['id_kelamin'] = $value['C'];
                            $resultData[$index]['id_kota'] = $value['D'];
                            $resultData[$index]['id_jurusan'] = $value['E'];
                            $resultData[$index]['status'] = $value['F'];
                        }
                    }
                    $index++;
                }

                unlink('./assets/excel/' . $data['file_name']);

                if (count($resultData) != 0) {
                    $result = $this->M_mahasiswa->insert_batch($resultData);
                    if ($result > 0) {
                        $this->session->set_flashdata('msg', show_succ_msg('Data Mahasiswa Berhasil diimport ke database'));
                        redirect('Mahasiswa');
                    }
                } else {
                    $this->session->set_flashdata('msg', show_msg('Data Mahasiswa Gagal diimport ke database (Data Sudah terupdate)', 'warning', 'fa-warning'));
                    redirect('Mahasiswa');
                }
            }
        }
    }
}

/* End of file Mahasiswa.php */
/* Location: ./application/controllers/Mahasiswa.php */