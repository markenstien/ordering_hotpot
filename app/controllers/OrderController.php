<?php
    
    class OrderController extends Controller
    {
        public function __construct()
        {
            $this->model = model('OrderModel');
            _authRequired();
        }
        public function index() {
            if(isEqual(whoIs('user_type'),'customer')) {
                $this->data['orders'] = $this->model->all([
                    'customer_id' => whoIs('id')
                ], 'id desc');
            } else {
                $this->data['orders'] = $this->model->all(null, 'id desc');
            }
            return $this->view('order/index', $this->data);
        }

        public function show($id) {
            _authRequired(['admin']);

            $order = $this->model->getComplete($id);

            $this->data['order'] = $order['order'];
            $this->data['payment'] = $order['payment'];
            $this->data['items'] = $order['items'];

            return $this->view('order/show', $this->data);
        }

        public function voidOrder($id) {
            
            $res = $this->model->void($id);
            Flash::set("Order Void!");
            return redirect(_route('receipt:order', $id));
        }

        public function complete($id) {
            $res = $this->model->complete($id);
            Flash::set("Order Completed!");
            return redirect(_route('receipt:order', $id));
        }
    }