<?php 
	use Services\OrderService;
	use Form\PaymentForm;

	load(['OrderService'], APPROOT.DS.'services');
	load(['PaymentForm'], APPROOT.DS.'form');
	
	class CartController extends Controller {

		public function __construct() {
			parent::__construct();
			$this->modelOrderItem = model('OrderItemModel');
			$this->modelOrder = model('OrderModel');
			$this->formPayment = new PaymentForm();
		}

		public function index() {
			$items = $this->modelOrderItem->getCurrentSession('cart');
			$this->data['items'] = $items;
			return $this->view('cart/index', $this->data);
		}

		public function addToCart() {
			if(isSubmitted()) {
				$post = request()->posts();

				$res  = $this->modelOrderItem->addOrUpdatePurchaseItem([
					'item_id' => $post['item_id'],
					'quantity' => $post['quantity'],
					'price'  => $post['price'],
					'session_name' => 'cart',
					'staff_id' => null,
					'customer_id' => whoIs('id')
				]);

				if($res) {
					Flash::set("Item added to cart");
					return redirect(_route('cart:index'));
				} else {
					Flash::set($this->modelOrderItem->getErrorString(), 'danger');
					return request()->return();
				}
			}
		}

		public function checkout() {

			if(isSubmitted()) {
				$post = request()->posts();
				$session = $this->modelOrderItem->getCurrentSessionId('cart');
                $items = $this->modelOrderItem->getCurrentSession('cart');
                $itemSummary = $this->modelOrderItem->getItemSummary($items);


                if(empty($items)) {
                    Flash::set("There are no orders found!",'danger');
                    return request()->return();
                }

                $orderData = [
                    'customer_name' => empty($post['payer_name']) ? 'Guest' : $post['payer_name'],
                    'mobile_number' => $post['mobile_number'],
                    'address' => $post['address'],
                    'remarks' => 'Guest Order',
                    'gross_amount' => $itemSummary['grossAmount'],
                    'net_amount' => $itemSummary['netAmount'],
                    'discount_amount' => $itemSummary['discountAmount'],
                    'id' => $session
                ];
                

                $result = $this->modelOrder->placeAndPay($orderData, $paymentData);
                
                if($result) {
                    OrderService::endPurchaseSession('cart');
                    OrderService::startPurchaseSession('cart');//reset order

                    Flash::set($this->modelOrder->getMessageString());
                    return redirect(_route('receipt:order', $session));
                } 
			}

			$items = $this->modelOrderItem->getCurrentSession('cart');

			if(empty($items)) {
				Flash::set("Unable to process checkout no items found.", 'danger');
				return redirect(_route('cart:index'));
			}

			if(isEqual(whoIs('user_type'),'customer')) {
				$this->formPayment->setValue('payer_name', whoIs(['firstname','lastname']));
				$this->formPayment->setValue('mobile_number', whoIs('phone'));
				$this->formPayment->setValue('address', whoIs('address'));
			}
			$this->data['items'] = $items;
			$this->data['formPayment'] = $this->formPayment;


			return $this->view('cart/checkout', $this->data);
		}

		public function destroy($id) {
			Flash::set("Item deleted", 'danger');
			$this->modelOrderItem->delete($id);
			return request()->return();
		}

		private function startCart() {
			$purchaseSession = OrderService::getPurchaseSession('cart');
            if (empty($purchaseSession)) {
                OrderService::startPurchaseSession('cart');
            }
            return OrderService::getPurchaseSession('cart');
		}
	}