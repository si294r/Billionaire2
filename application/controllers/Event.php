<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (strtolower($this->router->fetch_method()) != 'get' && !isset($_SESSION['signin'])) {
            redirect('signin');
        }
        $this->load->model('event_model', 'event');
        $this->event->init_db(get_class($this) == 'Event_dev');
//        var_dump(get_class($this));
    }
    
    public function index() {
        $this->load->view('event_view');
    }

    public function ajax_list() {
        $list = $this->event->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $event) {
            $no++;
            $row = array();
            $row[] = $event['event_name'];
            $row[] = $event['start_date'];
            $row[] = $event['end_date'];
            $row[] = $event['device'];
            $row[] = $event['version'];
            $row[] = $event['status'];

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_event(' . "'" . $event['_id'] . "'" . ')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_event(' . "'" . $event['_id'] . "'" . ')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->event->count_all(),
            "recordsFiltered" => $this->event->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->event->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $data = array(
            'event_name' => $this->input->post('event_name'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'device' => $this->input->post('device'),
            'version' => $this->input->post('version'),
            'status' => $this->input->post('status'),
            'update_time' => gmdate("Y-m-d H:i:s"),
            'server_time' => $this->input->post('server_time')
        );
        $insert = $this->event->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $data = array(
            'event_name' => $this->input->post('event_name'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'device' => $this->input->post('device'),
            'version' => $this->input->post('version'),
            'status' => $this->input->post('status'),
            'update_time' => gmdate("Y-m-d H:i:s"),
            'server_time' => $this->input->post('server_time')
        );
        $this->event->update_by_id($this->input->post('_id'), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id) {
        $this->event->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

//    public function get($device, $version, $debug = 0) {
//        $start_time = microtime(true);
//        if ($debug == 1) {
//            $this->event->table = str_replace("_prod", "_dev", $this->db->database) . "." . $this->event->table;
//        }
//        $json['current_time'] = date('Y-m-d H:i:s');
//        $json['device'] = $device;
//        $json['version'] = $version;
//
//        $data = $this->event->get_event($device, $version);
//        if (is_object($data)) {
//            $json['event_time']['start'] = $data->start_date;
//            $json['event_time']['end'] = $data->end_date;
//        }
//
//        $end_time = microtime(true);
//
//        $json['execute_time'] = $end_time - $start_time;
//        $json['memory_usage'] = memory_get_usage(true);
//
//        echo json_encode($json);
//    }

}
