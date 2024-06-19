<?php 

	namespace Form;
	load(['Form'] , CORE);

	use Core\Form;
	
	class AppointmentForm extends Form
	{

		public function __construct()
		{	
			parent::__construct();

			$this->init([
				'url' => _route('appointment:appointment_form')
			]);

			$this->addDate();
			$this->addStartTime();
			$this->addGuestName();
			$this->addGuestEmail();
			$this->addGuestPhoneNumber();
			$this->addType();
			$this->addNotes();

			$this->customSubmit('Reserve');
		}

		public function addDate()
		{
			$this->add([
				'type' => 'date',
				'name' => 'date',
				'class' => 'form-control',
				'required' => true,
				'options' => [
					'label' => 'Date'
				]
			]);
		}

		public function addGuestName()
		{
			$this->add([
				'type' => 'text',
				'name' => 'guest_name',
				'class' => 'form-control',
				'required' => true,
				'options' => [
					'label' => 'Main Guest Name'
				],
				'attributes' => [
					'placeholder' => 'eg. Jhone Doe'
				]
			]);
		}

		public function addGuestEmail()
		{
			$this->add([
				'type' => 'email',
				'name' => 'guest_email',
				'class' => 'form-control',
				'required' => true,
				'options' => [
					'label' => 'Email'
				],
				'attributes' => [
					'placeholder' => 'We will send the confirmation here.'
				]
			]);
		}

		public function addGuestPhoneNumber()
		{
			$this->add([
				'type' => 'number',
				'name' => 'guest_phone',
				'class' => 'form-control',
				'required' => true,
				'options' => [
					'label' => 'Mobile Number'
				],
				'attributes' => [
					'placeholder' => 'Working Mobile Number'
				]
			]);
		}

		public function addType()
		{
			// $this->add([
			// 	'type' => 'select',
			// 	'name' => 'type',
			// 	'class' => 'form-control',
			// 	'options' => [
			// 		'label' => 'Type',
			// 		'option_values' => [
			// 			'online' , 'walk-in'
			// 		]
			// 	]
			// ]);
		}

		public function addStartTime()
		{
			$this->add([
				'type' => 'time',
				'name' => 'start_time',
				'class' => 'form-control',
				'required' => true,
				'options' => [
					'label' => 'Time of Arrival'
				]
			]);
		}

		public function addStatus( $value = 'pending')
		{
			$this->add([
				'type' => 'select',
				'name' => 'status',
				'class' => 'form-control',
				'value' => $value,
				'options' => [
					'label' => 'Status',
					'option_values' => [
						'pending', 'arrived', 'cancelled','scheduled'
					]
				]
			]);
		}

		public function addNotes()
		{
			$this->add([
				'type' => 'textarea',
				'name' => 'notes',
				'class' => 'form-control',
				'required' => true,
				'options' => [
					'label' => 'Notes for us',
				],
				'attributes' => [
					'rows' => 4,
					'placeholder' => 'eg. we are 4 people in total!, place us in smoking free area'
				]
			]);
		}

		public function addUserId() {
			$this->add([
				'type' => 'hidden',
				'name' => 'user_id',
				'class' => 'form-control'
			]);
		}
	}