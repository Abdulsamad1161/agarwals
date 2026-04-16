<?php namespace App\Models;

use CodeIgniter\Model;

class GalleryModel extends BaseModel
{
    protected $builder;
    protected $builderVideo;
    protected $builderGalleryImagesCategory;
    protected $builderVideoSub;
	

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('gallery_images');
        $this->builderVideo = $this->db->table('gallery_video');
        $this->builderVideoSub = $this->db->table('gallery_video_sub');
        $this->builderGalleryImagesCategory = $this->db->table('gallery_images_category');
    }
	
	public function getGalleryImages()
    {
        $categories = $this->builder->orderBy('id')->get()->getResult();
        return $categories;
    }
	
	public function getGalleryVideos()
    {
        $categories = $this->builderVideo->orderBy('order','desc')->get()->getResult();
        return $categories;
    }
	
	public function getVideoGalleryData($id)
    {
        $categories = $this->builderVideo->where('id',$id)->get()->getRow();
        return $categories;
    }
	
	public function getVideoGalleryDataSub($id)
    {
        $categories = $this->builderVideoSub->where('video_id',$id)->get()->getResultArray();
        return $categories;
    }
	
	public function getAllCategoryImages()
	{
		return $this->builderGalleryImagesCategory->where('visible',1)->orderBy('order','Desc')->get()->getResult();
	}
	
	public function getAllCategoryImagesData($id, $perPage, $offset)
	{
		$this->builder->where('categoryId',$id);
		 return $this->builder->limit($perPage, $offset)->get()->getResult();
	}
	
	public function getAllCategoryData($id)
	{
		return $this->builderGalleryImagesCategory->where('visible',1)->orderBy('order','Desc')->where('categoryId',$id)->get()->getRow();
	}
	
	public function getFilteredCategoryImagesCount($id)
    {
        return $this->builder->where('categoryId',$id)->countAllResults();
    }
	
	public function getFilteredImagesCount()
    {
        return $this->builderGalleryImagesCategory->countAllResults();
    }
	
	public function getFilteredVideoCount()
    {
        return $this->builderVideo->countAllResults();
    }

    public function getFilteredImagesPaginated($perPage, $offset)
    {
        $this->builderGalleryImagesCategory->orderBy('order','desc');
        return $this->builderGalleryImagesCategory->limit($perPage, $offset)->get()->getResult();
    }
	
	public function getFilteredVideosPaginated($perPage, $offset)
    {
        $this->builderVideo->orderBy('order','desc');
        return $this->builderVideo->limit($perPage, $offset)->get()->getResult();
    }
	
}
?>