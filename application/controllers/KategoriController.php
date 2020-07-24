<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class KategoriController extends CI_Controller 
    {
        private $base_url = "http://localhost:8080/InternshipWebsite/";

        public function __construct()
        {
            parent::__construct();
            $this->load->model('kategoriModel');
        }

        public function getKategoriAPI() // UNTUK TESTING
        {
            $input = $this->input->post('input');
            $data['hasil'] = $this->kategoriModel->getKategoriTest($input);
            $this->load->view('outputkategori', $data);
            
            // $this->load->view('', $res);
            // echo $res;
        }

        public function getKategoriById() // BUAT EDIT
        {
            $id = $this->input->get('id');
            $data['hasil'] = $this->kategoriModel->getKategoriById($id);
            $this->load->view('edit_kategori', $data);
        }

        public function createKategori()
        {
            $data = array(
                'kategori' => $this->input->post('kategori'),
                'sinonim' => $this->input->post('sinonim')
            );

            $res = $this->kategoriModel->createKategori($data);
            redirect($this->base_url);
        }

        public function updateKategori()
        {
            $data = array(
                'id' => $this->input->post('id'),
                'kategori' => $this->input->post('kategori'),
                'sinonim' => $this->input->post('sinonim')
            );

            $res = $this->kategoriModel->updateKategori($data);
            redirect($this->base_url);
        }

        public function deleteKategori()
        {
            $data = array(
                'id' => $this->input->get('id')
            );

            $res = $this->kategoriModel->deleteKategori($data);
            redirect('http://localhost:8080/InternshipWebsite/');
        }
    }