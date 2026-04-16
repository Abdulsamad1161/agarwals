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
use App\Models\PageModel;

class AboutUsController extends BaseController
{
	protected $blogModel;
    protected $commentLimit;
    protected $blogPerPage;
    protected $membershipModel;
    public $pageModel;
	
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->blogModel = new BlogModel();
        $this->commentLimit = 6;
        $this->blogPerPage = 12;
		$this->membershipModel = new MembershipModel();
		$this->pageModel = new PageModel();
    }


    public function index()
    {
		 $data = [
            'title' => trans("about-us"),
            'description' => $this->settings->site_description,
            'keywords' => $this->settings->keywords
        ];
        $data['sliderItems'] = $this->commonModel->getSliderItemsByLang(selectedLangId());
        $data['featuredCategories'] = $this->categoryModel->getFeaturedCategories();
        $data['indexBannersArray'] = $this->commonModel->getIndexBannersArray();
        $data['specialOffers'] = $this->productModel->getSpecialOffers();
        $data['indexCategories'] = $this->categoryModel->getIndexCategories();
        $data['promotedProducts'] = $this->productModel->getPromotedProductsLimited($this->generalSettings->index_promoted_products_count, 0);
        $data['promotedProductsCount'] = $this->productModel->getPromotedProductsCount();
        $data['categoriesProductsArray'] = $this->productModel->getIndexCategoriesProducts($data['indexCategories']);
        $data['userSession'] = getUserSession();
        $data['latestProducts'] = $this->productModel->getProducts($this->generalSettings->index_latest_products_count);
        $data["blogSliderPosts"] = $this->blogModel->getPosts(10);
        $data["page1"] = $this->pageModel->getPageAboutUs1();
        $data["page2"] = $this->pageModel->getPageAboutUs2();

        echo view('partials/_header', $data);
        echo view('aboutUs/_index');
        echo view('partials/_footer', $data);
	} 
	
}
?>