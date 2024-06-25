<?php
    namespace Form;
    use Core\Form;
    load(['Form'], CORE);

    class CommonTextForm extends Form {

        public function __construct()
        {
            parent::__construct();
            $this->init();
            $this->addTitle();
            $this->addContent();   
        }
        public function addTitle() {
            $this->add([
                'type' => 'text',
                'name' => 'text_title',
                'options' => [
                    'label' => 'Title',
                ],
                'class' => 'form-control',
                'required' => true
            ]);
        }

        public function addContent() {
            $this->add([
                'type' => 'textarea',
                'name' => 'text_content',
                'options' => [
                    'label' => 'Message',
                ],
                'class' => 'form-control',
                'required' => true,
                'attributes' => [
                    'rows' => 5
                ]
            ]);
        }
    }