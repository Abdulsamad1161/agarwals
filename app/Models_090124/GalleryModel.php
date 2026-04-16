<?php namespace App\Models;

use CodeIgniter\Model;

class GalleryModel extends BaseModel
{
    protected $builder;
    protected $builderVideo;
    protected $builderGalleryImagesCategory;
	

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('gallery_images');
        $this->builderVideo = $this->db->table('gallery_video');
        $this->builderGalleryImagesCategory = $this->db->table('gallery_images_category');
    }
	
	public function getGalleryImages()
    {
        $categories = $this->builder->orderBy('id')->get()->getResult();
        return $categories;
    }
	
	public function getGalleryVideos()
    {
        $categories = $this->builderVideo->orderBy('id')->get()->getResult();
        return $categories;
    }
	
	public function getVideoGalleryData($id)
    {
        $categories = $this->builderVideo->where('id',$id)->get()->getRow();
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
		return $this->builderGalleryImagesCategory->where('visible',1)->where('categoryId',$id)->get()->getRow();
	}
	
	public function getFilteredCategoryImagesCount($id)
    {
        return $this->builder->where('categoryId',$id)->countAllResults();
    }
	
	public function getFilteredImagesCount()
    {
        return $this->builderGalleryImagesCategory->countAllResults();
    }

    public function getFilteredImagesPaginated($perPage, $offset)
    {
        $this->builderGalleryImagesCategory->where('visible',1)->orderBy('order','desc');
        return $this->builderGalleryImagesCategory->limit($perPage, $offset)->get()->getResult();
    }
	
}
?>