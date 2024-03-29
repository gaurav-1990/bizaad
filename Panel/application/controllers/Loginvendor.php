<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Loginvendor extends MY_Controller {

    public $formKey;
    public $old_formKey;

    public function __construct() {
         
        parent::__construct();
        $this->load->model('Admin_model', 'admin');
        if ($this->session->userdata('form_key')) {
            $this->old_formKey = $this->session->userdata('form_key');
        }
        if ($this->session->userdata('signupSession')) {
            return redirect('SadminLogin/dashboard');
        }
        $this->load->library('encrypt');
    }

    public function forgotstep() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="text text-danger">', '</div>');
        $this->form_validation->set_rules('login[password]', "password", 'required|min_length[4]');
        $this->form_validation->set_rules('login[password2]', "re-password", 'required|matches[login[password]]');
        if ($this->form_validation->run() == FALSE) {
            $id = (int) $this->encrypt->decode($this->uri->segment(4));
            if ($id != 0) {
                $this->load->view('config/header', array('title' => 'Forgot Password'));
                $data = $this->admin->getInfoUser($id);
                $this->load->view('resetPass', array('user' => $data));
                $this->load->view('config/footer');
            } else {
                echo show_404();
            }
        } else {
            $id = (int) $this->encrypt->decode($this->uri->segment(4));
            $res = $this->admin->updatePassword($this->input->post('login[password]'), $id);
            if ($res) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success"> Password has been resetted </div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger"> Something went wrong </div>');
            }
            return redirect('Loginvendor');
        }
    }

    public function forgot() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="text text-danger">', '</div>');
        $this->form_validation->set_rules('login[username]', 'email', 'trim|required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('config/header', array('title' => 'Forgot Password'));
            $this->load->view('forgot');
            $this->load->view('config/footer');
        } else {
            $str = $this->input->post('login[username]');
            $str = $this->admin->checkEmail($str);
            $message = "";
            if ($str) {
                $base = base_url();
                $query = $this->admin->getByEmail($this->input->post('login[username]'))[0];
                $msg = "";
                $to_email = $query->emailadd;
                $subject = "(Confidential) Reset Password For shoptrendy.in (Do not share)";
                $message .= "<br><p>Hi $query->fname, please find the details";
                $message .= "<br> Username : $query->contactno  ";
                $message .= "<br><p>You need to enter new password on following page :({$base}Loginvendor/forgotstep/{$this->encrypt->encode($query->id)})</p>";
                if ($query) {
                    $config = Array(
                         
                        'mailtype' => 'html',
                        'charset' => 'iso-8859-1'
                    );
                    $this->load->library('email', $config);
                    $this->email->set_newline("\r\n");
                    $this->email->from('vendors@shoptrendy.in', 'Shoptrendy');
                    $this->email->to($to_email);
                    $this->email->bcc(array("shantanu@nibblesoftware.com"));
                    $this->email->subject($subject);
                    $this->email->message($message);
                    $result = $this->email->send();
                    if ($result) {
                        $msg = <<<EOD
                    <div class="alert alert-success mb" role="alert">
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                  <a href="#" class="alert-link link-underline"> Mail has been sent successfully </a>
                            </div>
                        </div>
EOD;

                        $this->session->set_flashdata('msg', $msg);
                    } else {


                        $msg = <<<EOD
                    <div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                  <a href="#" class="alert-link link-underline"> Error! in mail</a>
                            </div>
                        </div>
EOD;
                    }
                    $this->session->set_flashdata('msg', $msg);

//            echo $this->email->print_debugger();
                }
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger"> No record found with this email </div>');
            }
            return redirect('Loginvendor/forgot');
        }
    }

    private function generateKey() {
        $ip = $_SERVER['REMOTE_ADDR'];
        $uniqid = uniqid(mt_rand(), true);
        return md5($ip . $uniqid);
    }

    private function outputKey() {
        $this->formKey = $this->generateKey();
        $this->session->set_userdata('form_key', $this->formKey);
        return "<input type='hidden' name='form_key' id='form_key' value='" . $this->formKey . "' />";
    }

    public function submitLogin() {
        if ($this->old_formKey == $this->input->post('form_key')) {
            $data = $this->input->post();

            $data = $this->admin->checkLogin($data);

            if (!$data) {
                $this->session->set_flashdata('msg', ' <div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Please check your login credentials</a>
                            </div>
                        </div>');

                return redirect('Loginvendor');
            } else {
                $this->session->set_userdata('signupSession', $data);
                return redirect('SadminLogin/dashboard');
            }
        } else {
            $this->session->set_flashdata('msg', ' <div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Unauthorised access found</a>
                            </div>
                        </div>');
            return redirect('Loginvendor');
        }
    }

    public function index() {
        $this->load->view('config/header', array('title' => 'Welcome to bizaad.com'));
        $this->load->view('login', array("key" => $this->outputKey()));
        $this->load->view('config/footer');
    }

}
