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

                    if(isEqual(whoIs('user_type'), ['admin', 'staff']) ) {
                        $this->model->approve($res);
                    }

                    if(!upload_empty('file')){
                        $upload = $this->_attachmentModel->upload([
                            'display_name' => 'Payment Image proof',
                            'global_key' => 'ORDER_PAYMENT_IMAGE',
                            'global_id'  => $post['order_id']
                        ], 'file');
                    }

                    return redirect(_route('receipt:order', $post['order_id']));
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
            $this->data['paymentImage'] = $this->model->getImage($id);
            $this->data['order'] = $this->modelOrder->get($id);
            return $this->view('payment/show', $this->data);
        }


        public function approve($id) {
            $req = request()->inputs();
            $res = $this->model->approve($id);

            if(!$res) {
                Flash::set($this->model->getErrorString(), 'danger');
            }else{
                Flash::set($this->model->getMessageString());
            }

            return redirect(_route('receipt:order', $this->model->_getRetval('order_id')));
        }

        public function invalidate($id) {
            $res = $this->model->invalidate($id);

            if(!$res) {
                Flash::set($this->model->getErrorString(), 'danger');
            }else{
                Flash::set($this->model->getMessageString());
            }

            return redirect(_route('receipt:order', $id));
        }
    }