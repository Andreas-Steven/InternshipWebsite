<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class NamaController extends CI_Controller 
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('namaModel');
            $this->load->model('kategoriModel');
        }

        public function getNamaAPI() // UNTUK TESTING
        {
            $input = $this->input->post('input');
            $data['hasil'] = $this->namaModel->getNamaTest($input);
            $this->load->view('outputnem', $data);
            // echo $res;
        }

        public function getNamaById()
        {
            $id = $this->input->post('id');
            $res = $this->namaModel->getNamaById($id);
            // $this->load->view('', $res);
            echo $res;
        }

        public function createNama() // CHECKED
        {
            $data = array(
                'noise' => $this->input->post('noise')
            );

            $res = $this->namaModel->createNama($data);
            
            $data['nama'] = $this->namaModel->getNama();
            $data['kategori'] = $this->kategoriModel->getKategori();
            $this->load->view('v_main', $data);
        }

        public function updateNama() // CHECKED
        {
            $data = array(
                'id' => $this->input->post('id'),
                'noise' => $this->input->post('noise')
            );

            $res = $this->namaModel->updateNama($data);
            // $this->load->view('outputnem', $res);
            echo $res;
        }

        public function deleteNama() // CHECKED
        {
            $data = array(
                'id' => $this->input->get('id')
            );

            $res = $this->namaModel->deleteNama($data);
            redirect('http://localhost:8080/InternshipWebsite/');
        }
    }