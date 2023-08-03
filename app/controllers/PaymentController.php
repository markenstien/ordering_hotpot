<?php 

    class PaymentController extends Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->model = model('PaymentModel');
            $this->modelOrder = model('OrderModel');
        }


        public function create() {
            if(isSubmitted()) {
                $post = request()->posts();

                $post['account_name'] = $post['payer_name'];
                $post['remarks'] = 'pending';

                $res = $this->model->createOrUpdate($post);

                if($res) {
                    Flash::set("Payment Created!");

                    if(!upload_empty('file')){
                        $upload = $this->_attachmentModel->upload([
                            'display_name' => 'Payment Image proof',
                            'global_key' => 'ORDER_PAYMENT_IMAGE',
                            'global_id'  => $post['order_id']
                        ], 'file');
                    }

                    return redirect(_route('order:show', $post['order_id']));
                } else {
                    Flash::set("Something went wrong!", 'danger');
                    return request()->return();
                }
            }
        }

        public function index() {
            $this->data['payments'] = $this->model->all(['is_removed' => false, 'id desc']);
            return $this->view('payment/index', $this->data);
        }

        public function show($id) {
            $this->data['payment'] = $this->model->get($id);
            return $this->view('payment/show', $this->data);
        }
    }