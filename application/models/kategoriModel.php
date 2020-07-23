<?php
    use GuzzleHttp\Client;

    class KategoriModel extends CI_Model 
    {
        private $_client;

        public function __construct()
        {
            $this->_client = new Client([
                'base_uri' => 'https://a1.cakra.ai/InternshipWebAPI/api/'
            ]);
        }
        
        public function getKategoriTest($input) // UNTUK TESTING
        {
            $client = new Client();
            $response = $client->request('GET', 'https://a1.cakra.ai/InternshipWebAPI/api/MainAPI/kategori', [
                'query' => [
                    'input' => $input
                ]
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $result["output"];
        }

         // MANAGE API
        public function getKategori() // CHECKED
        {
            $response = $this->_client->request('GET', 'KategoriAPI');

            $result = json_decode($response->getBody()->getContents(), true);
            return $result["data"];
        }

        public function getKategoriById($id)
        {
            $response = $this->_client->request('GET', 'KategoriAPI', [
                'query' => [
                    'id' => $id
                ]
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $result["data"];
        }

        public function createKategori($data)
        {
            $response = $this->_client->request('POST', 'KategoriAPI', [
                'form_params' => [
                    'kategori' => $data["kategori"],
                    'sinonim' => $data["sinonim"]
                ]
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $result["message"];
        }

        public function updateKategori($data)
        {
            $response = $this->_client->request('PUT', 'KategoriAPI', [
                'form_params' => [
                    'id' => $data["id"],
                    'kategori' => $data["kategori"],
                    'sinonim' => $data["sinonim"]
                ]
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $result["message"];
        }

        public function deleteKategori($data)
        {
            $response = $this->_client->request('DELETE', 'KategoriAPI', [
                'form_params' => [
                    'id' => $data["id"]
                ]
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $result["message"];
        }
    }

