<?php
    use Omnipay\Omnipay;
    require_once LIBS.DS.'omnipay/vendor/autoload.php';
    class PaymentController extends Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->model = model('PaymentModel');
            $this->modelOrder = model('OrderModel');
        }


        public function paypalResponse() {
            $req = request()->inputs();

            $gateway = Omnipay::create('PayPal_Rest');
            $gateway->setClientId(PAYPAL_AUTH['PAYPALCLIENTID']);
            $gateway->setSecret(PAYPAL_AUTH['PAYPALCLIENTSECRET']);
            $gateway->setTestMode(true);    

            if((isset($req['paymentId'], $req['PayerID']))) {

                $paymentDataPaylaod = $req['PAYMENT_DATA_PAYLOAD'];
                $paymentDataPaylaod = unseal($paymentDataPaylaod);

                $amountPaid = $paymentDataPaylaod['amount_paid'];
                $orderId = $paymentDataPaylaod['order_id'];

                //order data
                
                
                $transaction = $gateway->completePurchase(array(
                    'payer_id' => $req['PayerID'],
                    'transactionReference' => $req['paymentId'],
                ));
        
                $response = $transaction->send();

                if($response->isSuccessful()) {
                    $responseData = $response->getData();
                    $externalReference = $responseData['id'];
                    $order = $this->modelOrder->get($orderId);

                    $paymentData = [
                        'order_id'  => $order->id,
                        'amount'  => $amountPaid,
                        'account_name' => $order->customer_name,
                        'payment_method'  => 'ONLINE',
                        'mobile_number'  => $order->mobile_number,
                        'address'  => $order->address,
                        'remarks'  => 'ORDER PAID VIA PAYPAL',
                        'organization'  => 'PAYPAL',
                        'account_number'  => $responseData['id'],
                        'external_reference'  => $responseData['cart'],
                        'created_by'  => today(),
                        'remarks' => 'approved'
                    ];

                    $paymentId = $this->model->createOrUpdate($paymentData);

                    if($paymentId) {
                        Flash::set("Payment Successfull");
                        $this->model->approve($paymentId);
                    } else {
                        Flash::set($this->model->getErrorString(), 'danger');
                        return request()->return();
                    }
                    return redirect(_route('receipt:order', $orderId));
                }
            }
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
            _authRequired();
            $this->data['payments'] = $this->model->all(['is_removed' => false, 'id desc']);
            return $this->view('payment/index', $this->data);
        }

        public function show($id) {
            _authRequired();
            $this->data['payment'] = $this->model->get($id);
            $this->data['paymentImage'] = $this->model->getImage($id);
            $this->data['order'] = $this->modelOrder->get($id);
            return $this->view('payment/show', $this->data);
        }


        public function approve($id) {
            _authRequired();
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
            _authRequired();
            $res = $this->model->invalidate($id);

            if(!$res) {
                Flash::set($this->model->getErrorString(), 'danger');
            }else{
                Flash::set($this->model->getMessageString());
            }

            return redirect(_route('receipt:order', $id));
        }
    }