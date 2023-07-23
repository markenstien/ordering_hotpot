<?php

    use Form\SupplyOrderForm;
    load(['SupplyOrderForm'], APPROOT.DS.'form');
    
    class SupplyOrderController extends Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->model = model('SupplyOrderModel');
            $this->supplier = model('SupplierModel');

            $this->data['form'] = new SupplyOrderForm();
        }

        public function index() {
            $this->data['supplyOrders'] = $this->model->all(null, 'id desc');
            return $this->view('supply_order/index', $this->data);
        }

        public function create() {
            $req = request()->inputs();
            if (isSubmitted()) {
                $res = $this->model->createOrUpdate($req);
                if($res) {
                    Flash::set("Supply Order created");
                    return redirect(_route('supply-order-item:add-item', $res));
                }
            }

            $this->data['form']->init([
                'method' => 'post',
                'url'    => _route('supply-order:create')
            ]);

            $this->data['suppliers'] = $this->supplier->all([
                'status' => true
            ], 'name desc');

            return $this->view('supply_order/create', $this->data);
        }

        public function show($id) {
            $this->data['supplyOrder'] = $this->model->getAll($id);
            return $this->view('supply_order/show', $this->data);
        }

        public function approveAndUpdateStock($id) {
            $res = $this->model->approveAndUpdateStock($id);

            if($res) {
                Flash::set($this->model->getMessageString());
            } else {
                Flash::set($this->model->getErrorString(), 'danger');
            }
            return redirect(_route('supply-order:show', $id));
        }
    }