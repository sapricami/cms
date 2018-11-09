<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Calcutta');
		$this->data=array();
		$this->data['cms_options']=$this->cms_options();
		if($this->agent->is_mobile()){
			$this->data['theme'] = $this->data['cms_options']['theme_mobile'];
		}else{
			$this->data['theme'] = $this->data['cms_options']['theme_desktop'];
		}
	}
	public function cms_options(){
        $sql=$this->db->get_where('cms_options',array('id'=>'1'));
        return $sql->row_array();
    }
	public function navbar_array(){
		$sql_navbar = $this->db->order_by('menu_sort_order','ASC')->get_where('cms_menu');
    	return $sql_navbar->result_array();
	}
	public function partial($file,$data)
	{
		return $this->load->view('themes/'.$this->data['theme'].'/partials/'.$file, $data, TRUE);
	}
	public function layout($file,$data)
	{
		$data['header'] = $this->partial('header',$data,TRUE);
		$data['navbar'] = $this->partial('navbar',$data,TRUE);
		$data['content'] = $this->load->view('themes/'.$this->data['theme'].'/templates/'.$file,$data,TRUE);
		$data['footer'] = $this->partial('footer',$data,TRUE);
		$this->load->view('themes/'.$this->data['theme'].'/partials/layout',$data);
	}
	//create results and pagination
    public function results_generator($query,$base_path,$itemsPerPage,$page_no=1,$url_options=null){
        $sql_all=$this->db->query($query);
        if($sql_all->num_rows()>0){
            $offset = ($page_no - 1) * $itemsPerPage;
            $totalitems = $sql_all->num_rows();
            $end = $totalitems;
            if($itemsPerPage<$totalitems){$end=$itemsPerPage*$page_no;if($end>$totalitems){$end=$totalitems;}}
            $page_str = ($offset+1).'-'.$end.' of '.$totalitems.' Results';
            $total_pages = ceil($totalitems / $itemsPerPage); 
            $pagination=$this->custom_pagination($base_path,$total_pages,$page_no,$url_options);

            $sql_results=$this->db->query($query." LIMIT ".$offset.",".$itemsPerPage." ");
            if($sql_results->num_rows()>0){
                $results=$sql_results->result_array();
            }else{
                $page_str=false;
                $results=false;
                $pagination=false;
            }
        }else{
            $page_str=false;
            $results=false;
            $pagination=false;
        }
        return array(
            'page_str' => $page_str,
            'results' => $results,
            'pagination' => $pagination,
            );
    }
    public function pager($base_path,$total_pages,$page_no,$itemsPerPage)
    {
    	if($total_pages=='1'){
    		return false;
    	}else{
	    	if($page_no=='1'){
	    		$first_btn=array('PREV','disabled','javascript:void();');
	    		$second_btn=array('NEXT','',$base_path.($page_no+1));
	    	}elseif($page_no==$total_pages){
	    		$first_btn=array('PREV','',$base_path.($page_no-1));
	    		$second_btn=array('NEXT','disabled','javascript:void();');
	    	}else{
	    		if($page_no=='2'){
	    			$first_btn=array('PREV','',$base_path);
	    		}else{
	    			$first_btn=array('PREV','',$base_path.($page_no-1));
	    		}
	    		$second_btn=array('NEXT','',$base_path.($page_no+1));
	    	}
    	}
    	return array($first_btn,$second_btn);
    }
    public function custom_pagination($base_path,$total_pages,$page_no)
    {
        $HTML='';
        if ($total_pages>1) {
            $HTML.= '<div class="styled-pagination text-center margin-bott-40">
            			<ul class="pagination">
                        <li><a class="prev" href="'.$base_path.'1"><span class="fa fa-angle-left"></span>&ensp;Prev</a></li>';
            for($i=1; $i<=$total_pages; $i++) {
                if($i==$page_no){
                    $HTML.= '<li class="active"><a href="javascript:void(0);">'.$i.'</a></li>'; 
                }else{
                    $HTML.= '<li ><a href="'.$base_path.$i.'">'.$i.'</a></li>'; 
                }
            }   
            $HTML.= '   <li><a class="next" href="'.$base_path.$total_pages.'">Next&ensp;<span class="fa fa-angle-right"></span></a></li>
                    </ul></div>';
        }
        return $HTML;
    }
	public function send_sms($phone_number,$message){

 		$apiKey = urlencode('textlocalcode');
		$numbers = '91'.$phone_number;
		//$sender = 'TXTLCL';
		$sender = 'RNTEZO';
	 
		// Prepare data for POST request
		$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => ($message));
		// Send the POST request with cURL
		$ch = curl_init('https://api.textlocal.in/send/');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);

		//print_r($response);
		$this->load->helper('file');
		write_file('./uploads/smslog.txt', $response, 'r+');

		return true;
	}
	public function send_email($to_email,$email_name,$subject,$HTML){

		$sql=$this->db->query("SELECT `site_name`,`smtp_email_from`,`smtp_hostname`,`smtp_port`,`smtp_username`,`smtp_password` FROM cms_options WHERE id=1 LIMIT 1");
		$row=$sql->row_array();

		$this->load->library('myphpmailer');
        $mail = new PHPMailer();

        if (isset($row['smtp_hostname'])&&!empty($row['smtp_hostname'])) {
			$mail->isSMTP();
			$mail->SMTPDebug = 0;
			$mail->Debugoutput = 'html';
			$mail->Host = 'ssl://'.$row['smtp_hostname'];//"sapricami.com";
			$mail->Port = $row['smtp_port'];//25;
			$mail->SMTPAuth = true;
			$mail->Username = $row['smtp_username'];//"wingrow";
			$mail->Password = $row['smtp_password'];//"a9897716370A";
        }
        //if ssl
        /*$mail->SMTPOptions = array(
		    'ssl' => array(
		        'verify_peer' => false,
		        'verify_peer_name' => false,
		        'allow_self_signed' => true
		    )
		);*/
		$mail->setFrom($row['smtp_email_from'],$row['site_name']);
		/*if(!empty($reply_email)){
			if(!empty($reply_name)){
				$mail->addReplyTo($from_email, $from_name);
			}else{
				$mail->addReplyTo($from_email, '');
			}
		}*/
        $mail->addAddress($to_email);
        /*if(!empty($cc)){
        	$mail->addCC($cc);
        }*/
        $mail->Subject = $subject;
        $mail->msgHTML($HTML);
        $mail->AltBody = $HTML;
        if($mail->send()) {
            return true;
        }else{
            return false;
        }
	}
}

/* End of file Common.php */
/* Location: ./application/models/Common.php */