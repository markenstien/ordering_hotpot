<?php
	use Services\OrderService;
	load(['OrderService'],SERVICES);
	class DashboardController extends Controller
	{
		public function __construct()
		{
			$this->user_model = model('UserModel');
			$this->itemModel = model('ItemModel');
			$this->orderItemModel = model('OrderItemModel');
		}

		public function index()
		{
			if(isEqual(whoIs('user_type'), 'customer')) {
				return redirect(_route('order:index'));
			}
			$this->data['page_title'] = 'Dashboard';
			$this->data['totalItem'] = $this->itemModel->totalItem();
			$this->data['totalUser'] = $this->user_model->totalUser();

			$this->data['items'] = [];
			
			return $this->view('dashboard/index', $this->data);
		}
	}