<?php
    use Form\PaymentForm;
    use Form\PaymentOnlineForm;
    use Omnipay\Omnipay;

    require_once LIBS.DS.'omnipay/vendor/autoload.php';

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
            $req = request()->inputs();

            if(isSubmitted()) {
                $post = request()->posts();
                $gateway = Omnipay::create('PayPal_Rest');
                $gateway->setClientId(PAYPAL_AUTH['PAYPALCLIENTID']);
                $gateway->setSecret(PAYPAL_AUTH['PAYPALCLIENTSECRET']);
                $gateway->setTestMode(true);

                $returnURL  = URL . _route('payment:paypal-response', $id, [
                    'PAYPAL_PAYMENT_ACTION' => 'SUCCESS',
                    'PAYMENT_DATA_PAYLOAD' => seal([
                        'order_id' => $id,
                        'amount_paid' => $post['amount']
                    ])
                ]);
                $cancelURL  = URL . _route('receipt:order', $id, [
                    'PAYPAL_PAYMENT_ACTION' => 'CANCELLED'
                ]);
                $_SESSION['amount'] = $post['amount'];

                $purchase = $gateway->purchase([
                    'amount' => $post['amount'],
                    'currency' => 'PHP',
                    'name'    => 'COW',
                    'returnURL' => $returnURL,
                    'cancelURL' => $cancelURL
                ])->send();
                    
                if ($purchase->isRedirect()) {
                    // redirect to offsite payment gateway
                    $purchase->redirect();
                } elseif ($purchase->isSuccessful()) {
                    // payment was successful: update database
                    print_r($purchase);
                } else {
                    // payment failed: display message to customer
                    echo $purchase->getMessage();
                }
        
            }
            
            $order = $this->order->getComplete($id);
            $paymentImage = $this->_attachmentModel->single([
                'global_id' => $id,
                'global_key' => 'ORDER_PAYMENT_IMAGE'
            ]);

            if(!$order) {
                return false;
            }

            $this->paymentForm->setValue('amount', $order['order']->net_amount);

            if(isEqual(whoIs('user_type'), 'customer')) {
                $this->paymentForm->setValue('payer_name', whoIs(['firstname', 'lastname']));
            }
            $this->paymentForm->init([
                'method' => 'post',
                'url' => _route('payment:create')
            ]);

            $this->paymentForm->add([
                'type' => 'hidden',
                'name' => 'order_id',
                'value' => $id
            ]);

            $this->paymentForm->add([
                'type' => 'hidden',
                'name' => 'payment_type',
                'value' => 'ONLINE'
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