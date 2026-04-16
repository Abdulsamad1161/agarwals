<?php namespace App\Models;

use CodeIgniter\Model;

class PageModel extends BaseModel
{
    protected $builder;
	protected $builderPagesContent;
    protected $builderOurSponsorsList;
    protected $builderBoardDirectors;
    protected $builderBoardDirectorsSub;
    protected $builderUsers;
    protected $builderExternalOrganization;

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('pages');
		$this->builderPagesContent = $this->db->table('page_content');
        $this->builderBoardDirectors = $this->db->table('board_of_directors');
        $this->builderBoardDirectorsSub = $this->db->table('old_board_of_directors');
        $this->builderUsers = $this->db->table('users');
        $this->builderOurSponsorsList = $this->db->table('sponsors_list');
        $this->builderExternalOrganization = $this->db->table('external_organization');
    }

    //input values
    public function inputValues()
    {
        $data = [
            'lang_id' => inputPost('lang_id'),
            'title' => inputPost('title'),
            'slug' => inputPost('slug'),
            'description' => inputPost('description'),
            'keywords' => inputPost('keywords'),
            'page_content' => inputPost('page_content'),
            'page_order' => inputPost('page_order'),
            'visibility' => inputPost('visibility'),
            'title_active' => inputPost('title_active'),
            'location' => inputPost('location')
        ];
        return $data;
    }
	
	public function inputValuesPageContent()
    {
        $data = [
            'title' => inputPost('title'),
            'location' => inputPost('location'),
            'page_content' => inputPost('pageContent')
        ];
        return $data;
    }

    //add external organization
    public function addExternalOrganization()
    {
        $data = array(
			'name' => inputPost('name'),
			'link' => inputPost('link'),
			'description' => inputPost('description')
		);
       
        if ($this->builderExternalOrganization->insert($data))
		{
			return true;
        }
        return false;
    }
	
	//add page
    public function addPage()
    {
        $data = $this->inputValues();
        if (empty($data['slug'])) {
            $data['slug'] = strSlug($data['title']);
        } else {
            $data['slug'] = removeSpecialCharacters($data['slug']);
            if (!empty($data['slug'])) {
                $data['slug'] = str_replace(' ', '-', $data['slug']);
            }
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($this->builder->insert($data)) {
            $lastId = $this->db->insertID();
            $this->updateSlug($lastId);
        }
        return true;
    }

    //edit page
    public function editPage($id)
    {
        $page = $this->getPageById($id);
        if (!empty($page)) {
            $data = $this->inputValues();
            return $this->builder->where('id', $page->id)->update($data);
        }
        return false;
    }
	
	public function editPageContent($id)
    {
        $page = $this->getPageContentById($id);
        if (!empty($page)) {
            $data = $this->inputValuesPageContent();
            return $this->builderPagesContent->where('id', $page->id)->update($data);
        }
        return false;
    }
	
	public function editExternalOrganization($id)
    {
        $page = $this->getExternalOrganizationById($id);
        if (!empty($page)) 
		{
            $data = array(
				'name'=>inputPost('name'),
				'link'=>inputPost('link'),
				'description'=>inputPost('description'),
			);
            return $this->builderExternalOrganization->where('id', $page->id)->update($data);
        }
        return false;
    }

    //update slug
    public function updateSlug($id)
    {
        $page = $this->getPageById($id);
        if (empty($page)) {
            if (empty($page->slug) || $page->slug == '-') {
                $data = ['slug' => $page->id];
                $this->builder->where('id', $page->id)->update($data);
            } else {
                if (!empty($this->checkPageSlug($page->slug, $id))) {
                    $data = ['slug' => $page->slug . '-' . $page->id];
                    $this->builder->where('id', $page->id)->update($data);
                }
            }
        }
    }

    //check page slug
    public function checkPageSlug($slug, $id)
    {
        return $this->builder->where('slug', removeSpecialCharacters($slug))->where('id !=', clrNum($id))->get()->getRow();
    }

    //check page slug for product
    public function checkPageSlugForProduct($slug)
    {
        return $this->builder->where('slug', removeSpecialCharacters($slug))->get()->getRow();
    }

    //get menu links
    public function getMenuLinks($langId)
    {
        return $this->builder->select('id, title, slug, page_order, location, page_default_name')->where('lang_id', clrNum($langId))->where('visibility', 1)->orderBy('page_order')->get()->getResult();
    }

    //get pages
    public function getPages()
    {
        return $this->builder->orderBy('page_order')->get()->getResult();
    }
	
	public function getPagesContent()
    {
        return $this->builderPagesContent->get()->getResult();
    }
	
	public function getExternalOrganizations()
    {
        return $this->builderExternalOrganization->get()->getResult();
    }

    //get page
    public function getPage($slug)
    {
        return $this->builder->where('slug', strSlug($slug))->where('visibility', 1)->where('pages.lang_id', selectedLangId())->get()->getRow();
    }

    //get page by id
    public function getPageById($id)
    {
        return $this->builder->where('id', clrNum($id))->get()->getRow();
    }
	
	public function getPageContentById($id)
    {
        return $this->builderPagesContent->where('id', clrNum($id))->get()->getRow();
    }
	
	public function getExternalOrganizationById($id)
    {
        return $this->builderExternalOrganization->where('id', clrNum($id))->get()->getRow();
    }

    //get page by default name
    public function getPageByDefaultName($defaultName, $langId)
    {
        return $this->builder->where('page_default_name', cleanStr($defaultName))->where('visibility', 1)->where('lang_id', clrNum($langId))->get()->getRow();
    }

    //get sitemap pages
    public function getSitemapPages()
    {
        return $this->builder->where('pages.visibility', 1)->get()->getResult();
    }

    //delete page
    public function deletePage($id)
    {
        $page = $this->getPageById($id);
        if (!empty($page)) {
            return $this->builder->where('id', clrNum($id))->delete();
        }
        return false;
    }
	
	public function deleteExternalOrganization($id)
    {
        $page = $this->getExternalOrganizationById($id);
        if (!empty($page)) {
            return $this->builderExternalOrganization->where('id', clrNum($id))->delete();
        }
        return false;
    }
	
	public function getAllMembersList()
	{
		return $this->builderUsers->where('banned',0)->get()->getResult();
	}
	
	public function getOrderOfDirectors()
	{
		$data = $this->getboardMembers();
		if(count($data) > 0)
		{
			return $this->builderBoardDirectors->where('delete',0)->orderBy('id','Desc')->limit(1)->get()->getRow()->id;
		}
		else
		{
			return 0;
		}
	}
	public function getOrderOfDirectorsSub()
	{
		$data = $this->getboardMembersSub();
		if(count($data) > 0)
		{
			return $this->builderBoardDirectorsSub->where('delete',0)->orderBy('id','Desc')->limit(1)->get()->getRow()->id;
		}
		else
		{
			return 0;
		}
	}
	
	public function addBoardDirectors()
	{
		$uploadModel = new UploadModel();
        $baordImage = $uploadModel->uploadProfileImageDirectors('userImage');
		$data = array (
			'name' => inputPost('name'),
			'description' => inputPost('description'),
			'order' => inputPost('order'),
		);
		
		 if (!empty($baordImage) && !empty($baordImage['path'])) 
		{
            $data['image'] = $baordImage['path'];
        }
		
		return $this->builderBoardDirectors->insert($data);
	}
	public function addBoardDirectorsSub()
	{
		$uploadModel = new UploadModel();
        $baordImage = $uploadModel->uploadProfileImageDirectors('userImage');
		$data = array (
			'name' => inputPost('name'),
			'description' => inputPost('description'),
			'order' => inputPost('order'),
		);
		
		 if (!empty($baordImage) && !empty($baordImage['path'])) 
		{
            $data['image'] = $baordImage['path'];
        }
		
		return $this->builderBoardDirectorsSub->insert($data);
	}
	
	public function editBoardDirectors()
	{
		$id = inputPost('id');
		$uploadModel = new UploadModel();
        $baordImage = $uploadModel->uploadProfileImageDirectors('userImage');
		$data = array (
			'name' => inputPost('name'),
			'description' => inputPost('description'),
			'order' => inputPost('order'),
		);
		
		if (!empty($baordImage) && !empty($baordImage['path'])) 
		{
            $data['image'] = $baordImage['path'];
        }
		
		return $this->builderBoardDirectors->where('id',$id)->update($data);
	}
	public function editBoardDirectorsSub()
	{
		$id = inputPost('id');
		$uploadModel = new UploadModel();
        $baordImage = $uploadModel->uploadProfileImageDirectors('userImage');
		$data = array (
			'name' => inputPost('name'),
			'description' => inputPost('description'),
			'order' => inputPost('order'),
		);
		
		if (!empty($baordImage) && !empty($baordImage['path'])) 
		{
            $data['image'] = $baordImage['path'];
        }
		
		return $this->builderBoardDirectorsSub->where('id',$id)->update($data);
	}
	
	public function getboardMembers()
	{
		return $this->builderBoardDirectors->where('delete',0)->get()->getResult();
	}
	public function getboardMembersSub()
	{
		return $this->builderBoardDirectorsSub->where('delete',0)->get()->getResult();
	}
	
	public function getboardMembersEdit($id)
	{
		return $this->builderBoardDirectors->where('id',$id)->get()->getRow();
	}
	public function getboardMembersEditSub($id)
	{
		return $this->builderBoardDirectorsSub->where('id',$id)->get()->getRow();
	}
	
	public function deleteBoardDirectorImage($id)
	{
		$data = array('image' => null);
		return $this->builderBoardDirectors->where('id',$id)->update($data);
	}
	public function deleteBoardDirectorImageSub($id)
	{
		$data = array('image' => null);
		return $this->builderBoardDirectorsSub->where('id',$id)->update($data);
	}
	
	public function deleteBoardDirector($id)
	{
		$data = array('delete' => 1);
		return $this->builderBoardDirectors->where('id',$id)->update($data);
	}
	public function deleteBoardDirectorSub($id)
	{
		$data = array('delete' => 1);
		return $this->builderBoardDirectorsSub->where('id',$id)->update($data);
	}
	
	public function getOurSponsorsList()
	{
		return $this->builderOurSponsorsList->where('delete',0)->get()->getResult();
	}
	
	public function getOrderOurSponsors()
	{
		$data = $this->getOurSponsorsList();
		if(count($data) > 0)
		{
			return $this->builderOurSponsorsList->where('delete',0)->orderBy('id','Desc')->limit(1)->get()->getRow()->id;
		}
		else
		{
			return 0;
		}
	}
	
	public function addOurSponsorsData()
	{
		$uploadModel = new UploadModel();
        $sponsorImage = $uploadModel->uploadOurSponsorsImage('sponsorImage');
		$data = array (
			'name' => inputPost('name'),
			'linkSponsor' => inputPost('linkSponsor'),
			'order' => inputPost('order'),
			'member_id' => user()->id,
		);
		
		 if (!empty($sponsorImage) && !empty($sponsorImage['path'])) 
		{
            $data['image'] = $sponsorImage['path'];
        }
		
		return $this->builderOurSponsorsList->insert($data);
	}
	
	public function getOurSponsorEdit($id)
	{
		return $this->builderOurSponsorsList->where('id',$id)->get()->getRow();
	}
	
	public function editOurSponsors()
	{
		$id = inputPost('id');
		$uploadModel = new UploadModel();
        $sponsorImage = $uploadModel->uploadOurSponsorsImage('sponsorImage');
		$data = array (
			'name' => inputPost('name'),
			'linkSponsor' => inputPost('linkSponsor'),
			'order' => inputPost('order'),
			'member_id' => user()->id,
		);
		
		if (!empty($sponsorImage) && !empty($sponsorImage['path'])) 
		{
            $data['image'] = $sponsorImage['path'];
        }
		
		return $this->builderOurSponsorsList->where('id',$id)->update($data);
	}
	
	public function deleteOurSponsorImage($id)
	{
		$data = array('image' => null);
		return $this->builderOurSponsorsList->where('id',$id)->update($data);
	}
	
	public function deleteOurSponsor($id)
	{
		$data = array('delete' => 1);
		return $this->builderOurSponsorsList->where('id',$id)->update($data);
	}
	
	public function getPageContentTermsCondition()
	{
		return $this->builderPagesContent->where('id',1)->get()->getRow();
	}
	
	public function getPageMemberBenefits()
	{
		return $this->builderPagesContent->where('id',2)->get()->getRow();
	}
	
	public function getPageAboutUs1()
	{
		return $this->builderPagesContent->where('id',3)->get()->getRow();
	}
	
	public function getPageAboutUs2()
	{
		return $this->builderPagesContent->where('id',4)->get()->getRow();
	}
}
