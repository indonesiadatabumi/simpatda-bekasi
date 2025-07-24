<?php 
   class Email extends CI_Controller { 
 
      function __construct() { 
         parent::__construct(); 
         $this->load->library('session'); 
         $this->load->helper('form'); 
      } 
		
      public function index() { 
	
         //$this->load->helper('form'); 
         //$this->load->view('email_form'); 
      } 
  
      public function send_mail() { 
         $from_email = "uwen2020@gmail.com"; 
         $to_email = 'uen_jh@yahoo.com'; 
   
         //Load email library 
         $this->load->library('email'); 
   
         $this->email->from($from_email, 'Wenx'); 
         $this->email->to($to_email);
         $this->email->subject('Email Test'); 
         $this->email->message('Testing the email class.'); 
   
         //Send mail 
         if($this->email->send()) 
         echo "email_sent","Email sent successfully."; 
         else 
         echo "email_sent","Error in sending Email."; 
         //$this->load->view('email_form'); 
      } 
   } 
?>