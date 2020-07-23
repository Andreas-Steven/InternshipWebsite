<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class KategoriController extends CI_Controller 
    {
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

        public function getKategoriById()
        {
            $id = $this->input->post('id');
            $res = $this->kategoriModel->getKategoriById($id);
            // $this->load->view('', $res);
            echo $res;
        }

        public function createKategori()
        {
            $data = array(
                'kategori' => $this->input->post('kategori'),
                'sinonim' => $this->input->post('sinonim')
            );

            $res = $this->kategoriModel->createKategori($data);
            // $this->load->view('', $res);
            echo $res;
        }

        public function updateKategori()
        {
            $data = array(
                'id' => $this->input->post('id'),
                'kategori' => $this->input->post('kategori'),
                'sinonim' => $this->input->post('sinonim')
            );

            $res = $this->kategoriModel->updateKategori($data);
            // $this->load->view('', $res);
            echo $res;
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