<?php
    use Form\PaymentForm;
    use Form\PaymentOnlineForm;
    load(['PaymentForm', 'PaymentOnlineForm'], APPROOT.DS.'form');

    class ReceiptController extends Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->order = model('OrderModel');
            $this->paymentForm = new PaymentForm();
            $this->paymentOnlineForm = new PaymentOnlineForm();
            $this->data['paymentOnlineForm'] = $this->paymentOnlineForm;
        }

        public function index() {

        }

        public function orderReceipt($id) {

            $order = $this->order->getComplete($id);
            $paymentImage = $this->_attachmentModel->single([
                'global_id' => $id,
                'global_key' => 'ORDER_PAYMENT_IMAGE'
            ]);

            if(!$order) {
                return false;
            }

            $this->paymentForm->setValue('amount', $order['order']->net_amount);

            $this->paymentForm->init([
                'method' => 'post',
                'url' => _route('payment:create')
            ]);

            $this->paymentForm->add([
                'type' => 'hidden',
                'name' => 'order_id',
                'value' => $id
            ]);

            $this->data['paymentForm'] = $this->paymentForm;

            $this->data['order'] = $order['order'];
            $this->data['payment'] = $order['payment'];
            $this->data['items'] = $order['items'];
            $this->data['_attachmentForm'] = $this->_attachmentForm;
            $this->data['paymentImage'] = $paymentImage;
            return $this->view('receipt.order_receipt', $this->data);
        }
    }