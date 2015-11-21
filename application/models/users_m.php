<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-01-10
 * 
 * users model
 * 
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_m extends MY_Model
{
	
	public $_table_name = 'users';
	protected $_order_by = 'name';
	public $_primary_key 	= 'id';

	function __construct ()
	{
		parent::__construct();
	}

	public function login ($admin = true, $email = '')
	{
		if($admin == false)
		{
			if($data = $this->input->post('data'))
			{
				$user = $this->get_by(array(
					'email' => $data['email'],
					'password' => $this->hash($data['password']),
					'block' => 0
				), TRUE);	
			}
			else
			{
				$user = $this->get_by(array(
					'email' => $email,
					'block' => 0
				), TRUE);	
			}
		}
		else
		{
			$user = $this->get_by(array(
				'email' => $this->input->post('email'),
				'password' => $this->hash($this->input->post('password')),	
				'block' => 0				
			), TRUE);
			
			if (count($user) > 0)
			{
				// check user permission
				$check = $this->userPermission('users', $user->id, false);
			}
			else
			{
				return false;
			}
			
			if ($check === false)
				return false;
		}
		
		if (count($user)) {
			// Log in user
			$data = array(
				'id' => $user->id,
				'name' => $user->name,
				'username' => $user->username,
				'email' => $user->email,				
				'admin' => $admin,
				'loggedin' => TRUE,
			);
			$this->session->set_userdata('user', $data);			
			return true;
		}else
		{
			return false;
		}
	}

	public function logout ()
	{
		$this->session->sess_destroy();
	}

	public function loggedin ()
	{
		$user	= $this->session->userdata('user');
		if(isset($user['admin']))
			return (bool) $user['admin'];
		else
			return false;
	}
	
	public function updatePass($pass, $id){
		$data['password'] = $this->hash($pass);
		return parent::save($data, $id);
	}
	
	//forgot password.
	public function checkEmail($where){
		$this->db->where($where);
		$query = $this->db->get('users');
		return $query->row();
	}
	
	public function changePass($pass, $where){
		$data['password'] = $this->hash($pass);
		$this->db->set($data);
		$this->db->where($where);
		if($this->db->update('users')){
			return true;
		}else{
			return false;
		};
	}
	
	public function getKey($key){
		$this->db->where('key', $key);
		$query = $this->db->get('users_temp');
		return $query->row();
	}
	
	public function addUserTemp($data){
		$this->_table_name = 'users_temp';
		$this->_order_by = 'id';
		$this->db->where('email', $data['email']);
		$row = parent::get();
		if (count($row)){
			return parent::save($data, $row[0]->id);
		} else {
			return parent::save($data);
		}
	}
	
	public function getNew(){
		$user = new stdClass();
		$user->name 		= '';
		$user->username 	= '';
		$user->email 		= '';
		$user->group 		= '';
		$user->password 	= '';
		return $user;
	}

	public function hash ($string)
	{
		return hash('sha512', $string . config_item('encryption_key'));
	}
	
	// users shop.
	public function getUsers($count = false, $search='', $o_search='', $number = '', $segment = '')
	{
		if($o_search == 'name' && $search != '')
			$this->db->where('`name` LIKE \'%'.$search.'%\' OR `username` LIKE \'%'.$search.'%\'');
		elseif($o_search == 'email' && $search != '')
			$this->db->like('email', $search);
		
		$this->db->order_by('users.register_date', 'DESC');
		
		if($count == true)
		{
			$query = $this->db->get('users');
			return count($query->result());
		}else
		{
			$query = $this->db->get('users', $number, $segment);
			return $query->result();
		}
	}
	
	public function getUser ($id = '')
	{
		if($id == ''){
			$query = $this->db->get('users');
			return $query->result();
		}else{
			$this->db->where('id', $id);
			$query = $this->db->get('users');
			return $query->row();
		}
	}
	
	public function checkUser($where)
	{
		$this->db->where($where);
		$query = $this->db->get('users');
		if($query->num_rows() > 0)
			return true;
		else
			return false;
	}
	
	public function delete($id){
		$this->db->where('id', $id);
		if(!$this->db->delete($this->_table_name))
			return false;
		else	
			return true;
	}
	
	public function checkPass($pass){
		$this->db->where('id', $this->user['id']);
		$this->db->where('password', $this->hash($pass));
		$query = $this->db->get('users');
		if($query->num_rows())
			return true;
		else	
			return false;
	}
	
	public function getNewForm(){
		$form = new stdClass();
		$form->title = '';
		$form->name = '';
		$form->type = '';
		$form->forms = '';
		$form->publish = '';
		$form->value = '';
		$form->validate = '';
		$form->style = '';
		$form->order = 0;
		$form->params = '[]';
		return $form;
	}
	
	public function getForms()
	{
		$this->db->order_by('order');
		$query = $this->db->get('custom_fields');
		return $query->result();
	}
	
	public function getForm($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('custom_fields');
		return $query->row();
	}
	
	public function getFormField($res)
	{
		$this->db->where('publish', 1);
		$this->db->like('forms', $res);
		$this->db->order_by('order');
		$query = $this->db->get('custom_fields');
		return $query->result();
	}
	
	public function checkField($object = '')
	{
		$this->db->where('form_field', 'register');
		$this->db->where('object', $object);
		$query = $this->db->get('fields_value');
		return $query->result();
	}
	
	public function getNewGroup()
	{
		$group = new stdClass();
		$group->title = '';
		$group->permissions = '[]';
		return $group;
	}
	
	public function checkTitleGroup($title = '', $id = '')
	{
		if($id != '')
			$this->db->where('id !=', $id);
		$this->db->where('title', $title);
		$query = $this->db->get('user_groups');
		if($query->num_rows() > 0)
			return true;
		else
			return false;
	}
	
	public function getGroupsUser($count = false, $pageg = true, $search = '', $number = '', $segment = '')
	{
		if($search != '')
			$this->db->like('title', $search);
		if($count == true)
		{
			$query = $this->db->get('user_groups');
			return count($query->result());
		}else
		{
			if($pageg == true)
				$query = $this->db->get('user_groups', $number, $segment);
			else
				$query = $this->db->get('user_groups');
			return $query->result();
		}
	}
	public function getGroupUser($id = '', $default = true)
	{
		if($default == false)
			$this->db->where('default', 0);
		$this->db->where('id', $id);
		$query = $this->db->get('user_groups');
		return $query->row();
	}
	
	public function getDefault()
	{
		$this->db->where('default', 1);
		$query = $this->db->get('user_groups');
		return $query->row();
	}
	
	public function getUsersGroup($group = '')
	{
		$this->db->where('group', $group);
		$query = $this->db->get('users');
		return $query->result();
	}
	
	public function deleteFields($id = '')
	{
		$this->db->where('form_field', 'register');
		$this->db->where('object', $id);
		$this->db->delete('fields_value');
	}
	
	// statistical
	public function getCountUsers()
	{
		return $this->db->count_all('users');
	}
	
	public function getCountCliparts()
	{
		return $this->db->count_all('cliparts');
	}
	
	public function getCountProducts()
	{
		return $this->db->count_all('products');
	}
	
	public function getCountOrders()
	{
		$this->db->join('users', 'users.id = orders.user_id');
		$query = $this->db->get('orders');
		return $query->num_rows();
	}
	
	// get user permission
	public function userPermission($control, $user_id = 0, $redirect = true)
	{
		if ($user_id == 0)
		{
			$user		= $this->session->userdata('user');
			$user_id	= $user['id'];
		}
		
		if ((int)$user_id == 0)
		{
			return false;
		}
		
		$this->db->from('users');
		$this->db->join('user_groups', 'user_groups.id=users.group');
		$this->db->where('users.id', $user_id);
		$this->db->like('permissions', '"'.$control.'"');
		
		$count 	= $this->db->count_all_results();
		
		if ($count == 0)
		{
			if ($redirect === true)
			{
				$this->session->set_flashdata('error', lang('error_view').$control);
				redirect('admin/dashboard');
			}
			else
			{
				return false;
			}
		}
		
		return true;
	}
}