<?php

namespace App\Controllers;

use App\Models\BlogModel;
use App\Models\CurrencyModel;
use App\Models\FieldModel;
use App\Models\FileModel;
use App\Models\LocationModel;
use App\Models\MembershipModel;
use App\Models\MessageModel;
use App\Models\NewsletterModel;
use App\Models\OrderModel;
use App\Models\PromoteModel;
use App\Models\ShippingModel;
use App\Models\SitemapModel;
use App\Models\UploadModel;
use App\Models\VariationModel;
use App\Models\GalleryModel;
use App\Models\SettingsModel;

class GalleryController extends BaseController
{
	protected $blogModel;
    protected $commentLimit;
    protected $blogPerPage;
    protected $galleryModel;
    public $settingsModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->blogModel = new BlogModel();
        $this->galleryModel = new GalleryModel();
        $this->settingsModel = new SettingsModel();
        $this->commentLimit = 6;
        $this->blogPerPage = 12;
    }


    public function index()
    {
		 $data = [
            'title' => trans("gallery"),
            'description' => $this->settings->site_description,
            'keywords' => $this->settings->keywords
        ];
		
        $data['galleryImages'] = $this->galleryModel->getGalleryImages();
        $data['galleryVideos'] = $this->galleryModel->getGalleryVideos();
        $data['userSession'] = getUserSession();
        $numRows = $this->galleryModel->getFilteredImagesCount();
        $pager = paginate(9, $numRows);
        $data['imagesCategory'] = $this->galleryModel->getFilteredImagesPaginated(9, $pager->offset);

        echo view('partials/_header', $data);
        echo view('gallery/gallery_index');
        echo view('partials/_footer', $data);
	}
	
	public function upcomingEventsCalendar()
    {
		 $data = [
            'title' => trans("upcomingEventsCalendar"),
            'description' => $this->settings->site_description,
            'keywords' => $this->settings->keywords
        ];
       
		$data['events'] = $this->settingsModel->getAllEventsList();
		
		//echo "<pre>";print_r($data['eventList']);die;
        echo view('partials/_header', $data);
        echo view('UpcomingEvents/_index');
        echo view('partials/_footer', $data);
	}
	
	public function showEventDetails($id = null)
    {
		$id= 1;
		 $data = [
            'title' => trans("upcomingEventsCalendar"),
            'description' => $this->settings->site_description,
            'keywords' => $this->settings->keywords
        ];
       
		$data['events'] = $this->settingsModel->getAllEventsListData($id);
		
        echo view('partials/_header', $data);
        echo view('UpcomingEvents/_index_details');
        echo view('partials/_footer', $data);
	}
	
	public function showVideo($id)
	{
		$data['video'] = $this->galleryModel->getVideoGalleryData($id); 
		echo view('gallery/showVideo',$data);
	}
	
	public function showImage($id)
	{
		 $data = [
            'title' => trans("upcomingEventsCalendar"),
            'description' => $this->settings->site_description,
            'keywords' => $this->settings->keywords
        ];
       
		$data['categoty'] = $this->galleryModel->getAllCategoryData($id);
		$numRows = $this->galleryModel->getFilteredCategoryImagesCount($id);
        $pager = paginate(30, $numRows);
        $data['images'] = $this->galleryModel->getAllCategoryImagesData($id, 30, $pager->offset);
		
        echo view('partials/_header', $data);
        echo view('gallery/showGalleyImages',$data);
        echo view('partials/_footer', $data);
	}
}
?>