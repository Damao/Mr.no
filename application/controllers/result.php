<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Result extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *         http://example.com/index.php/welcome
     *    - or -
     *         http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        $data["task_id"] = 0;
        $this->load->view('task', $data);
    }

    public function id($task_id = "")
    {
        $data["task_id"] = $task_id;
        if ($task_id) {
            $result_device = "pc";
            if ($this->agent->is_mobile()) {
                $result_device = "mobile";
            }
            $data["result_device"] = $result_device;

            $sql_result = "SELECT * FROM result WHERE task_id = ?";
            $sql_task = "SELECT * FROM task WHERE task_id = ?";
            $query_result = $this->db->query($sql_result, array($task_id));
            $query_task = $this->db->query($sql_task, array($task_id));
        }
        if ($query_task->num_rows() > 0) {
            foreach ($query_task->result() as $row) {
                $data['task_timestamp'] = $row->task_timestamp;
                $data['task_timestamp'] = $row->task_timestamp;
                $data['file_type'] = $row->file_type;
                $data['task_area'] = $row->task_area;
                $data['task_directive'] = $row->task_directive;
            }
        }
        if ($query_result->num_rows() > 0) {
            $result_count = 0;
            $result_all_stay_time = 0;
            $result_all_area = array();
            $result_all_device = array();
            $result_all_success = 0;
            foreach ($query_result->result() as $row) {
                $result_count++;
                array_push($result_all_area, $row->result_area);
                array_push($result_all_device, $row->result_device);
                $result_all_success += $row->result_success;
                $result_all_stay_time += $row->result_stay_time;
            }
            $data["response"]=$result_count;
            $data["avg_stay_time"]=$result_all_stay_time/$result_count;
            $data["avg_success"]=$result_all_success/$result_count;
            $data["result_all_area"]=$result_all_area;
            $data["result_all_device"]=$result_all_device;
        }
        $this->load->view('result', $data);
    }

    public function submit($task_id = "")
    {
        $data["task_id"] = $task_id;
        if ($task_id) {
            $result_device = "pc";
            if ($this->agent->is_mobile()) {
                $result_device = "mobile";
            }
            $data["result_device"] = $result_device;

            $db_data = array(
                'task_id' => $task_id,
                'result_area' => $_POST["result_area"],
                'result_success' => $_POST["result_success"],
                'result_device' => $result_device,
                'result_stay_time' => $_POST["result_stay_time"]
            );

            $this->db->insert('result', $db_data);

        }
        $this->load->view('task_submit', $data);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */