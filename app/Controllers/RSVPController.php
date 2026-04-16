<?php

namespace App\Controllers;

use App\Models\RSVPFormModel;

class RSVPController extends BaseAdminController
{
    protected $rsvpFormModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $panelSettings = getPanelSettings();
        $this->rsvpFormModel = new RSVPFormModel();
    }
	
    /*
     * --------------------------------------------------------------------
     * RSVP Fields
     * --------------------------------------------------------------------
     */


    /**
     * Add RSVP Field
     */
    public function customRSVPFields()
    {
        $data['title'] = trans("rsvpEventForm");
        
        echo view('admin/includes/_header', $data);
        echo view('admin/rsvp-form/rsvp_form_fields', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Custom Field Post
     */
    public function addRSVPCustomFieldPost()
    {
		$store_form = $this->rsvpFormModel->storeFormData();
	
		$data_array = $_POST;
		
		if(!empty($data_array) && (!empty($store_form) && $store_form != 0))
		{
			$dataToInsert = [];
			$selectFieldKeys = [];

			// Iterate through the POST array and split data into different arrays
			foreach ($data_array as $key => $value) {
				$parts = explode('_', $key);
				$index = end($parts);

				if ($index && is_numeric($index)) {
					$dataIndex = intval($index);

					if (!isset($dataToInsert[$dataIndex])) {
						$dataToInsert[$dataIndex] = [];
					}

					$fieldName = $parts[0];

					if ($fieldName === 'select' && $value === '1') {
						// Store the key of select field to check for existence
						$selectFieldKeys[$dataIndex] = true;
					} else {
						$dataToInsert[$dataIndex][$fieldName] = $value;
					}
				}
			}

			// Add isRequired with value 0 to arrays that don't have it or have value other than 1
			foreach ($dataToInsert as &$data) {
				if (!isset($data['isRequired']) || $data['isRequired'] !== '1') {
					$data['isRequired'] = '0';
				}
				if (!isset($data['isEmail']) || $data['isEmail'] !== '1') {
					$data['isEmail'] = '0';
				}
				if (!isset($data['formNameAttribute']) || $data['formNameAttribute'] == '') {
					$data['formNameAttribute'] = '';
				}
			}

			// Filter out arrays without the select field
			$dataToInsert = array_filter($dataToInsert, function ($data, $index) use ($selectFieldKeys) {
				return isset($selectFieldKeys[$index]);
			}, ARRAY_FILTER_USE_BOTH);

			// Add form_id to each array
			foreach ($dataToInsert as &$data) {
				$data['form_id'] = $store_form;
			}

			// Reset array keys after filtering
			$dataToInsert = array_values($dataToInsert);
		}
		
		if(!empty($dataToInsert))
		{
			if($this->rsvpFormModel->addRSVPFieldsForm($dataToInsert)){
				setSuccessMessage(trans("msg_updated"));
			} else {
				setErrorMessage(trans("msg_error"));
			}
		}
		else
		{
			setErrorMessage(trans("msg_error"));
		}
        redirectToBackUrl();
    }
	
	public function reportRSVPFields()
    {
        $data['title'] = trans("rsvpEventFormreport");
		$data['formList'] = $this->rsvpFormModel->rsvpFormList();	
			
        echo view('admin/includes/_header', $data);
        echo view('admin/rsvp-form/rsvp_report', $data);
        echo view('admin/includes/_footer');
    }
	
	public function deletedRSVPForm()
    {
        $data['title'] = trans("rsvpEventFormreport");
		$data['formList'] = $this->rsvpFormModel->rsvpFormListDeleted();	
			
        echo view('admin/includes/_header', $data);
        echo view('admin/rsvp-form/rsvp_report', $data);
        echo view('admin/includes/_footer');
    }
	
	public function transactionsRSVPForms()
    {
        $data['title'] = trans("transactions");
		$data['formPayments'] = $this->rsvpFormModel->getRsvpFormPayments();	

        echo view('admin/includes/_header', $data);
        echo view('admin/rsvp-form/rsvp_transaction', $data);
        echo view('admin/includes/_footer');
    }
	
	public function editRSVPForm($id)
	{
		$data['title'] = trans("rsvpEventForm");
		$datas = $this->rsvpFormModel->rsvpEdirFormListData($id);
		$data['formHeader']= $datas['form_header'];
		$data['formFields']= $datas['form_fields'];
			
        echo view('admin/includes/_header', $data);
        echo view('admin/rsvp-form/rsvp_edit_form', $data);
        echo view('admin/includes/_footer');
	}

	public function reportShowRSVPForm($id)
	{
		$data['title'] = trans("rsvpEventForm");
		$datas = $this->rsvpFormModel->rsvpFormListData($id);	
		$data['formHeader']= $datas['form_header'];
		$data['formFields']= $datas['form_fields'];
		$data['formData']= $datas['form_data'];
		
        echo view('admin/includes/_header', $data);
        echo view('admin/rsvp-form/rsvp_report_form_data', $data);
        echo view('admin/includes/_footer');
	}
	
	public function editFormHeaderPost()
	{
		$form_id = inputPost('form_id');
		if($this->rsvpFormModel->editRSVPForms($form_id))
		{
			setSuccessMessage(trans("msg_updated"));
		}
		else 
		{
			setErrorMessage(trans("msg_error"));
		}

        redirectToBackUrl();
	}

	public function editFormFieldsPost()
	{
		if($this->rsvpFormModel->editRSVPFormfields())
		{
			setSuccessMessage(trans("msg_updated"));
		}
		else 
		{
			setErrorMessage(trans("msg_error"));
		}

        redirectToBackUrl();
	}
	
	public function deleteRSVPForm()
    {
        $id = inputPost('id');
      
		if ($this->rsvpFormModel->deleteRSVPForm($id)) 
		{
			setSuccessMessage(trans("msg_deleted"));
		} 
		else 
		{
			setErrorMessage(trans("msg_error"));
		}
    }
	
	public function deleteUndoRSVPForm()
    {
        $id = inputPost('id');
      
		if ($this->rsvpFormModel->deleteUndoRSVPForm($id)) 
		{
			setSuccessMessage('Form Successfully Reverted');
		} 
		else 
		{
			setErrorMessage(trans("msg_error"));
		}
    }

}