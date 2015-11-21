<?php 

	if($this->session->flashdata('msg') != '')
	{
		echo '<div class="alert alert-success">'.$this->session->flashdata('msg').'</div>';
	}
	if($this->session->flashdata('error') != '')
	{
		echo '<div class="alert alert-danger">'.$this->session->flashdata('error').'</div>';
	}
		
	if($this->session->flashdata('message') != '')
	{
		echo '<div class="payment_info">'.$this->session->flashdata('message').'</div>';
	}
	
?>