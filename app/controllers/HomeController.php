<?php 

	class HomeController extends Controller
	{
		private $modelItem;
		public function __construct()
		{
			parent::__construct();
			$this->modelItem = model('ItemModel');
			$this->modelOrder = model('OrderModel');
		}
		public function index(){
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
			return $this->view('home/index');
		}

		public function about() {
			return $this->view('home/about');
		}

		public function contact() {
			return $this->view('home/contact');
		}

		public function shop() {
			$req = request()->inputs();
			$keyword = $req['q'] ?? '';

			$this->data['items'] = $this->modelItem->getAll([
				'where' => [
					'item.name' => [
						'condition' => 'like',
						'value' => "%{$keyword}%",
						'concatinator' => 'OR'
					],
					'brand.name' => [
						'condition' => 'like',
						'value' => "%{$keyword}%"
					]
				]
			]);
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
			$this->data['relatedProducts'] = $this->modelItem->getAll();
			
			return $this->view('home/catalog_view', $this->data);
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