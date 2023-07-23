<?php 

	class HomeController extends Controller
	{
		private $modelItem;
		public function __construct()
		{
			parent::__construct();
			$this->modelItem = model('ItemModel');
		}
		public function index(){
			return $this->view('home/index');
		}

		public function about() {
			return $this->view('home/about');
		}

		public function contact() {
			return $this->view('home/contact');
		}

		public function shop() {
			$this->data['items'] = $this->modelItem->getAll();
			$this->data['page'] = [
				'metaTitle' => 'Shop Now!'
			]; 

			return $this->view('home/shop', $this->data);
		}

		public function cart() {

		}

		public function checkout() {

		}

		public function showCatalog($id) {
			$this->data['item'] = $this->modelItem->get($id);
			return $this->view('home/catalog_view', $this->data);
		}
	}