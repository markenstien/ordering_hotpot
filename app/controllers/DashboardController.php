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
			$this->data['page_title'] = 'Dashboard';
			$this->data['totalItem'] = $this->itemModel->totalItem();
			$this->data['totalUser'] = $this->user_model->totalUser();
			
			$orderService = new OrderService();
			$items = $orderService->getOrdersWithin30days(date('Y-m-d'));

			$this->data['orderAmountTotal'] = $this->orderItemModel->getItemSummary($items)['netAmount'];
			$this->data['items'] = $items;
			return $this->view('dashboard/index', $this->data);
		}
	}