<?php

	use Form\AppointmentForm;
	use Services\CategoryService;
	use Services\UserService;

	load(['AppointmentForm'], APPROOT.DS.'form');
	load(['UserService', 'CategoryService'], SERVICES);

	class HomeController extends Controller
	{
		private $modelItem, $modelOrder, $modelUser, $modelOrderItem;
		private $categoryModel, $modelReview;
		public function __construct()
		{
			parent::__construct();
			$this->modelItem = model('ItemModel');
			$this->modelOrder = model('OrderModel');
			$this->modelOrderItem = model('OrderItemModel');
			$this->modelUser = model('UserModel');
			$this->categoryModel = model('CategoryModel');
		}

		private function requireTerms() {
			if(!isEqual(Cookie::get('terms'), 'agreed')) {
				return redirect(_route('home:terms'));
			}
		}
		public function index(){
			$this->requireTerms();

			if(isSubmitted()) {
				$post = request()->posts();
				if(!empty($post['btn_contact'])) {
					//check if empty
					$emailContent = "
						<p>Thank you {$post['name']} for reaching out to us!</p>
						<p>Expect a response from us within 24hours thanks.</p>
						<ul> 
							<li> Subject: {$post['subject']} </li>
							<li> Message: {$post['message']} </li>
						</ul>
					";
					$emailBody = wEmailComplete($emailContent);
					_mail($post['email'], 'AN INQUIRY', $emailBody);

					Flash::set("Thanks for reaching out to us, your email is sent.");
				}
			}
			$products = $this->modelItem->getAll([
				'limit' => 4,
				'order' => ' RAND() '
			]);

			$staffs = $this->modelUser->getAll([
				'where' => [
					'user_type' => UserService::STAFF
				]
			]);

			foreach($products as $key => $product) {
				$product->image = $this->modelItem->getSingleImage($product->id);
			}

			$data = [
				'products' => $products,
				'staffs'   => $staffs
			];

			return $this->view('home/index', $data);
		}

		public function about() {
			$this->requireTerms();
			return $this->view('home/about');
		}

		public function contact() {
			$this->requireTerms();
			return $this->view('home/contact');
		}

		public function shop() {
			$this->requireTerms();
			$req = request()->inputs();
			$keyword = $req['q'] ?? '';
			$categoryId = !empty($req['category_id']) ? $req['category_id'] : NULL; 

			$condition = null;

			if(!empty($categoryId)) {
				$condition['category_id'] = $categoryId;
			}
			
			$this->data['items'] = $this->modelItem->getAll([
				'order' => 'item.name asc',
				'where' => $condition
			]);

			$this->data['categories'] = $this->categoryModel->all([
                'active' => 1,
                'category' => CategoryService::PRODUCT_CATEGORY
            ],'name asc');

            $categorySelectOptions = arr_layout_keypair($this->data['categories'],['id','name']);
			$this->data['categorySelectOptions'] = $categorySelectOptions;

			$this->data['page'] = [
				'metaTitle' => 'Shop Now!'
			]; 

			return $this->view('home/shop', $this->data);
		}

		public function reservation() {
			$this->requireTerms();
			$this->data['appointmentForm'] = new AppointmentForm();
			return $this->view('home/reservation', $this->data);
		}

		public function showCatalog($id) {
			$this->requireTerms();
			$this->data['item'] = $this->modelItem->get($id);
			if(empty($this->data['item'])) {
				Flash::set("Item not found", 'danger');
				return redirect(_route('home:shop'));
			}
			$items = $this->modelOrderItem->getCurrentSession('cart');
			$itemOnPreview = false;
			
			if($items) {
				foreach($items as $key => $row) {
					if($row->item_id == $id) {
						$itemOnPreview = $row;
						break;
					}
				}
			}

			$this->data['itemOnPreview'] = $itemOnPreview;
			$this->data['relatedProducts'] = $this->modelItem->getAll();
			return $this->view('home/catalog_view', $this->data);
		}

		public function terms() {
			return view('_documents/terms');
		}

		public function termsAgree() {
			Cookie::set('terms', 'agreed');
			return redirect(_route('home:index'));
		}

		public function trackOrder() {
			if(isSubmitted()) {
				$post = request()->posts();
				$order = $this->modelOrder->searchOrder($post['order_number']);

				if($order) {
					return redirect(_route('order:show', $order->id));
				} else {
					Flash::set("Ordern not found.", 'danger');
					return redirect(_route('home:track-order'));
				}
			}
			return $this->view('home/track_order', $this->data);
		}
	}