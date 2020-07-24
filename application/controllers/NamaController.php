<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class NamaController extends CI_Controller 
    {
        private $base_url = "http://localhost:8080/InternshipWebsite/";

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

        public function getNamaById() // BUAT EDIT 
        {
            $id = $this->input->get('id');
            $data['hasil'] = $this->namaModel->getNamaById($id);
            $this->load->view('edit_nama', $data);
        }

        public function createNama() // CHECKED
        {
            $data = array(
                'noise' => $this->input->post('noise')
            );

            $res = $this->namaModel->createNama($data);
            
            redirect($this->base_url);
        }

        public function updateNama() // CHECKED
        {
            $data = array(
                'id' => $this->input->post('id'),
                'noise' => $this->input->post('noise')
            );

            $res = $this->namaModel->updateNama($data);
            redirect($this->base_url);
        }

        public function deleteNama() // CHECKED
        {
            $data = array(
                'id' => $this->input->get('id')
            );

            $res = $this->namaModel->deleteNama($data);
            redirect($this->base_url);
        }
    }