<?php
    namespace Form;
    use Core\Form;
    load(['Form'], CORE);

    class BankOrgForm extends Form {

        public function __construct()
        {
            parent::__construct();
            $this->addName();
            $this->addCode();
        }

        public function addName() {
            $this->add([
                'name' => 'bank_name',
                'type' => 'text',
                'class' => 'form-control',
                'required' => true,
                'options' => [
                    'label' => 'Org name'
                ],
                'required' => true
            ]);
        }

        public function addCode() {
            $this->add([
                'name' => 'bank_code',
                'type' => 'text',
                'class' => 'form-control',
                'required' => true,
                'options' => [
                    'label' => 'Org Code'
                ],
                'required' => true
            ]);
        }
    }