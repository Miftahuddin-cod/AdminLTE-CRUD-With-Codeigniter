<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fakultas extends AUTH_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_fakultas');
    }

    public function index()
    {
        $data['userdata']     = $this->userdata;
        $data['dataFakultas'] = $this->M_fakultas->select_all();

        $data['page']         = "fakultas";
        $data['judul']         = "Data Fakultas";
        $data['deskripsi']     = "Manage Data Fakultas";

        $data['modal_tambah_fakultas'] = show_my_modal('modals/modal_tambah_fakultas', 'tambah-fakultas', $data);

        $this->template->views('fakultas/home', $data);
    }

    public function tampil()
    {
        $data['dataFakultas'] = $this->M_fakultas->select_all();
        $this->load->view('fakultas/list_data', $data);
    }

    public function prosesTambah()
    {
        $this->form_validation->set_rules('fakultas', 'fakultas', 'trim|required');

        $data     = $this->input->post();
        if ($this->form_validation->run() == TRUE) {
            $result = $this->M_fakultas->insert($data);

            if ($result > 0) {
                $out['status'] = '';
                $out['msg'] = show_succ_msg('Data Fakultas Berhasil ditambahkan', '20px');
            } else {
                $out['status'] = '';
                $out['msg'] = show_err_msg('Data Fakultas Gagal ditambahkan', '20px');
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
        $data['dataFakultas'] = $this->M_fakultas->select_by_id($id);

        echo show_my_modal('modals/modal_update_fakultas', 'update-fakultas', $data);
    }

    public function prosesUpdate()
    {
        $this->form_validation->set_rules('fakultas', 'fakultas', 'trim|required');

        $data     = $this->input->post();
        if ($this->form_validation->run() == TRUE) {
            $result = $this->M_fakultas->update($data);

            if ($result > 0) {
                $out['status'] = '';
                $out['msg'] = show_succ_msg('Data Fakultas Berhasil diupdate', '20px');
            } else {
                $out['status'] = '';
                $out['msg'] = show_err_msg('Data Fakultas Gagal diupdate', '20px');
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
        $result = $this->M_fakultas->delete($id);

        if ($result > 0) {
            echo show_succ_msg('Data Fakultas Berhasil dihapus', '20px');
        } else {
            echo show_err_msg('Data Fakultas Gagal dihapus', '20px');
        }
    }

    public function detail()
    {
        $data['userdata']     = $this->userdata;
        $id                 = trim($_POST['id']);
        $data['fakultas'] = $this->M_fakultas->select_by_id($id);
        $data['dataFakultas'] = $this->M_fakultas->select_by_mahasiswa($id);

        echo show_my_modal('modals/modal_detail_fakultas', 'detail-fakultas', $data, 'lg');
    }

    public function export()
    {
        error_reporting(E_ALL);

        include_once './assets/phpexcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();

        $data = $this->M_fakultas->select_all();

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $rowCount = 1;

        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "ID");
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "Nama Fakultas");
        $rowCount++;

        foreach ($data as $value) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $value->id);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value->nama);
            $rowCount++;
        }

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('./assets/excel/Data Fakultas.xlsx');

        $this->load->helper('download');
        force_download('./assets/excel/Data Fakultas.xlsx', NULL);
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
                        $check = $this->M_fakultas->check_nama($value['B']);

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
                        $this->session->set_flashdata('msg', show_succ_msg('Data Fakultas Berhasil diimport ke database'));
                        redirect('Fakultas');
                    }
                } else {
                    $this->session->set_flashdata('msg', show_msg('Data Fakultas Gagal diimport ke database (Data Sudah terupdate)', 'warning', 'fa-warning'));
                    redirect('Fakultas');
                }
            }
        }
    }
}

/* End of file Fakultas.php */
/* Location: ./application/controllers/Fakultas.php */