<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class csv extends CI_Controller
{
	function index ()
	{
		echo form_open('csv/load');
		 echo form_upload("csvfile");
		 
		 echo form_submit("submit","Upload");
		form_close();
	}
	function load()
	{
		
		$name = $this->input->post('csvfile');
		$query = $this->db->query("LOAD DATA INFILE 'C:/$name' REPLACE INTO TABLE csvtest FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\\n' (f_name, l_name, country, @dummy, phone) SET customer_id = ''");
		if ($query)
		{
			echo 'yes';
		}		
		else 
		{
			echo 'no';
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/cindex.php */