<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (strtolower($this->router->fetch_method()) != 'update_data' && strtolower($this->router->fetch_method()) != 'update_country' && !isset($_SESSION['signin'])) {
            redirect('signin');
        }
        $this->load->model('user_model', 'user');
    }

    public function index() {
        $this->load->view('user_view');
    }

    public function ajax_list() {
        $list = $this->user->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $user) {
            $no++;
            $row = array();
            $row[] = $user->facebook_id;
            $row[] = $user->display_name;
            $row[] = $user->networth;
            $row[] = $user->networth_2;
            $row[] = $user->networth_pow;
            $row[] = $user->appVersion;
            $row[] = $user->device_type;
            $row[] = $user->country;
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_user(' . "'" . $user->facebook_id . "'" . ')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_user(' . "'" . $user->facebook_id . "'" . ')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->user->count_all(),
            "recordsFiltered" => $this->user->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->user->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $data = array(
            'facebook_id' => $this->input->post('facebook_id'),
            'display_name' => $this->input->post('display_name'),
            'networth' => $this->input->post('networth'),
            'networth_2' => $this->input->post('networth_2'),
            'networth_pow' => $this->input->post('networth_pow'),
            'appVersion' => $this->input->post('appVersion'),
            'device_type' => $this->input->post('device_type'),
            'country' => $this->input->post('country')
        );
        $insert = $this->user->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $data = array(
            'facebook_id' => $this->input->post('facebook_id'),
            'display_name' => $this->input->post('display_name'),
            'networth' => $this->input->post('networth'),
            'networth_2' => $this->input->post('networth_2'),
            'networth_pow' => $this->input->post('networth_pow'),
            'appVersion' => $this->input->post('appVersion'),
            'device_type' => $this->input->post('device_type'),
            'country' => $this->input->post('country')
        );
        $this->user->update(array('facebook_id' => $this->input->post('facebook_id_0')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id) {
        $this->user->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    public function update_data($facebook_id, $display_name, $networth, $networth_2, $networth_pow, $appVersion, $device_type, $debug = 0) {
        if ($debug == 1) {
            $this->user->table = str_replace("_prod", "_dev", $this->db->database) . "." . $this->user->table;
        }
        $data = array(
            'facebook_id' => $facebook_id,
            'display_name' => $display_name,
            'networth' => $networth,
            'networth_2' => $networth_2,
            'networth_pow' => $networth_pow,
            'appVersion' => $appVersion,
            'device_type' => $device_type
        );
        $row = $this->user->get_by_id($facebook_id);
        if (is_object($row)) {
            $this->user->update(array('facebook_id' => $facebook_id), $data);
        } else {
            $this->user->save($data);
        }

        echo json_encode($data);
    }

    public function update_country($facebook_id, $country, $debug = 0) {
        if ($debug == 1) {
            $this->user->table = str_replace("_prod", "_dev", $this->db->database) . "." . $this->user->table;
        }
        $data = array('country' => $country);
        $where = array('facebook_id' => $facebook_id);
        $this->user->update($where, $data);

        $json['facebook_id'] = $facebook_id;
        $json['country'] = $country;
        echo json_encode($json);
    }

}
