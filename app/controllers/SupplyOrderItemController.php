<?php

    use Form\SupplyOrderItemForm;
    load(['SupplyOrderItemForm'], APPROOT.DS.'form');

    class SupplyOrderItemController extends Controller
    {

        public function __construct()
        {
            parent::__construct();

            $this->model = model('SupplyOrderItemModel');
            $this->supplyOrder = model('SupplyOrderModel');
            $this->itemModel = model('ItemModel');

            $this->supplyOrderItemForm = new SupplyOrderItemForm();
        }

        public function index() {

        }

        public function addItem($supplyOrderid) {
            $req = request()->inputs();
            
            if(isSubmitted()) {
                $res = $this->model->createOrUpdate($req);
                if($res) {
                    Flash::set("Item added");
                    return redirect(_route('supply-order:show', $req['supply_order_id']));
                }
            }

            $this->data['supplyOrder'] = $this->supplyOrder->get($supplyOrderid);

            $this->supplyOrderItemForm->init([
                'method' => 'post',
                'url' => _route('supply-order-item:add-item', $supplyOrderid)
            ]);
            $this->supplyOrderItemForm->setValue('supply_order_id', $supplyOrderid);
            $this->data['supplyOrderItemForm'] = $this->supplyOrderItemForm;
            return $this->view('supply_order_item/create', $this->data);
        }

        public function editItem($itemId) {
            
            $req = request()->inputs();

            if (isSubmitted()) {
                $res = $this->model->createOrUpdate($req, $itemId);
                if($res) {
                    Flash::set("Quantity Updated");
                    return redirect(_route('supply-order:show', $req['supply_order_id']));
                }
            }

            $supplyItem = $this->model->get($itemId);
            $this->supplyOrderItemForm->init([
                'method' => 'post',
                'url' => _route('supply-order-item:edit-item', $itemId)
            ]);
            $this->supplyOrderItemForm->setValueObject($supplyItem);
            $this->data['supplyOrderItemForm'] = $this->supplyOrderItemForm;

            return $this->view('supply_order_item/edit', $this->data);
        }
    }