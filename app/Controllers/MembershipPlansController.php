<?php

namespace App\Controllers;

use App\Models\LocationModel;
use App\Models\MembershipModel;
use App\Models\ProfileModel;

class MembershipPlansController extends BaseAdminController
{
    protected $membershipModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        checkPermission('membership');
        $this->membershipModel = new MembershipModel();
    }

    /**
     * membershipPlansUser
     */
    public function membershipPlansUser()
    {
        $data['title'] = trans("membership_plans");
        $data['membershipPlans'] = $this->membershipModel->getPlansUsers();
        $data['panelSettings'] = getPanelSettings();
        echo view('admin/includes/_header', $data);
        echo view('admin/membership/membership_plans_users');
        echo view('admin/includes/_footer');
	}
	
	    /**
     * Add Plan Post
     */
    public function addPlanPostUser()
    {
        if ($this->membershipModel->addPlanUsers()) {
            setSuccessMessage(trans("msg_added"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        redirectToBackUrl();
    }
	
	 /**
     * Edit Plan
     */
    public function editPlanUsers($id)
    {
        $data['title'] = trans("edit_plan");
        $data['plan'] = $this->membershipModel->getPlanUsers($id);
        if (empty($data['plan'])) {
            return redirect()->to(adminUrl('membership-plans'));
        }
        echo view('admin/includes/_header', $data);
        echo view('admin/membership/edit_plan_users');
        echo view('admin/includes/_footer');
    }

    /**
     * Edit Plan Post
     */
    public function editPlanPostUsers()
    {
        $id = inputPost('id', true);
        if ($this->membershipModel->editPlanUsers($id)) {
            setSuccessMessage(trans("msg_updated"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        redirectToBackUrl();
    }
	
	/**
     * Delete Plan Post
     */
    public function deletePlanPostUsers()
    {
        $id = inputPost('id');
        $this->membershipModel->deletePlanUsers($id);
    }
}
?>