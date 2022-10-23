<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('Mahasiswamodel', 'model');
    }

    public function index_get()
    {
        $data = $this->model->getMahasiswa();
        $this->set_response([
            'status' => TRUE,
            'code' => 200,
            'message' => 'Success',
            'data' => $data,
        ], REST_Controller::HTTP_OK);
    }

    public function sendmail_post()
    {
        $to_email = $this->post('email');
        $this->load->library('email');
        $this->email->from('darryl@darryl.ngantokimt.com', 'Raja Ongkir');
        $this->email->to($to_email);
        $this->email->subject('Informasi Penting dari Raja Ongkir');
        $this->email->message("
            <center>
            <div style='border: 5px solid #9B59BB; border-radius: 32px;'>
                <h1 style='color: #9B59BB;'>Selamat bergabung user Raja Ongkir!</h1>
                <img style='border-radius: 50%;' src='https://img.freepik.com/free-vector/employees-cv-candidates-resume-corporate-workers-students-id-isolate-flat-design-element-job-applications-avatars-personal-information-concept-illustration_335657-1661.jpg?w=200'>
                <h2 style='font-weight: bold;'>Terima kasih telah mendaftar pada layanan Raja Ongkir</h2>
                <p> Kami siap membantu Anda untuk meningkatkan kualitas <b> proses pengiriman </b> Anda.</p>
                <p> Apabila Anda memang pernah melakukan pendaftaran sebagai <i> user </i> dalam layanan aplikasi Raja Ongkir, silahkan klik tautan di bawah ini: </p>
                <button style='background-color: #9B59BB;
                border-radius:28px;
                border:1px solid #18ab29;
                display:inline-block;
                cursor:pointer;
                color:#ffffff;
                font-family:Arial;
                font-size:15px;
                font-weight:bold;
                padding:14px 15px;
                text-decoration:none;
                text-shadow:0px 1px 0px #2f6627;'
                > Verifikasi akun </button>
                &nbsp;
                <p style='color: #9B59BB;'> Email ini dikirimkan kepada Anda untuk keperluan verifikasi akun yang baru saja Anda daftarkan. </p>
            </div>
            </center>
        ");
        if ($this->email->send()) {
            $this->set_response([
                'status' => TRUE,
                'code' => 200,
                'message' => 'Email berhasil dikirimkan, silahkan periksa inbox email anda!',
            ], REST_Controller::HTTP_OK);
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Gagal mengirimkan email',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
