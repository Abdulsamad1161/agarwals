<?php namespace App\Models;

use CodeIgniter\Model;

class RSVPFormModel extends BaseModel
{
    protected $builder;
    protected $builderFormFields;
    protected $builderFormSubmit;

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('rsvp_form_data');
        $this->builderFormFields = $this->db->table('rsvp_field_list_data');
        $this->builderFormSubmit = $this->db->table('rsvp_submit_form_data');
        $this->builderFormPayments = $this->db->table('rsvp_payments');
    }
	
	public function storeFormData()
	{
		$data = array(
			'member_id' => user()->id,
			'form_name' => inputPost('form_name'),
			'form_sub_name' => inputPost('form_sub_name'),
			'form_note' => inputPost('form_note'),
			'form_note_other' => inputPost('form_note_other'),
		);
		$db = \Config\Database::connect();
		
		$this->builder->insert($data);
		$form_id = $db->insertID();
		
		return $form_id;
	}

	public function addRSVPFieldsForm($dataInsert)
	{
		//echo "<pre>";print_r($dataInsert);die;
		if(!empty($dataInsert))
		{
			return $this->builderFormFields->insertBatch($dataInsert);
		}
	}
	
	public function getAllForms()
	{	
		$query = $this->builder->where('status',1)->get()->getResult();
		$allData = []; 

		if (count($query) > 0) {
			foreach ($query as &$item) {
				$formFields = $this->builderFormFields->orderBy('fieldOrder ASC')->where('form_id', $item->form_id)->get()->getResult();
				$item->forms = $formFields;

				foreach ($item->forms as &$form) {
					if ($form->fieldType === 'select' && isset($form->formSelectAttribute) && !empty($form->formSelectAttribute)) {
						$form->formSelectAttribute = explode("&&", $form->formSelectAttribute);
						$form->formSelectAttribute = array_map('trim', $form->formSelectAttribute);
					}
				}

				$allData[] = $item;
			}
		}

		return $allData;
	}
	
	public function getFormValues()
	{
		$postData =  array(
			'member_id' => user()->id,
			'form_id' => inputPost('form_id'),
			'text1' => inputPost('text1') != '' ? inputPost('text1') : '',
			'text2' => inputPost('text2') != '' ? inputPost('text2') : '',
			'text3' => inputPost('text3') != '' ? inputPost('text3') : '',
			'text4' => inputPost('text4') != '' ? inputPost('text4') : '',
			'text5' => inputPost('text5') != '' ? inputPost('text5') : '',
			'text6' => inputPost('text6') != '' ? inputPost('text6') : '',
			'text7' => inputPost('text7') != '' ? inputPost('text7') : '',
			'text8' => inputPost('text8') != '' ? inputPost('text8') : '',
			'text9' => inputPost('text9') != '' ? inputPost('text9') : '',
			'text10' => inputPost('text10') != '' ? inputPost('text10') : '',
			'text11' => inputPost('text11') != '' ? inputPost('text11') : '',
			'text12' => inputPost('text12') != '' ? inputPost('text12') : '',
			'text13' => inputPost('text13') != '' ? inputPost('text13') : '',
			'text14' => inputPost('text14') != '' ? inputPost('text14') : '',
			'text15' => inputPost('text15') != '' ? inputPost('text15') : '',
			'text16' => inputPost('text16') != '' ? inputPost('text16') : '',
			'text17' => inputPost('text17') != '' ? inputPost('text17') : '',
			'text18' => inputPost('text18') != '' ? inputPost('text18') : '',
			'text19' => inputPost('text19') != '' ? inputPost('text19') : '',
			'text20' => inputPost('text20') != '' ? inputPost('text20') : '',
			'total_amount' => inputPost('total_amount') != '' ? inputPost('total_amount') : '',
			'quantitytext18' => inputPost('quantitytext18') != '' ? inputPost('quantitytext18') : '',
			'quantitytext19' => inputPost('quantitytext19') != '' ? inputPost('quantitytext19') : '',
			'quantitytext20' => inputPost('quantitytext20') != '' ? inputPost('quantitytext20') : '',
			'payment_method' => inputPost('payment_method') != '' ? inputPost('payment_method') : '',
		);
		
		return $postData;
	}
	
	public function addRSVPformData()
	{
		$data = $this->getFormValues();
		if(!empty($data))
		{
			$db = \Config\Database::connect();
			$this->builderFormSubmit->insert($data);
			$id = $db->insertID();
			
			return $id;
		}	
	}
	
	public function rsvpFormList()
	{
		return $this->builder->get()->getResult();
	}

	public function rsvpFormListData($id)
	{
		$data['form_header'] = $this->builder->where('form_id',$id)->get()->getRow();
		$data['form_fields'] = $this->builderFormFields->where('form_id',$id)->get()->getResult();
		$data['form_data'] = $this->builderFormSubmit->where('form_id',$id)->get()->getResult();
		
		return $data;
	}

	public function rsvpEdirFormListData($id)
	{
		$data['form_header'] = $this->builder->where('form_id',$id)->get()->getRow();
		$data['form_fields'] = $this->builderFormFields->where('form_id',$id)->get()->getResult();
		
		return $data;
	}

	public function editRSVPForms($formID)
	{
		$data = array (
			'form_name' => inputPost('form_name'),
			'form_sub_name' => inputPost('form_sub_name'),
			'form_note' => inputPost('form_note'),
			'form_note_other' => inputPost('form_note_other'),
			'status' => inputPost('status'),
			'is_paypal' => inputPost('is_paypal'),
			'is_epayment' => inputPost('is_epayment'),
		);
		
		return $this->builder->where('form_id',$formID)->update($data);
	}

	public function editRSVPFormfields()
	{
		$formID = inputPost('form_id');
		$id = inputPost('id');
		
		foreach ($_POST as $key => $value) 
		{
			if (strpos($key, 'required') !== false) {
				$required_values = $value; 
			}
		}
		
		$data = array (
			'fieldType' => inputPost('fieldType'),
			'formLabel' => inputPost('formLabel'),
			'fieldOrder' => inputPost('fieldOrder'),
			'formSelectAttribute' => inputPost('formSelectAttribute'),
			'fieldAmount' => inputPost('fieldAmount'),
			'isRequired ' => $required_values,
		);
		
		return $this->builderFormFields->where('form_id',$formID)->where('id',$id)->update($data);
	}		
	
	public function getFormData($id)
	{
		return $this->builder->where('form_id',$id)->get()->getRow();
	}
	
	public function getRsvpFormPayments()
	{
		$data = $this->builderFormPayments->select('form_title, rsvp_amount, payment_status, payment_amount, transaction_id, payment_date, username, email, phone_number')
			->join('users', 'users.id = rsvp_payments.member_id')
			->orderBy('rsvp_payments.id', 'DESC')
			->get()
			->getResult();

		return $data;
	}
	
	public function getRsvpFormPaymentsID($id)
	{
		$data = $this->builderFormPayments->select('form_title, rsvp_amount, payment_method, payment_status, payment_amount, transaction_id, payment_date, username, email, phone_number')
			->join('users', 'users.id = rsvp_payments.member_id')
			->where('rsvp_payments.id', $id)
			->get()
			->getRow();

		return $data;
	}
	
	public function updateEpyamentmethodData($id,$method)
	{
		$data = array('payment_method' => $method);
		return $this->builderFormSubmit->where('id',$id)->update($data);
	}
}
?>