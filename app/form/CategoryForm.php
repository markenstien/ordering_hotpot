<?php
    namespace Form;
    
    use Core\Form;
    use Services\CategoryService;

    load(['Form'],CORE);
    load(['CategoryService'],SERVICES);
    
    class CategoryForm extends Form
    {
        public function __construct()
        {
            parent::__construct();

            $this->name = 'category_form';
            $this->addName();
            $this->addCategory();

            $this->customSubmit('Create New Category');
        }

        public function addName() {
            $this->add([
                'name' => 'name',
                'type' => 'text',
                'required' => true,
                'options' => [
                    'label' => 'Name'
                ],
                'class' => 'form-control'
            ]);
        }

        public function addCategory() {
            $this->add([
                'name' => 'category',
                'type' => 'select',
                'required' => true,
                'options' => [
                    'label' => 'Category',
                    'option_values' => [
                        CategoryService::PRODUCT_CATEGORY,
                    ]
                ],
                'class' => 'form-control'
            ]);
        }
    }