<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Form extends CI_Controller
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

    public function ajaxupload()
    {
        $pathinfo = pathinfo($_GET['qqfile']);
        //$filename = md5(uniqid());
        $file_type = @$pathinfo['extension']; // hide notices if extension is empty
        $db_data = array(
            'file_type' => $file_type
        );
        $this->db->insert('task', $db_data);
        $task_id = $this->db->insert_id();

        $this->load->library("qqfileuploader");

        // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
        $result = $this->qqfileuploader->handleUpload('uploads/',$task_id);

        // to pass data through iframe you will need to encode all html tags
        echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
    }
    public function update()
    {
        $db_data = array(
            'task_directive' => $_POST["task_directive"],
            'task_area'=>$_POST["task_area"]
        );
        $this->db->where('task_id', $_POST["task_id"]);
        $this->db->update('task', $db_data);
        $result=array('success' => true);
        echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */