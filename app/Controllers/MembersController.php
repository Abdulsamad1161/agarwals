<?php

namespace App\Controllers;

use App\Models\MembershipModel;


class MembersController extends BaseController
{
     protected $mebershipModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
		$this->mebershipModel = new MembershipModel();
    }
	
	/**
     * Ticket Booking
     */
    public function index()
    {
        if (!authCheck()) 
		{
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("users");
        $data['description'] = trans("users") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("users") . ',' . $this->baseVars->appName;
		$data['users'] = $this->mebershipModel->getAllUsersMembers();
        $data['userSession'] = getUserSession();
		$data['user'] = $this->authModel->getUser(1);
        echo view('partials/_header', $data);
        echo view('members/_index.php', $data);
        echo view('partials/_footer');
    }
	
	public function sendMessageToMember($id)
	{
		if (!authCheck()) 
		{
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("users");
        $data['description'] = trans("users") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("users") . ',' . $this->baseVars->appName;
		$data['users'] = $this->mebershipModel->getAllUsersMembers();
        $data['userSession'] = getUserSession();
		$data['user'] = $this->authModel->getUser($id);
        echo view('partials/_header', $data);
        echo view('members/_index_send_msg.php', $data);
        echo view('partials/_footer');
	}
	
	public function boardOfMembersList()
	{
        $data['title'] = trans("board-of-directors");
        $data['description'] = trans("board-of-directors") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("board-of-directors") . ',' . $this->baseVars->appName;
		$data['users'] = $this->mebershipModel->getAllBoardOfMembers();
		$data['usersSub'] = $this->mebershipModel->getAllBoardOfMembersSub();
        $data['userSession'] = getUserSession();
		
        echo view('partials/_header', $data);
        echo view('members/board_members.php', $data);
        echo view('partials/_footer');
	}
	public function boardOfMembersListPast()
	{
        $data['title'] = trans("board-of-directors");
        $data['description'] = trans("board-of-directors") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("board-of-directors") . ',' . $this->baseVars->appName;
		$data['users'] = $this->mebershipModel->getAllBoardOfMembers();
		$data['usersSub'] = $this->mebershipModel->getAllBoardOfMembersSub();
        $data['userSession'] = getUserSession();
		
        echo view('partials/_header', $data);
        echo view('members/board_members_past.php', $data);
        echo view('partials/_footer');
	}
	
}
?>