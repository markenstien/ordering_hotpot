<?php 	
	use Form\AppointmentForm;
	use Form\PaymentForm;

	load(['AppointmentForm','PaymentForm'] , APPROOT.DS.'form');

	class AppointmentController extends Controller
	{
		private $model,$service,
		$service_bundle,
		$category,
		$service_cart_model,
		$reservationFeeModel,
		$modelPayment, $modelOrder, $modelSession;

		public $_form,$_paymentForm;

		public function __construct()
		{
			parent::__construct();
			_authRequired();
			$this->modelPayment = model('PaymentModel');
			$this->modelOrder = model('OrderModel');

			$this->category = model('CategoryModel');
			$this->model = model('AppointmentModel');
			// $this->reservationFeeModel  = model('ReservationFeeSettingModel');
			// $this->modelSession = model('SessionModel');

			$this->_form = new AppointmentForm();
			$this->_paymentForm = new PaymentForm();
		}

		/**
		 * Temporary to keep order glasses online
		 * */
		public function appointment_form() {
			if(isSubmitted()) {
				$post = request()->posts();
				$res = $this->model->create($post);

				if(!$res) {
					Flash::set($this->model->getErrorString(), 'danger');
					if(isset($post['returnTo'])) {
						request()->saveEntries();
						return redirect(unseal($post['returnTo']));
					} else {
						return request()->return();
					}
				} else {
					Flash::set($this->model->getMessageString());

					if(!empty($post['reservation_fee'])) {
						//reservation fee
						return redirect(_route('appointment:payment-add',null,[
							'appointmentID' => seal($this->model->_getRetval('appointment_id'))
						]));
					}
					return redirect(_route('auth:login'));
				}
			}
			$this->data['form'] = $this->_form;
			$this->data['reservationFee']  = $this->reservationFeeModel->getActive();

			return $this->view('appointment/appointment_form', $this->data);
		}

		public function index()
		{
			/*
			*select service that you want
			*/
			$auth = whoIs();

			if(isEqual($auth->user_type , 'patient')){
				$appointments = $this->model->all([
					'user_id' => $auth->id
				], "FIELD(status, 'scheduled', 'pending', 'arrived', 'cancelled') asc, date desc");
			}else{
				$appointments = $this->model->all(null, "FIELD(status, 'scheduled', 'pending', 'arrived', 'cancelled') asc, id desc, date desc");
			}

			$data = [
				'title' => 'Appointments',
				'appointments' => $appointments
			];

			return $this->view('appointment/index' , $data);
		}


		public function createWithBill()
		{
			if( isSubmitted() )
			{
				$post = request()->posts();

				$res = $this->model->createWithBill( $post );

				if(!$res) 
				{
					Flash::set( $this->model->getErrorString() , 'danger') ;
					return request()->return();
				}

				//kill reservation

				$this->service_cart_model->destroyCart();

				Flash::set("Appointment Created");

				$auth = auth();

				if( !$auth) 
					return redirect( _route('bill:show' , $res) );

				if( isEqual($post['type'] , 'walk-in') )
					return redirect( _route('appointment:show' , $res) );
				
				return redirect( _route('appointment:show' , $res) );	
			}
		}

		public function create()
		{	
			if( isset($_GET['btn_filter']) )
			{	
				$rq  = request()->inputs();

				if( empty($rq['key_word']) && !isset($rq['categories']) )
				{
					Flash::set("Filter failed" , 'danger');
					return request()->return();
				}

				$services = $this->service->getByFilter( $rq );

				$service_bundles = $this->service_bundle->getByFilter($rq);

			}elseif(isset($_GET['category']))
			{
				$services = $this->service->getAll([
					'where' => [
						'category' => $_GET['category']
					]
				]);

				$service_bundles = $this->service_bundle->getAll([
					'where' => [
						'category' => $_GET['category']
					]
				]);
			}else
			{

				$services = $this->service->getAll([
					'where' => [
						'is_visible' => true
					]
				]);

				$service_bundles = $this->service_bundle->getAll([
					'where' => [
						'is_visible' => true
					]
				]);
			}

			$categories = $this->category->getAll([
				'cat_key' => 'SERVICES'
			]);

			$cart_summary = $this->service_cart_model->getCartSummary();

			$data = [
				'title' => 'Create An Appointment',
				'categories' => $categories,
				'service_bundles' => $service_bundles,
				'services'   => $services,
				'service_cart_model' => $this->service_cart_model,
				'cart_summary'  => $cart_summary
			];

			return $this->view('appointment/create' , $data);
		}


		public function edit($id)
		{
			if( isSubmitted() )
			{
				$post = request()->posts();

				$res = $this->model->save($post , $post['id']);

				if(!$res){
					Flash::set( $this->model->getErrorString() , 'danger');
				}else{
					Flash::set("Appointment updated!");
				}

				return request()->return();
			}

			$appointment = $this->model->get($id);
	
			$form = $this->_form;

			$form->init([
				'url' => _route('appointment:edit' , $id)
			]);

			$form->setValueObject( $appointment );

			$form->addId($id);
			$form->customSubmit('Save Changes' , 'submit');

			$data = [
				'title' => 'Update Appointment',
				'form'  => $form,
				'appointment' => $appointment,
				'bill'  => $this->model->getBill($id)
			];

			return $this->view('appointment/edit' , $data);
		}

		public function show($id)
		{
			$appointment = $this->model->getComplete($id);
			// $payment = $this->modelPayment->getByKey([
			// 	'origin' => 'RESERVATION_FEE',
			// 	'bill_id' => $id
			// ]);

			// $session = $this->modelSession->single([
			// 	'appointment_id' => $id
			// ]);

			// $attachment = $this->_attachmentModel->single([
			// 	'global_key' => 'RESERVATION_PAYMENT_PHOTO',
			// 	'global_id' => $payment->id ?? 0
			// ]);

			$data = [
				'appointment' => $appointment,
				'title' => '#'.$appointment->reference. ' | Appointment',
				'_form'  => $this->_form
				// 'payment' => $payment,
				// 'session' => $session,
				// 'attachment' => $attachment
			];
			
			return $this->view('appointment/show' , $data);
		}

		public function addPayment() {
			$req = request()->inputs();

			$appointmentId = unseal($req['appointmentID']);
			$appointment = $this->model->get($appointmentId);

			$this->_paymentForm->setValue('amount', $appointment->reservation_fee);

			$this->_paymentForm->add([
				'name' => 'method',
				'type' => 'text',
				'class' => 'form-control',
				'required' => true,
				'options' => [
					'label' => 'Payment Method'
				],
				'attributes' => [
					'readonly' => true
				],
				'value' => 'Online'
			]);

			$this->data['paymentForm'] = $this->_paymentForm;
			$this->data['appointment'] = $appointment;
			return $this->view('appointment/payment', $this->data);
		}

		public function cancel($id) {
			$res = $this->model->cancel($id);
			if($res) {
				Flash::set('Reservation has been cancelled');
			}

			return request()->return();
		}

		public function approve($id) {
			$res = $this->model->approve($id);
			if($res) {
				Flash::set('Reservation arrived');
			}

			return request()->return();
		}
	}