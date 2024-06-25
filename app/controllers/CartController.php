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
			$this->itemModel = model('ItemModel');
			$this->formPayment = new PaymentForm();
		}

		public function index() {
			$items = $this->modelOrderItem->getCurrentSession('cart');

			foreach($items as $key => $row) {
				$row->image = $this->itemModel->getSingleImage($row->item_id);
			}

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
				], $post['cart_id'] == 0 ? null : $post['cart_id']);

				if($res) {
					Flash::set($this->modelOrderItem->getMessageString());
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

				$order = $this->modelOrder->get($session);

                $orderData = [
                    'customer_name' => empty($post['payer_name']) ? 'Guest' : $post['payer_name'],
                    'mobile_number' => $post['mobile_number'],
                    'address' => $post['address'],
                    'remarks' => 'Guest Order',
                    'gross_amount' => $itemSummary['grossAmount'],
                    'net_amount' => $itemSummary['netAmount'],
                    'discount_amount' => $itemSummary['discountAmount'],
                    'id' => $session,
					'customer_id' => whoIs('id'),
					'reference' => $order->reference
                ];
				
                $orderResponse = $this->modelOrder->placeAndPay($orderData, null);
                if($orderResponse) {
					$itemsList = "";
					foreach($items as $key => $row) {
						$itemsList .= "<li> {$row->name} | {$row->price} | {$row->quantity} | {$row->sold_price}</li>";
					}

					if(isEqual(whoIs('user_type'), 'customer')) {
						$emailBody = <<<EOF
							<h1> Thank you for your ordering</h1>
							<p> Here is your order details </p>
							<ul> 
								<li> Order Reference : #{$order->reference} </li>
								<li> Total : {$orderData['net_amount']} </li>
								<li> Contact : {$orderData['customer_name']} {$orderData['mobile_number']} </li>
							</ul>
							<p> Particulars </p>

							<ol> 
								{$itemsList}
							</ol>
						EOF;

						$emailBody = wEmailComplete($emailBody);
						$emailPlaceHolder = [
							whoIs('email'),
							"Order #{$order->reference}",
							$emailBody
						];
						_mail(... $emailPlaceHolder);
					}
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

			$this->data['whoIs'] = whoIs();
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