<?php

	use Classes\Report\SalesReport;
	use Services\OrderService;
	load(['OrderService'],SERVICES);
	load(['SalesReport'], CLASSES.DS.'Report');
	class DashboardController extends Controller
	{
		public function __construct()
		{
			parent::__construct();
			_authRequired();
			$this->user_model = model('UserModel');
			$this->itemModel = model('ItemModel');
			$this->orderItemModel = model('OrderItemModel');
			$this->orderModel = model('OrderModel');
			$this->salesReport = new SalesReport();
		}

		public function index()
		{
			if(isEqual(whoIs('user_type'), 'customer')) {
				return redirect(_route('order:index'));
			}
			$dateToday = date('Y-m-d');
			
			$completedOrders = $this->orderModel->all([
				'order_status' => 'completed',
				'date(created_at)' => $dateToday
			]);

			$orderIds = [];
			$top10salesChart = [];


			foreach($completedOrders as $key => $row) {
				$orderIds[] = $row->id;
			}

			$top10sales = $this->orderItemModel->getLowestOrHighest([
				'where' => [
					'order_id' => [
						'condition' => 'in',
						'value' => $orderIds
					]
				],
				'limit' => 5
			], $this->orderItemModel::CATEGORY_QUANTITY,'desc');

			
			foreach($top10sales as $key => $row) {
				$top10salesChart[$row->item_name] = $row->total_quantity;
			}

			$data = [
				'page_title' => 'Dashboard',
				'totalItem' => $this->itemModel->totalItem(),
				'totalUser' => $this->user_model->totalUser(),
				'items' => [],
				'salesPerMonth' => $this->salesReport->computeSalesPerMonth($completedOrders),
				'top10sales' => $top10sales,
				'top10salesChart' => $top10salesChart,
			];

			$data = array_merge($data, $this->data);

			return $this->view('dashboard/index', $data);
		}
	}