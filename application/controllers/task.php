<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Task extends CI_Controller
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
            $data["result_device"]=$result_device;

            $sql = "SELECT * FROM task WHERE task_id = ?";
            $query = $this->db->query($sql, array($task_id));
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row)
                {
                    $data['task_timestamp'] =$row->task_timestamp;
                    $data['file_type']      =$row->file_type;
                    $data['task_area']      =$row->task_area;
                    $data['task_directive'] =$row->task_directive;
                }
            }
        }
        $this->load->view('task', $data);
    }
    public function submit($task_id = "")
    {
        $data["task_id"] = $task_id;
        if ($task_id) {
            $result_device = "pc";
            if ($this->agent->is_mobile()) {
                $result_device = "mobile";
            }
            $data["result_device"]=$result_device;

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