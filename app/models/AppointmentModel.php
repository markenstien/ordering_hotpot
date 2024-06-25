<?php 
	class AppointmentModel extends Model
	{

		public $table = 'appointments';

		public $_fillables = [
			'reference',
			'start_time',
			'end_time',
			'date',
			'user_id',
			'type',
			'remark',
			'guest_name',
			'guest_email',
			'guest_phone',
			'status',
			'notes',
			'reservation_fee'
		];

		public function save($appointment_data , $id = null)
		{
			$fillable_datas = $this->getFillablesOnly($appointment_data);

			if(!is_null($id) ){
				if(!$this->checkAvailability($fillable_datas['date']) || $this->checkDuplicateAppointment($appointment_data)) 
				return false;
				return parent::update($fillable_datas , $id);
			}else
			{
				return $this->create($fillable_datas);
			}
		}
		
		public function create($appointment_data)
		{	
			extract($appointment_data);

			if(!$this->checkAvailability($date) || $this->checkDuplicateAppointment($appointment_data)) 
				return false;
			/*check appointment date if in maximum*/

			$reference =  $this->generateRefence();

			$appointment_data['reference'] = $reference;
			$appointment_data['user_id'] = $user_id ?? '';
			$appointment_data['type'] = $type ?? 'online';
			$appointment_data['remark'] = $remark ?? '';
			$appointment_data['status'] = $status ?? 'pending';

			$_fillables = $this->getFillablesOnly($appointment_data);
			$appointment_id = parent::store($_fillables);

			$appointment_link = _route('appointment:show' , $appointment_id);

			if($appointment_id)
			{
				$user_model = model('UserModel');
				if(!empty($appointment_data['user_id']))
				{
					$user = $user_model->single(['id' => $appointment_data['user_id']]);
					$email = $user->email;
					$user_mobile_number = $user->phone_number;
				} else {
					$email = $appointment_data['guest_email'];
					$user_mobile_number = $appointment_data['guest_phone'];
				}

				$user = $user_model->getByKey('email', $email)[0] ?? false;

				if($user) {
					//update appintment
					parent::update([
						'user_id' => $user->id
					], $appointment_id);
				}

				_notify_include_email("Reservation to ".COMPANY_NAME." is submitted .#{$reference} reservation reference",
				[$appointment_data['user_id']],[$email] , ['href' => $appointment_link ]);
				if($user_mobile_number) {
					// send_sms("Appointment to ".COMPANY_NAME." is submitted .#{$reference} appointment reference" , [$user_mobile_number]);
				}
				_notify_operations("Reservation to ".COMPANY_NAME." is submitted .#{$reference} reservation reference" , ['href' => $appointment_link]);
			}
			parent::_addRetval('appointment_id', $appointment_id);
			return $appointment_id;
		}

		public function createWithBill( $appointment_data )
		{
			$this->bill_model = model('BillModel');

			$cart_items = $this->bill_model->getCartItems();

			if(!$cart_items){
				$this->addError("Unable to save apointment no services selected ");
				return false;
			}

			//check item firsts
			$appointment_id = $this->create($appointment_data);

			if(!$appointment_id)
				return false;

			$this->bill_model = model('BillModel');

			$bill_data = [
				'user_id' => $appointment_data['user_id'] ?? '',
				'payment_status' => $appointment_data['payment_status'] ?? 'unpaid',
				'payment_method' => $appointment_data['payment_method'] ?? 'na',
				'bill_to_name'  => $appointment_data['guest_name'],
				'bill_to_email'  => $appointment_data['guest_email'],
				'bill_to_phone'  => $appointment_data['guest_phone'],
				'appointment_id' => $appointment_id,
				'discount' => $appointment_data['discount']
			];

			$this->bill_id = $this->bill_model->createPullServiceCartItems( $bill_data );

			return $appointment_id;
		}

		public function cancel($id) {
			return parent::update([
				'status' => 'cancelled'
			], $id);
		}

		public function approve($id) {
			return parent::update([
				'status' => 'arrived'
			], $id);
		}

		public function generateRefence()
		{
			return strtoupper('RSV-'.get_token_random_char(7));
		}

		public function getComplete( $id )
		{
			$appointment = parent::get($id);

			if(!$appointment){
				$this->addError("appointment not found");
				return false;
			}

			return $appointment;
			//bill
			// $bill = $this->getBill($id);

			// $appointment->bill = $bill;

			// return $appointment;
		}



		public function getBill($id)
		{
			return false;
		}

		public function updateStatus($id , $status)
		{
			$update_payment_status = parent::update([
				'status' => $status
			], $id);

			//create notification

			return $update_payment_status;
		}

		public function getTotalAppointmentByDate($date)
		{
			$this->db->query(
				"SELECT sum(id) as total 
					FROM {$this->table}
					WHERE date = '{$date}' 
					AND status not in ('cancelled')
					AND type = 'online'
					GROUP BY date"
			);

			return $this->db->single()->total ?? 0;
		}

		public function checkDuplicateAppointment($data) {
			$exists = parent::single([
				'date' => $data['date'],
				'guest_email' => $data['guest_email'],
				'status' => 'pending'
			]);

			if($exists) {
				$this->addError("Duplicate Appointment");
				return true;
			}
			return false;
		}

		public function checkAvailability($date)
		{
			$dateGapCheck = $this->_checkDateDifference($date);
			//date gap check failed
			if(!$dateGapCheck) {
				return false;
			}

			// $schedule_model = model('ScheduleModel');

			// $total_person_reserved = $this->getTotalAppointmentByDate($date);
			// $day_name = date('l' , strtotime($date));
			// $date_by_name = $schedule_model->getByAppointmentByDay($day_name);

			// if($date_by_name->max_visitor_count <= $total_person_reserved){
			// 	$this->addError("There are {$total_person_reserved} reservees on this Date {$date}($day_name), please schedule another day");
			// 	return false;
			// }

			$message = "Date is available you are reserved";
			$this->addMessage($message);
			return true;
		}


		private function _checkDateDifference($reservationDate) {
			
			$dateToday = today();
			$dateDifference = strtotime($reservationDate) - strtotime($dateToday);
			$dateDifferenceByDay = (($dateDifference / 60) / 60)/24;

			if($dateDifferenceByDay < 0) {
                $this->addError("Cannot select date, lesser than {$dateToday}");
				return false;	
			}
			return true;
		}
	}