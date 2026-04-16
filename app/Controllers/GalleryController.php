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
        $data['galleryImages_data'] = $this->galleryModel->getFilteredImagesPaginated(9, $pager->offset);

        echo view('partials/_header', $data);
        echo view('gallery/gallery_index');
        echo view('partials/_footer', $data);
    }

    public function videogalleryindex()
    {
        $data = [
            'title' => 'Video Gallery',
            'description' => $this->settings->site_description,
            'keywords' => $this->settings->keywords
        ];

        $data['userSession'] = getUserSession();
        $numRows = $this->galleryModel->getFilteredVideoCount();
        $pager = paginate(9, $numRows);
        $data['galleryVideos_data'] = $this->galleryModel->getFilteredVideosPaginated(9, $pager->offset);

        echo view('partials/_header', $data);
        echo view('gallery/gallery_index_video');
        echo view('partials/_footer', $data);
    }

    public function upcomingEventsCalendar()
    {
        $data = [
            'title' => trans("upcomingEventsCalendar"),
            'description' => $this->settings->site_description,
            'keywords' => $this->settings->keywords
        ];

        $data['events'] = $this->settingsModel->getAllEventsListWithRegisterForm();
        // echo "<pre>";print_r($data['events']);die;
        echo view('partials/_header', $data);
        echo view('UpcomingEvents/_index');
        echo view('partials/_footer', $data);
    }

    public function showEventDetails($id = null)
    {
        $data = [
            'title' => trans("upcomingEventsCalendar"),
            'description' => $this->settings->site_description,
            'keywords' => $this->settings->keywords
        ];

        $data['events'] = $this->settingsModel->getAllEventsListDataWithRegistrationForm($id);
        echo view('partials/_header', $data);
        echo view('UpcomingEvents/_index_details');
        echo view('partials/_footer', $data);
    }

    public function showRegistrationForm($id = null)
    {
        $data = [
            'title' => 'Registration Form',
            'description' => $this->settings->site_description,
            'keywords' => $this->settings->keywords
        ];

        $data['form_data'] = $this->settingsModel->getRegsitarionEventForm($id);

        echo view('partials/_header', $data);
        echo view('members/rsvp_form_jot');
        echo view('partials/_footer', $data);
    }

    public function showVideo($id)
    {
        $data['video'] = $this->galleryModel->getVideoGalleryData($id);
        echo view('gallery/showVideo', $data);
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
        echo view('gallery/showGalleyImages', $data);
        echo view('partials/_footer', $data);
    }

    public function document()
    {
        $data = [
            'title' => 'Documents',
            'description' => $this->settings->site_description,
            'keywords' => $this->settings->keywords
        ];

        $data['documentList'] = $this->settingsModel->documentListData();

        echo view('partials/_header', $data);
        echo view('documents/document_index', $data);
        echo view('partials/_footer', $data);
    }
}
?>