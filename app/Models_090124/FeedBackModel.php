<?php namespace App\Models;

use CodeIgniter\Model;

class FeedBackModel extends BaseModel
{
    protected $builder;

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('feedback_members');
    }
	
	public function inputValues()
	{
		return [
            'username' => removeSpecialCharacters(inputPost('username')),
            'email' => inputPost('email'),
            'phone_number' => inputPost('phone_number'),
            'member_id' => user()->id,
            'feedback_message' => inputPost('message'),
        ];
	}
	
	public function addfeedback()
	{
		echo "in";die;
		$data = $this->inputValues();
		
		if(isset($data) && is_array($data))
		{
			return $this->builder->insert($data);
		}
		else
		{
			return false;
		}
	}
	
}
?>