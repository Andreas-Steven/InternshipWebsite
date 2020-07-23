<?php
    use GuzzleHttp\Client;

    class NamaModel extends CI_Model 
    {
        private $_client;

        public function __construct()
        {
            $this->_client = new Client([
                'base_uri' => 'https://a1.cakra.ai/InternshipWebAPI/api/'
            ]);
        }

        public function getNamaTest($input) // UNTUK TESTING
        {
            $client = new Client();
            $response = $client->request('GET', 'https://a1.cakra.ai/InternshipWebAPI/api/MainAPI/nama', [
                'query' => [
                    'input' => $input
                ]
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $result["output"];
        }

        // MANAGE API
        public function getNama() // CHECKED
        {
            $response = $this->_client->request('GET', 'NamaAPI');

            $result = json_decode($response->getBody()->getContents(), true);
            return $result["data"];
        }

        public function getNamaById($id)
        {
            $response = $this->_client->request('GET', 'NamaAPI', [
                'query' => [
                    'id' => $id
                ]
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $result["data"][0];
        }

        public function createNama($data) // CHECKED
        {
            $response = $this->_client->request('POST', 'NamaAPI', [
                'form_params' => [
                    'noise' => $data["noise"]
                ]
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $result["message"];
        }

        public function updateNama($data)  // CHECKED
        {
            $response = $this->_client->request('PUT', 'NamaAPI', [
                'form_params' => [
                    'id' => $data["id"],
                    'noise' => $data["noise"]
                ]
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $result["message"];
        }

        public function deleteNama($data) // CHECKED
        {
            $response = $this->_client->request('DELETE', 'NamaAPI', [
                'form_params' => [
                    'id' => $data["id"]
                ]
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $result["message"];
        }
        
    }
