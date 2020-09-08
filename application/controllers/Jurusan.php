<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jurusan extends AUTH_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_jurusan');
        $this->load->model('M_fakultas');
    }

    public function index()
    {
        $data['userdata']     = $this->userdata;
        $data['dataJurusan'] = $this->M_jurusan->select_all();
        $data['dataFakultas'] = $this->M_fakultas->select_all();

        $data['page']         = "jurusan";
        $data['judul']         = "Data Jurusan";
        $data['deskripsi']     = "Manage Data Jurusan";

        $data['modal_tambah_jurusan'] = show_my_modal('modals/modal_tambah_jurusan', 'tambah-jurusan', $data);

        $this->template->views('jurusan/home', $data);
    }

    public function tampil()
    {
        $data['dataJurusan'] = $this->M_jurusan->select_all();
        $this->load->view('jurusan/list_data', $data);
    }

    public function prosesTambah()
    {
        $this->form_validation->set_rules('jurusan', 'Jurusan', 'trim|required');
        $this->form_validation->set_rules('fakultas', 'Fakultas', 'trim|required');

        $data     = $this->input->post();
        if ($this->form_validation->run() == TRUE) {
            $result = $this->M_jurusan->insert($data);

            if ($result > 0) {
                $out['status'] = '';
                $out['msg'] = show_succ_msg('Data Jurusan Berhasil ditambahkan', '20px');
            } else {
                $out['status'] = '';
                $out['msg'] = show_err_msg('Data Jurusan Gagal ditambahkan', '20px');
            }
        } else {
            $out['status'] = 'form';
            $out['msg'] = show_err_msg(validation_errors());
        }

        echo json_encode($out);
    }

    public function update()
    {
        $data['userdata']     = $this->userdata;

        $id                 = trim($_POST['id']);
        $data['dataJurusan'] = $this->M_jurusan->select_by_id($id);
        $data['dataFakultas'] = $this->M_fakultas->select_all();

        echo show_my_modal('modals/modal_update_jurusan', 'update-jurusan', $data);
    }

    public function prosesUpdate()
    {
        $this->form_validation->set_rules('jurusan', 'Jurusan', 'trim|required');
        $this->form_validation->set_rules('fakultas', 'Fakultas', 'trim|required');

        $data     = $this->input->post();
        if ($this->form_validation->run() == TRUE) {
            $result = $this->M_jurusan->update($data);

            if ($result > 0) {
                $out['status'] = '';
                $out['msg'] = show_succ_msg('Data Jurusan Berhasil diupdate', '20px');
            } else {
                $out['status'] = '';
                $out['msg'] = show_err_msg('Data Jurusan Gagal diupdate', '20px');
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
        $result = $this->M_jurusan->delete($id);

        if ($result > 0) {
            echo show_succ_msg('Data Jurusan Berhasil dihapus', '20px');
        } else {
            echo show_err_msg('Data Jurusan Gagal dihapus', '20px');
        }
    }

    public function detail()
    {
        $data['userdata']     = $this->userdata;

        $id                 = trim($_POST['id']);
        $data['jurusan'] = $this->M_jurusan->select_by_id($id);
        $data['dataJurusan'] = $this->M_jurusan->select_by_mahasiswa($id);

        echo show_my_modal('modals/modal_detail_jurusan', 'detail-jurusan', $data, 'lg');
    }

    public function export()
    {
        error_reporting(E_ALL);

        include_once './assets/phpexcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();

        $data = $this->M_jurusan->select_all();

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $rowCount = 1;

        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "ID");
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "Nama Jurusan");
        $rowCount++;

        foreach ($data as $value) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $value->id);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value->nama);
            $rowCount++;
        }

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('./assets/excel/Data Jurusan.xlsx');

        $this->load->helper('download');
        force_download('./assets/excel/Data Jurusan.xlsx', NULL);
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
                        $check = $this->M_jurusan->check_nama($value['B']);

                        if ($check != 1) {
                            $resultData[$index]['nama'] = ucwords($value['B']);
                        }
                    }
                    $index++;
                }

                unlink('./assets/excel/' . $data['file_name']);

                if (count($resultData) != 0) {
                    $result = $this->M_kota->insert_batch($resultData);
                    if ($result > 0) {
                        $this->session->set_flashdata('msg', show_succ_msg('Data Jurusan Berhasil diimport ke database'));
                        redirect('Jurusan');
                    }
                } else {
                    $this->session->set_flashdata('msg', show_msg('Data Jurusan Gagal diimport ke database (Data Sudah terupdate)', 'warning', 'fa-warning'));
                    redirect('Jurusan');
                }
            }
        }
    }
}

/* End of file Jurusan.php */
/* Location: ./application/controllers/Jurusan.php */