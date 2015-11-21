<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-01-10
 * 
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Settings extends Admin_Controller {

    public function __construct() {
        parent::__construct();
		
		// check user permission		
		$this->users_m->userPermission('settings');
		
        $this->lang->load('settings');
    }

    function index() {
        $this->data['breadcrumb'] = lang('settings_admin_configuration_breadcrumb');
        $this->data['meta_title'] = lang('settings_admin_configuration_meta_title');
        $this->data['sub_title'] = lang('settings_admin_configuration_sub_title');
        $this->data['subview'] = 'admin/settings/index';
		
		$this->load->model('settings_m');
		
		$settings = $this->settings_m->getSetting();
		if(count($settings) > 0)
			$this->data['setting']	= json_decode($settings->settings);
		else
			$this->data['setting']	= $this->settings_m->setNew();
			
		//currencies.
		$this->data['currencies'] = $this->settings_m->getCurrencies();
		
		//language		
		$path_lang = ROOTPATH.DS.'application'.DS.'language'.DS.'english'.DS.'lang.ini';
		$path = ROOTPATH .DS. 'media'.DS.'data'.DS.'lang.ini';
		if(file_exists($path_lang))
		{
			$lang = parse_ini_file($path_lang, true);
			if(!is_array($lang))
				$this->data['lang'] = array();
			else
				$this->data['lang'] = $lang;
		}elseif(file_exists($path))
		{
			$lang = parse_ini_file($path, true);
			if(!is_array($lang))
				$this->data['lang'] = array();
			else
				$this->data['lang'] = $lang;
		}else
		{
			$this->data['lang'] = array();
		}
		
		
        $this->load->view('admin/_layout_main', $this->data);
    }
	
	function config()
	{
		if($setting 	= $this->input->post('setting'))
		{
			$data 		= array();
			$data['settings'] 	= json_encode($setting);
			$data['date'] 	= date('Y-m-d H:i:s');
			
			$this->load->model('settings_m');
			
			$settings = $this->settings_m->getSetting();
			if(count($settings) > 0)
			{
				if($this->settings_m->save($data, $settings->id))
					$this->session->set_flashdata('msg', lang('settings_admin_update_config_success_msg'));
				else
					$this->session->set_flashdata('error', lang('settings_admin_update_config_error_msg'));
			}else
			{
				if($this->settings_m->save($data))
					$this->session->set_flashdata('msg', lang('settings_admin_insert_config_success_msg'));
				else
					$this->session->set_flashdata('error', lang('settings_admin_insert_config_error_msg'));
			}
		}
		redirect('admin/settings');
	}
	
	function edit_lang()
	{
		if($this->input->post('language'))
		{
			$data = json_decode($this->input->post('language', true));
			$res = '';
			foreach($data as $key=>$val)
			{
				$val = str_replace('\\', '\\\\', $val);
				$res .= $key .'= "'. addslashes($val) .'"'.PHP_EOL;
			}
			$path_lang = ROOTPATH.DS.'application'.DS.'language'.DS.'english';
			if(!file_exists($path_lang)){
			   mkdir($path_lang, 0755, true);
			}
			$url = $path_lang.DS.'lang.ini';
			//update ini file.
			if(file_put_contents($url, $res))
				echo 1;
			else
				echo 0;
		}else
		{
			redirect(site_url().'/admin/settings');
		}
	}

    function edit($type = '', $id = '') {
        if ($type == '') {
			return;
        }
        $model = $type . '_m';
        $this->load->model($model);
		$this->data['data'] = $this->$model->getNew();
        $check = false;
		
		if($type == 'states')
			$this->data['countries'] = $this->$model->getCountries();
		
        if ($id != '') {
            if ($this->input->post('data')) {
                $this->data = $this->input->post('data');
                $check = $this->$model->checkData($this->data, $id);
				if($type == 'payment')
				{
					$update_payment = $this->input->post('data');
					$update_payment['configs'] = json_encode($this->input->post('config'));
					$this->data = $update_payment;
				}
                if ($check == true) {
                    if ($this->$model->save($this->data, $id)) {
                        $check = true;
                    }
                } else {
                    $errors['error'] = 1;
                    $errors['msg'] = lang($type . '_update_check_error_msg');
                    echo json_encode($errors);
                    return;
                }
                if ($check == true) {
                    $errors['error'] = 0;
                    $errors['msg'] = lang($type . '_update_success_msg');
                    echo json_encode($errors);
                    return;
                } else {
                    $errors['error'] = 1;
                    $errors['msg'] = lang($type . '_update_error_msg');
                    echo json_encode($errors);
                    return;
                }
            }
			$this->data['data'] = $this->$model->getData($id);
        } else {
            if ($this->input->post('data')) {
                $this->data = $this->input->post('data');
                $check = $this->$model->checkData($this->data);
                if ($check == true) {
                    if ($this->$model->save($this->data)) {
                        $check = true;
                    }
                } else {
                    $errors['error'] = 1;
                    $errors['msg'] = lang($type . '_insert_check_error_msg');
                    echo json_encode($errors);
                    return;
                }
                if ($check == true) {
                    $errors['error'] = 0;
                    $errors['msg'] = lang($type . '_inset_success_msg');
                    echo json_encode($errors);
                    return;
                } else {
                    $errors['error'] = 1;
                    $errors['msg'] = lang($type . '_insert_error_msg');
                    echo json_encode($errors);
                    return;
                }
            }
        }
		$this->data['id'] = $id;
		$this->load->view('admin/settings/edit_' . $type, $this->data);
    }

    function publish($type = '') {
        if ($type == '') {
            $type = 'lang';
        }
        $model = $type . '_m';
        $this->load->model($model);
        $check = true;
        $this->data = $this->input->post('data');
        if ($this->input->post('checkb')) {
            foreach ($this->input->post('checkb') as $id) {
                if ($this->input->post('action') == '1') {
                    $data['published'] = 0;
                } else {
                    $data['published'] = 1;
                }
                if ($id != 0)
                    $check = $this->$model->save($data, $id);
            }
            if ($check == true) {
                $errors['error'] = 0;
                $errors['msg'] = lang($type . '_msg_success');
                echo json_encode($errors);
                return;
            } else {
                $errors['error'] = 1;
                $errors['msg'] = lang($type . '_msg_error_publish');
                echo json_encode($errors);
                return;
            }
        }
    }

    function del($type = '') 
	{
        if ($type == '') 
		{
            return;
        }
        $model = $type . '_m';
        $this->load->model($model);
        $check = true;
        $this->data = $this->input->post('data');
        if ($this->input->post('checkb')) 
		{
            foreach ($this->input->post('checkb') as $id) 
			{
				if($type == 'fonts') // delete fonts.
				{
					$font = $this->$model->getFont($id);
					if(isset($font->filename) && $font->filename != '')
					{
						$path = ROOTPATH .DS. $font->path;
						//delete thumb.
						if(file_exists($path .DS. $font->thumb) && $font->thumb != '')
							unlink($path .DS. $font->thumb);
						
						$filenames = json_decode($font->filename);
						
						foreach($filenames as $key=>$file)
						{
							//delete font woff.
							if($key == 'woff' && file_exists($path .DS. $file) && $file != '')
								unlink($path .DS. $file);
							//delete font ttf.
							if($key == 'ttf' && file_exists($path .DS. $file) && $file != '')
								unlink($path .DS. $file);
						}
					}
				}
                $check = $this->$model->delete($id);
            }
            if ($check == true) 
			{
                $errors['error'] = 0;
                $errors['msg'] = lang($type . '_msg_success');
                echo json_encode($errors);
                return;
            } else 
			{
                $errors['error'] = 1;
                $errors['msg'] = lang($type . '_msg_error_del');
                echo json_encode($errors);
                return;
            }
        }
    }
	
	public function colors()
	{
		 $this->load->model('colors_m');
            $this->data['breadcrumb'] 	= lang('settings_admin_color_breadcrumb');
            $this->data['meta_title'] 	= lang('settings_admin_color_meta_title');
            $this->data['sub_title'] 	= lang('settings_admin_color_sub_title');
            $this->data['subview'] 		= 'admin/settings/colors';
			
            // pagination
            $this->load->library('pagination'); 
            $this->load->helper('url');
            $config['base_url'] 		= base_url('admin/settings/colors'); 
            
            if($this->input->post('action'))
                $this->session->set_userdata('search_colors', $this->input->post('search_vl'));
			
			$config['total_rows'] = $this->colors_m->getColors(true, $this->session->userdata('search_colors'));
			
			if($this->input->post('action'))
			{
				if($this->input->post('per_page') == 'all')
					$this->session->set_userdata('per_page', $config['total_rows']);
				else
					$this->session->set_userdata('per_page', $this->input->post('per_page'));
				$errors['error'] = 0;
                $errors['msg'] = '';
                echo json_encode($errors);
                return;
			}
			
            if($this->session->userdata('per_page') != '')
                $config['per_page'] = $this->session->userdata('per_page');
            else
                $config['per_page'] = 10;
			
            $config['uri_segment'] = 4; 
            $config['next_link'] = lang('next'); 
            $config['prev_link'] = lang('prev'); 
            $config['first_link'] = lang('first'); 
            $config['last_link'] = lang('last'); 
            $config['num_links']	= 2;                 
            $this->pagination->initialize($config); 
            $this->data['links'] = $this->pagination->create_links();
			$this->data['per_page'] = $config['per_page'];
            $this->data['colors'] = $this->colors_m->getColors(false, $this->session->userdata('search_colors'), $config['per_page'], $this->uri->segment(4));
            $this->load->view('admin/_layout_main', $this->data);
	}
	
	function Color()
	{
        $this->load->model('colors_m');
         // pagination
		$this->load->library('pagination'); 
		$this->load->helper('url');
		$config['base_url'] 		= base_url('admin/settings/colors'); 
		
		$config['total_rows'] = $this->colors_m->getColors(true, $this->session->userdata('search_colors'));
		
		if($this->session->userdata('per_page') != '')
			$config['per_page'] = $this->session->userdata('per_page');
		else
			$config['per_page'] = 10;
		
		$config['uri_segment'] = 4; 
		$config['next_link'] = lang('next'); 
		$config['prev_link'] = lang('prev'); 
		$config['first_link'] = lang('first'); 
		$config['last_link'] = lang('last'); 
		$config['num_links']	= 2;                 
		$this->pagination->initialize($config); 
		$this->data['links'] = $this->pagination->create_links();
		$this->data['colors'] = $this->colors_m->getColors(false, $this->session->userdata('search_colors'), $config['per_page'], $this->uri->segment(4));
        
		$this->load->view('admin/settings/color',$this->data);
    }
	
	//fonts
    function fonts($action = '', $id = '') 
	{
        $this->load->model('fonts_m');
        $this->data['breadcrumb']  = lang('settings_admin_fonts_breadcrumb');
        $this->data['meta_title']  = lang('settings_admin_fonts_meta_title');
        $this->data['sub_title'] = lang('settings_admin_fonts_sub_title');
        // fonts_page
        if($action == '' || ($action != 'add_cate' && $action != 'add_fonts' && $action != 'edit_fonts' && $action != 'edit_cate'))
		{
            // pagination
            $this->load->library('pagination'); 
            $this->load->helper('url');
            $config['base_url'] = base_url('admin/settings/fonts'); 

            if($this->input->post('per_page'))
			{
                $this->session->set_userdata('search_font', $this->input->post('search_font'));
                $this->session->set_userdata('option_font', $this->input->post('option_font'));
            }
			$config['total_rows'] = $this->fonts_m->getFonts(true, $this->session->userdata('search_font'), $this->session->userdata('option_font'));
			
			if($this->input->post('per_page'))
			{
				if($this->input->post('per_page') == 'all')
					$this->session->set_userdata('per_page', $config['total_rows']);
				else
					$this->session->set_userdata('per_page', $this->input->post('per_page'));
				
				$errors['error'] = 0;
				$errors['msg']	= lang('colors_msg_success');
				echo json_encode($errors);
				return;
			}
			
            if($this->session->userdata('per_page') != '')
                $config['per_page'] = $this->session->userdata('per_page');
            else
                $config['per_page'] = 10;
				
            $config['uri_segment'] = 4; 
            $config['next_link'] = lang('next'); 
            $config['prev_link'] = lang('prev'); 
            $config['first_link'] = lang('first'); 
            $config['last_link'] = lang('last'); 
            $config['num_links']	= 5;                 
            $this->pagination->initialize($config); 
            $this->data['links'] = $this->pagination->create_links();
            $this->data['per_page'] = $config['per_page'];
            $this->data['list_cate'] = $this->fonts_m->getCategories(); //get cate.
            $this->data['msg'] = $this->session->flashdata('msg');
            $this->data['subview']  = 'admin/settings/fonts';
            $this->data['fonts'] = $this->fonts_m->getFonts(false, $this->session->userdata('search_font'), $this->session->userdata('option_font'), $config['per_page'], $this->uri->segment(4));
            $this->load->view('admin/_layout_main', $this->data);
            
        }
		else
		{ // add_cate.
            if($this->input->post('action') == 'add_cate')
			{
                //add cat
                $title = $this->input->post('catename');
				
                if($this->fonts_m->checkCate($title) == false)
				{
					$cate['title'] = $title;
					$cate['published'] = 1;
					$cate['language'] = 'en';
					$cate['created'] = date('Y-m-d H:i:s');
					$cate['type'] = 'font';
					$cate['order'] = 0;
					$this->fonts_m->_table_name = 'categories';
					if($this->fonts_m->save($cate))
					{
						$errors['error'] = 0;
						$errors['msg'] = lang('fonts_add_cate_success_msg');
						echo json_encode($errors);
						return;
					}else
					{
						$errors['error'] = 1;
						$errors['msg'] = lang('fonts_add_cate_error_msg');
						echo json_encode($errors);
						return;
					}
                }else
				{
                    $errors['error'] = 1;
                    $errors['msg'] = $title.lang('cate_error_title');
                    echo json_encode($errors);
                    return;
                }
            }else
			{
                $this->load->model('categories_m');
				$this->data['type'] = $this->uri->segment(4);
                if(is_string($this->data['type']) && (int)$this->data['type'] == 0)
				{
                    $this->data['data'] = $this->session->flashdata('data');
                    $this->data['error'] = $this->session->flashdata('error');
                    $this->data['id'] = $id;
                    $this->data['cate'] = $this->fonts_m->getCategories();
					$this->data['font'] = $this->fonts_m->getNew();
                    if($action == 'add_cate')
					{  //reload cate
						if($id != '')
							$this->data['font'] = $this->fonts_m->getFont($id);
                        $this->load->view('admin/settings/add_cate', $this->data);
                    }elseif($action == 'add_fonts' && $id == '')
					{  //add
                        $this->data['subview'] = 'admin/settings/edit_fonts';
                        $this->load->view('admin/_layout_main', $this->data);
                    }elseif($action == 'edit_fonts' && $id != '')
					{ //edit
                        $this->data['font'] = $this->fonts_m->getFont($id);
                        if(count($this->data['font']) > 0){
                            $this->data['subview'] = 'admin/settings/edit_fonts';
                            $this->load->view('admin/_layout_main', $this->data);
                        }else
						{
							redirect(site_url().'admin/settings/fonts');
						}
                    }else
					{
						redirect(site_url().'admin/settings/fonts');
					}
                }else
				{
					redirect(site_url().'admin/settings/fonts');
				}
            }
        }
    }
	
	function font(){
        $this->load->model('fonts_m');
        // pagination
        $this->load->library('pagination'); 
        $this->load->helper('url');
        $config['base_url'] = base_url('admin/settings/fonts'); 
        $config['total_rows'] = $this->fonts_m->getFonts(true, $this->session->userdata('search_font'), $this->session->userdata('option_font'));

        if($this->session->userdata('per_page') != '')
		{
            $config['per_page'] = $this->session->userdata('per_page');
        }else{
            $config['per_page'] = 10;
        }
        $config['uri_segment'] = 4; 
        $config['next_link'] = lang('next'); 
        $config['prev_link'] = lang('prev'); 
        $config['first_link'] = lang('first'); 
        $config['last_link'] = lang('last'); 
        $config['num_links']	= 5;                 
        $this->pagination->initialize($config); 
        $this->data['links'] = $this->pagination->create_links();
        $this->data['per_page'] = $config['per_page'];
        $this->data['list_cate'] = $this->fonts_m->getCategories(); //get cate.
        $this->data['msg'] = $this->session->flashdata('msg');
        $this->data['fonts'] = $this->fonts_m->getFonts(false, $this->session->userdata('search_font'), $this->session->userdata('option_font'), $config['per_page'], $this->uri->segment(4));
		
		$this->load->view('admin/settings/font', $this->data);
	}
	
	public function fontGoogle($add = false)
	{
		$this->load->model('fonts_m');
		
		// add google font
		if ($add == 1)
		{
			$cate_id 	= $this->input->post('cate_id');
			$fonts 		= $this->input->post('fonts');
			
			$data 			= $this->fonts_m->getNew();
			$data->cate_id	= $cate_id;
			$data->type		= 'google';
			for($i=0; $i<count($fonts); $i++)
			{
				$data->title 	= $fonts[$i];
				$data->subtitle = $fonts[$i];
				
				$font 			= json_decode(json_encode($data), true);
				$this->fonts_m->save($font);
			}
			return;
		}
		
		// load meta
        $this->data['breadcrumb']  = lang('settings_admin_fonts_breadcrumb');
        $this->data['meta_title']  = lang('settings_admin_fonts_meta_title');
        $this->data['sub_title'] = lang('settings_admin_fonts_sub_title');
		
		$this->data['categories'] = $this->fonts_m->getCategories(); //get cate.
		
		// load all google fonts
		$google					= file_get_contents(ROOTPATH .DS. 'media' .DS. 'data' .DS. 'fonts.json');
		$google					= json_decode($google, true);
		$this->data['google']	= $google;
		
		// load fonts added
		$this->fonts_m->db->select('title');
		$this->fonts_m->db->where('type', 'google');
		$rows					= $this->fonts_m->get();
		$fonts 	= array();
		for ($i=0; $i<count($rows); $i++)
		{
			$fonts[]	= $rows[$i]->title;
		}
		$this->data['fonts']	= json_encode($fonts);		
		
		// view layout
		$this->data['subview'] = 'admin/settings/font_google';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	function editCate()
	{
		if($this->input->post('title'))
		{
			//add cat
			$id = $this->input->post('id');
			$this->load->model('fonts_m');
			$data['title'] = $this->input->post('title');
			if($id == '')
			{
				$errors['error'] = 1;
				$errors['msg'] = lang('fonts_cate_update_system_error_msg');
				echo json_encode($errors);
				return;
				exit;
			}
			
			$check = $this->fonts_m->checkCate($this->input->post('title'), $id);
			if($check == FALSE){
				$this->fonts_m->_table_name = 'categories';
				$this->fonts_m->save($data, $id);
				$errors['error'] = 0;
				$errors['msg'] = lang('cate_msg_title');
				echo json_encode($errors);
				return;
			}else{
				$errors['error'] = 1;
				$errors['msg'] = lang('fonts_cate_update_title_error_msg');
				echo json_encode($errors);
				return;
			}
		}
	}
	
	function delCate()
	{
		if($id = $this->input->post('id'))
		{
			$this->load->model('fonts_m');
			$this->fonts_m->_table_name = 'categories';
			if($this->fonts_m->delete($id))
			{
				$errors['error'] = 0;
				$errors['msg'] = lang('cate_msg_title');
				echo json_encode($errors);
				return;
			}else{
				$errors['error'] = 1;
				$errors['msg'] = lang('fonts_cate_delete_error_msg');
				echo json_encode($errors);
				return;
			}
		}
	}
	
	function upload($id = ''){
	
        if($this->input->post('action') == 'upload'){
            $count = 0;
            foreach($_FILES as $key => $file){
                
				if(isset($_FILES[$key]['name']) && $_FILES[$key]['name'] != ''){
					$path = ROOTPATH .DS. 'media'.DS.'fonts';
					if(!file_exists($path)){
					   mkdir($path, 0755, true);
					}
			
                    $checkname = array('~', '`', '!', '@', '#', '$', '%', '^', '&', '(', ')', '+', '=', '[',']', '{','}', ':', ' ', ',', '\'', ';');
                    if($count == 0){
                        $config['allowed_types'] = 'woff';
                        $config['file_name'] = str_replace( $checkname , '', $_FILES[$key]['name'] );
                        $config['max_size']	= '2048';
                    }elseif($count == 1){
                        $config['allowed_types'] = 'ttf|TTF';
                        $config['file_name'] = str_replace( $checkname , '', $_FILES[$key]['name'] );
                        $config['max_size']	= '2048';
                    }else{
                        $config['allowed_types'] = 'jpg|png|gif|jpeg';
                        $config['file_name'] = str_replace( $checkname , '', $_FILES[$key]['name'] );
                        $config['max_size']	= '2048';
                    }
                    $config['upload_path'] = $path;
                    $this->load->library('upload');
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload($key))
					{ 
                        $this->data['error'] = $this->upload->display_errors().lang('fonts_file_name_msg').': '.$_FILES[$key]['name'];
                        if(isset($this->info[0]) && file_exists($this->info[0]['full_path'])){
                            unlink($this->info[0]['full_path']);
                        }
                        break;
                    }else{   
                        $this->info[] = $this->upload->data();
                        $this->key[] = $key;
                    }
                }
                $count++;
            }
            if(isset($this->data['error']))
			{ //error upload font.
                if($id == ''){ //add
                    $this->session->set_flashdata('data', $this->input->post('data'));
                    $this->session->set_flashdata('error', $this->data['error']);
                    redirect(site_url().'admin/settings/fonts/add_fonts');
                }else{ //edit
                    $this->session->set_flashdata('data', $this->input->post('data'));
                    $this->session->set_flashdata('error', $this->data['error']);
                    redirect(site_url().'admin/settings/fonts/edit_fonts/'.$id);
                }
            }else
			{  // insert or update.
                $this->load->model('fonts_m');
                $data = $this->input->post('data');
				
				// Set form
				$this->load->library('form_validation');
							  
				$this->form_validation->set_rules('data[title]', lang('title'), 'trim|required|min_length[2]|max_length[255]');
				$this->form_validation->set_rules('data[subtitle]', lang('subtitle'), 'trim|required|min_length[2]|max_length[255]'); 
				
				if($this->form_validation->run() == TRUE)
				{
					if(isset($this->info))
					{ //upload font success.
						for($i=0; $i<count($this->info); $i++)
						{
							if($this->key[$i] == 'font')
							{
								$woff = $this->info[$i]['file_name'];
							}elseif($this->key[$i] == 'font_ttf')
							{
								$ttf = $this->info[$i]['file_name'];
							}elseif($this->key[$i] == 'thumb')
							{
								$data['thumb'] = $this->info[$i]['file_name'];
								$font_thumb = $this->input->post('font_thumb');
								if(file_exists($path.DS.$font_thumb) && $font_thumb != ''){
									unlink($path.DS.$font_thumb);
								}
							}
						}
						
						//get json font.
						if($this->input->post('font_file') && $id != '' && (isset($woff) || isset($ttf))) //update font.
						{
							$font = json_decode($this->input->post('font_file'));
							if(isset($woff) && isset($font->woff))
							{
								$font_woff = array('woff'=>$woff);
								if(file_exists($path.DS.$font->woff) && $font->woff != '')
								{
									unlink($path.DS.$font->woff);
								}
							}elseif(isset($font->woff))
							{
								$font_woff = array('woff'=>$font->woff);
							}
							if(isset($ttf) && isset($font->ttf))
							{
								$font_ttf = array('ttf'=>$ttf);
								if(file_exists($path.DS.$font->ttf) && $font->ttf != '')
								{
									unlink($path.DS.$font->ttf);
								}
							}elseif(isset($font->ttf))
							{
								$font_ttf = array('ttf'=>$font->ttf);
							}elseif(isset($ttf))
							{
								$font_ttf = array('ttf'=>$ttf);
							}
							
							if(isset($font_woff) && isset($font_ttf))
							{
								$data['filename'] = json_encode(array_merge($font_woff, $font_ttf));
							}elseif(isset($font_woff))
							{
								$data['filename'] = json_encode(array_merge($font_woff));
							}
						}elseif($id == '')//insert font.
						{
							$data['path'] = 'media'.DS.'fonts';
							if(isset($woff) && isset($ttf))
							{
								$font_woff = array('woff'=>$woff);
								$font_ttf = array('ttf'=>$ttf);
								$data['filename'] = json_encode(array_merge($font_woff, $font_ttf));
							}elseif(isset($woff))
							{
								$font_woff = array('woff'=>$woff);
								$data['filename'] = json_encode(array_merge($font_woff));
							}else
							{
								$this->session->set_flashdata('data', $data);
								$this->session->set_flashdata('error', lang('fonts_add_woff_upload_error_msg'));
								redirect(site_url().'admin/settings/fonts/add_fonts');
							}
						}
						
					}
					
					$data['published'] = 1;
					
					//Not file name upload add.
					if($id == '' && (!isset($data['filename']) || $data['filename'] == ''))
					{
						$this->session->set_flashdata('data', $data);
						$this->session->set_flashdata('error', lang('fonts_edit_error_msg'));
						redirect(site_url().'admin/settings/fonts/add_fonts');
					}	
					
					if($id == '') //insert font data.
					{ 
						$id = $this->fonts_m->save($data);
						$this->session->set_flashdata('msg', lang('fonts_upload_msg'));
						redirect(site_url().'admin/settings/fonts');
					}else //update font data.
					{ 
						if($this->fonts_m->save($data, $id))
						{
							$this->session->set_flashdata('msg', lang('fonts_edit_success_msg'));
							redirect(site_url().'admin/settings/fonts');
						}else
						{
							$this->session->set_flashdata('error', lang('fonts_edit_error_msg'));
							redirect(site_url().'admin/settings/fonts/edit_fonts/'.$id);
						}
					}
				}else
				{
					$this->session->set_flashdata('error', lang('fonts_upload_error_msg'));
					redirect(site_url().'admin/settings/fonts/add_fonts');
				}
            }
        }
    }
	
	// emails.
	function emails(){
		$this->data['breadcrumb'] = lang('settings_admin_email_breadcrumb');
        $this->data['meta_title'] = lang('settings_admin_email_meta_title');
        $this->data['sub_title'] = lang('settings_admin_email_sub_title');
		
		$this->load->model('email_m');
		
		if($this->input->post('message')){
			$this->load->helper('security');
			$msg = $this->input->post('message', true);
			$check = false;
			$data = $this->email_m->getEmail();
			foreach($msg as $key=>$val)
			{
				if(count($data) > 0){
					$insert['label'] = xss_clean($key);
					$insert['message'] = xss_clean(htmlTag($val));
					$check = $this->email_m->update($insert, $key);
				}else
				{
					$insert['label'] = xss_clean($key);
					$insert['message'] = xss_clean(htmlTag($val));
					$check = $this->email_m->save($insert);
				}
			}
			
			if($check){
				$this->data['msg'] =  lang('settings_email_success_msg');
			}else{
				$this->data['error'] = lang('settings_email_error_msg');
			}
		}	
		
		$email = array();
		$mail = $this->email_m->getEmail();
		for($i=0; $i<count($mail); $i++)
		{
			foreach($mail[$i] as $key=>$value)
			{
				if($key == 'label')
					$label = $value;
				if($key == 'message')
					$email[$label] = $value;
			}
		}
		
		$this->data['email'] = $email;
		$this->data['subview'] = 'admin/settings/emails';
        $this->load->view('admin/_layout_main', $this->data);
	}
	
	function shipping()
	{
		$this->load->model('shipping_m');
		$this->data['breadcrumb'] = lang('settings_admin_shipping_method_breadcrumb');
        $this->data['meta_title'] = lang('settings_admin_shipping_method_meta_title');
        $this->data['sub_title'] = lang('settings_admin_shipping_method_sub_title');
        $this->data['subview'] = 'admin/settings/shipping';
        $this->data['shipping'] = $this->shipping_m->getData();
		
        $this->load->view('admin/_layout_main', $this->data);
	}
	
	function changeDefault($type)
	{
		if ($type == 'shipping' || $type == 'payment') 
		{
			$model = $type.'_m';
			$this->load->model($model);
			
			$check = true;
			if ($this->input->post('checkb')) 
			{
				$checkb = $this->input->post('checkb', true);
				foreach($checkb as $id)
				{
					$defaul = $type.'default';
					$res = $this->$model->$defaul();
					if(isset($res->id))
					{
						$data['default'] = 0;
						$this->$model->save($data, $res->id);
					}
					$check = $this->$model->$defaul($id);
				}
				if ($check == true) {
					$errors['error'] = 0;
					$errors['msg'] = lang('default_msg_success');
					echo json_encode($errors);
					return;
				} else {
					$errors['error'] = 1;
					$errors['msg'] = lang('default_msg_error_default');
					echo json_encode($errors);
					return;
				}
			}
        }else
		{
			$errors['error'] = 1;
			$errors['msg'] = lang('default_msg_error_default');
			echo json_encode($errors);
			return;
		}
	}
	
	function ship()
	{
		$this->load->model('shipping_m');
		$this->data['breadcrumb'] = lang('settings_admin_shipping_shop_breadcrumb');
        $this->data['meta_title'] = lang('settings_admin_shipping_shop_meta_title');
        $this->data['sub_title'] = lang('settings_admin_shipping_shop_sub_title');
        $this->data['shipping'] = $this->shipping_m->getData();
		
        $this->load->view('admin/settings/ship', $this->data);
	}
	
	function payment()
	{
		$this->load->model('payment_m');
		$this->data['breadcrumb'] = lang('settings_admin_payment_method_breadcrumb');
        $this->data['meta_title'] = lang('settings_admin_payment_method_meta_title');
        $this->data['sub_title'] = lang('settings_admin_payment_method_sub_title');
        $this->data['subview'] = 'admin/settings/payment';
        $this->data['payment'] = $this->payment_m->getData();
		
        $this->load->view('admin/_layout_main', $this->data);
	}
	
	function pay()
	{
		$this->load->model('payment_m');
		$this->data['breadcrumb'] = lang('settings_admin_payment_method_breadcrumb');
        $this->data['meta_title'] = lang('settings_admin_payment_method_meta_title');
        $this->data['sub_title'] = lang('settings_admin_payment_method_sub_title');
        $this->data['subview'] = 'admin/settings/payment';
        $this->data['payment'] = $this->payment_m->getData();
		
        $this->load->view('admin/settings/pay', $this->data);
	}
	
	public function fields($type = '', $id = '')
	{
		$this->data['error'] = '';
		$this->data['id'] = $id;
		if($type == '')
		{
			$this->data['breadcrumb'] = lang('user_admin_fields_breadcrumb');
			$this->data['meta_title'] = lang('user_admin_fields_meta_title');
			$this->data['sub_title'] = lang('user_admin_fields_sub_title');
			
			$this->data['fields'] = $this->users_m->getForms();
			$this->data['subview'] = 'admin/settings/fields';
			$this->load->view('admin/_layout_main', $this->data);
		}
		elseif($type == 'edit')
		{
			$this->data['breadcrumb'] = lang('user_admin_field_add_breadcrumb');
			$this->data['meta_title'] = lang('user_admin_field_add_meta_title');
			
			if($data = $this->input->post('data'))
			{
				// Set form  
				$this->form_validation->set_rules('data[name]', lang('name'), 'trim|required|min_length[2]|max_length[255]|xss_clean'); 
				$this->form_validation->set_rules('data[title]', lang('title'), 'trim|required|min_length[2]|max_length[255]|xss_clean'); 
				$this->form_validation->set_rules('form[]', lang('forms'), 'trim|required'); 
				$this->form_validation->set_rules('data[type]', lang('type'), 'trim|required'); 
				$this->form_validation->set_rules('data[publish]', lang('publish'), 'trim|required'); 
				$this->form_validation->set_rules('data[validate]', lang('validate'), 'trim|required'); 
				
				$params = array(
					'style'=>$this->input->post('style'),
				);
				$data['params'] = json_encode($params);
				
				if($this->form_validation->run() == TRUE)
				{
					$data['forms'] = json_encode($this->input->post('form'));
					
					if($data['type'] == 'radio' || $data['type'] == 'select')
					{
						$val = array();
						$title = $this->input->post('title');
						$value = $this->input->post('value');
						if(is_array($title) && is_array($value))
						{
							for($i=0; $i<count($title); $i++)
							{
								$val[$title[$i]] = $value[$i];
							}
						}
						$data['value'] = json_encode($val);
					}else
					{
						$data['value'] = $this->input->post('val');
					}
					$data['order'] = $this->input->post('order');
					$this->users_m->_table_name = 'custom_fields';
					if($id == '')
					{
						if($this->users_m->save($data))
						{
							$this->session->set_flashdata('msg', lang('field_admin_add_susscess'));
							redirect(site_url().'admin/settings/fields');
						}else
						{
							$this->data['error'] = lang('field_admin_add_error_msg');
						}
					}else
					{
						if($this->users_m->save($data, $id))
						{
							$this->session->set_flashdata('msg', lang('field_admin_edit_susscess'));
							redirect(site_url().'admin/settings/fields');
						}else
						{
							$this->data['error'] = lang('field_admin_edit_error_msg');
						}
					}
				}
			}
			if($id == '')
				$this->data['field'] = $this->users_m->getNewForm();
			else	
				$this->data['field'] = $this->users_m->getForm($id);
			$this->data['subview'] = 'admin/settings/edit_field';
			$this->load->view('admin/_layout_main', $this->data);
		}
	}
	
	public function published ($id = ''){
		if($id != ''){
			$data['publish'] = 1;
			$this->users_m->_table_name = 'custom_fields';
			$this->users_m->save($data, $id);
			redirect(site_url().'admin/settings/fields');
		}else{
			if($this->input->post('checkb') != ''){
				foreach($this->input->post('checkb') as $id){
					$data['publish'] = 1;
					$this->users_m->_table_name = 'custom_fields';
					$this->users_m->save($data, $id);
				}
			}
				redirect(site_url().'admin/settings/fields');
		}
	}
	
	public function unPublished ($id = ''){
		if($id != ''){
			$data['publish'] = 0;
			$this->users_m->_table_name = 'custom_fields';
			$this->users_m->save($data, $id);
			redirect(site_url().'admin/settings/fields');
		}else{
			if($this->input->post('checkb') != ''){
				foreach($this->input->post('checkb') as $id){
					$data['publish'] = 0;
					$this->users_m->_table_name = 'custom_fields';
					$this->users_m->save($data, $id);
				}
			}
			redirect(site_url().'admin/settings/fields');
		}
	}

	public function deleteField ($id = '')
	{
		$this->users_m->_table_name = 'custom_fields';
		if($id != ''){
			if($this->users_m->delete($id))
				$this->session->set_flashdata('msg', lang('field_delete_success_msg'));
			else
				$this->session->set_flashdata('error', lang('field_delete_error_msg'));
			
			redirect(site_url().'admin/settings/fields');
		}else{
			if($this->input->post('checkb') != ''){
				foreach($this->input->post('checkb') as $id){
					$this->users_m->delete($id);
				}
				$this->session->set_flashdata('msg', lang('field_delete_success_msg'));
				redirect(site_url().'admin/settings/fields');
			}else{
				$this->session->set_flashdata('error', lang('field_delete_error_msg'));
				redirect(site_url().'admin/settings/fields');
			}
		}
	}
	
	// Currencies
    function currencies() {
		//meta title.
        $this->data['breadcrumb'] = lang('user_admin_currencies_breadcrumb');
        $this->data['meta_title'] = lang('user_admin_currencies_meta_title');
        $this->data['sub_title'] = lang('user_admin_currencies_sub_title');
        $this->load->model('currencies_m');
        $this->data['subview'] = 'admin/settings/currencies';
		
        // pagination
		$this->load->library('pagination'); 
		$this->load->helper('url');
		$config['base_url'] = base_url('admin/settings/currencies'); 
		
		// if search exists.
		if($this->input->post('action'))
			$this->session->set_userdata('search_currency', $this->input->post('search_c'));
			
		$config['total_rows'] = $this->currencies_m->getCurrencies(true, $this->session->userdata('search_currency'));
		
		// per_page.
		if($this->input->post('action'))
		{
			if($this->input->post('per_page') == 'all')
				$this->session->set_userdata('per_page', $config['total_rows']);
			else
				$this->session->set_userdata('per_page', $this->input->post('per_page'));
			$errors['error'] = 0;
			$errors['msg'] = '';
			echo json_encode($errors);
			return;
		}
		
		if($this->session->userdata('per_page'))
			$config['per_page'] = $this->session->userdata('per_page');
		else
			$config['per_page'] = 10;
		
		// config.
		$config['uri_segment'] = 4; 
		$config['next_link'] = lang('next'); 
		$config['prev_link'] = lang('prev'); 
		$config['first_link'] = lang('first'); 
		$config['last_link'] = lang('last'); 
		$config['num_links']	= 2;                 
		$this->pagination->initialize($config); 
		$this->data['links'] = $this->pagination->create_links();
		$this->data['per_page'] = $config['per_page'];
		$this->data['currencies'] = $this->currencies_m->getCurrencies(false, $this->session->userdata('search_currency'), $config['per_page'], $this->uri->segment(4));
		$this->load->view('admin/_layout_main', $this->data);
    }

    function currencie() {
        $this->load->model('currencies_m');
		
        // pagination
		$this->load->library('pagination'); 
		$this->load->helper('url');
		$config['base_url'] = base_url('admin/settings/currencies'); 
			
		$config['total_rows'] = $this->currencies_m->getCurrencies(true, $this->session->userdata('search_currency'));
				
		if($this->session->userdata('per_page'))
			$config['per_page'] = $this->session->userdata('per_page');
		else
			$config['per_page'] = 10;
		
		// config.
		$config['uri_segment'] = 4; 
		$config['next_link'] = lang('next'); 
		$config['prev_link'] = lang('prev'); 
		$config['first_link'] = lang('first'); 
		$config['last_link'] = lang('last'); 
		$config['num_links']	= 2;                 
		$this->pagination->initialize($config); 
		$this->data['links'] = $this->pagination->create_links();
		$this->data['per_page'] = $config['per_page'];
		$this->data['currencies'] = $this->currencies_m->getCurrencies(false, $this->session->userdata('search_currency'), $config['per_page'], $this->uri->segment(4));
		
		$this->load->view('admin/settings/currencie', $this->data);
    }
	
	// get all country
    function countries() {
        $this->load->model('countries_m');
        $this->data['breadcrumb'] = lang('user_admin_countries_breadcrumb');
        $this->data['meta_title'] = lang('user_admin_countries_meta_title');
        $this->data['sub_title'] = lang('user_admin_countries_sub_title');
        $this->data['subview'] = 'admin/settings/countries';
		
        // pagination
        $this->load->library('pagination'); 
        $this->load->helper('url');
        $config['base_url'] = base_url('admin/settings/countries'); 
		
		if($this->input->post('action'))
			$this->session->set_userdata('search_country', $this->input->post('search'));
			
        $config['total_rows'] = $this->countries_m->getCountries(true, $this->session->userdata('search_country'));
		
        if($this->input->post('action'))
		{
            if($this->input->post('per_page') == 'all')
                $this->session->set_userdata('per_page', $config['total_rows']);
            else
                $this->session->set_userdata('per_page', $this->input->post('per_page'));
            
            $errors['error'] = 0;
            $errors['msg']	= lang('countries_msg_success');
            echo json_encode($errors);
            return;
        }
		
        if($this->session->userdata('per_page') != '')
            $config['per_page'] = $this->session->userdata('per_page');
        else
            $config['per_page'] = 10;
        
        $config['uri_segment'] = 4; 
        $config['next_link'] = lang('next'); 
        $config['prev_link'] = lang('prev'); 
        $config['first_link'] = lang('first'); 
        $config['last_link'] = lang('last'); 
        $config['num_links']	= 2;                 
        $this->pagination->initialize($config); 
        $this->data['links'] = $this->pagination->create_links();
        $this->data['per_page'] = $config['per_page'];
		
        $this->data['countries'] = $this->countries_m->getCountries(false, $this->session->userdata('search_country'), $config['per_page'], $this->uri->segment(4)); 
        $this->load->view('admin/_layout_main', $this->data);
    }

    // get table of country
    function country() {
        $this->load->model('countries_m');
        // pagination
        $this->load->library('pagination'); 
        $this->load->helper('url');
        $config['base_url'] = base_url('admin/settings/countries'); 
		
        $config['total_rows'] = $this->countries_m->getCountries(true, $this->session->userdata('search_country'));
		
        if($this->session->userdata('per_page') != '')
            $config['per_page'] = $this->session->userdata('per_page');
        else
            $config['per_page'] = 10;
        
        $config['uri_segment'] = 4; 
        $config['next_link'] = lang('next'); 
        $config['prev_link'] = lang('prev'); 
        $config['first_link'] = lang('first'); 
        $config['last_link'] = lang('last'); 
        $config['num_links']	= 2;                 
        $this->pagination->initialize($config); 
        $this->data['links'] = $this->pagination->create_links();
        $this->data['per_page'] = $config['per_page'];
		
        $this->data['countries'] = $this->countries_m->getCountries(false, $this->session->userdata('search_country'), $config['per_page'], $this->uri->segment(5)); 
        
		$this->load->view('admin/settings/country', $this->data);
    }

	// get all states
    function states() {
        $this->load->model('states_m');
        $this->data['breadcrumb'] = lang('user_admin_states_breadcrumb');
        $this->data['meta_title'] = lang('user_admin_states_meta_title');
        $this->data['sub_title'] = lang('user_admin_states_sub_title');
        $this->data['subview'] = 'admin/settings/states';
		
        // pagination
        $this->load->library('pagination'); 
        $this->load->helper('url');
        $config['base_url'] = base_url('admin/settings/states'); 
		
		if($this->input->post('action'))
			$this->session->set_userdata('search_state', $this->input->post('search'));
			
        $config['total_rows'] = $this->states_m->getStates(true, $this->session->userdata('search_state'));
		
        if($this->input->post('action'))
		{
            if($this->input->post('per_page') == 'all')
                $this->session->set_userdata('per_page', $config['total_rows']);
            else
                $this->session->set_userdata('per_page', $this->input->post('per_page'));
            
            $errors['error'] = 0;
            $errors['msg']	= lang('states_msg_success');
            echo json_encode($errors);
            return;
        }
		
        if($this->session->userdata('per_page') != '')
            $config['per_page'] = $this->session->userdata('per_page');
        else
            $config['per_page'] = 10;
        
        $config['uri_segment'] = 4; 
        $config['next_link'] = lang('next'); 
        $config['prev_link'] = lang('prev'); 
        $config['first_link'] = lang('first'); 
        $config['last_link'] = lang('last'); 
        $config['num_links']	= 2;                 
        $this->pagination->initialize($config); 
        $this->data['links'] = $this->pagination->create_links();
        $this->data['per_page'] = $config['per_page'];
		
        $this->data['states'] = $this->states_m->getStates(false, $this->session->userdata('search_state'), $config['per_page'], $this->uri->segment(4)); 
        $this->load->view('admin/_layout_main', $this->data);
    }

    // get table of states
    function state() {
        $this->load->model('states_m');
        // pagination
        $this->load->library('pagination'); 
        $this->load->helper('url');
        $config['base_url'] = base_url('admin/settings/states'); 
		
		if($this->input->post('action'))
			$this->session->set_userdata('search_state', $this->input->post('search'));
			
        $config['total_rows'] = $this->states_m->getStates(true, $this->session->userdata('search_state'));
		
        if($this->session->userdata('per_page') != '')
            $config['per_page'] = $this->session->userdata('per_page');
        else
            $config['per_page'] = 10;
        
        $config['uri_segment'] = 4; 
        $config['next_link'] = lang('next'); 
        $config['prev_link'] = lang('prev'); 
        $config['first_link'] = lang('first'); 
        $config['last_link'] = lang('last'); 
        $config['num_links']	= 2;                 
        $this->pagination->initialize($config); 
        $this->data['links'] = $this->pagination->create_links();
        $this->data['per_page'] = $config['per_page'];
		
        $this->data['states'] = $this->states_m->getStates(false, $this->session->userdata('search_state'), $config['per_page'], $this->uri->segment(4)); 
       
		$this->load->view('admin/settings/state', $this->data);
    }
}

?>