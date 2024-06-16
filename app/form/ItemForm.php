<?php

    namespace Form;

    load(['Form'],CORE);
    load(['CategoryService'], SERVICES);
    use Core\Form;
    use Services\CategoryService;

    class ItemForm extends Form{

        private $categoryModel;

        public function __construct($name = '')
        {
            parent::__construct();
            $this->name = empty($name) ? 'Item Form' : $name;
            $this->categoryModel = model('CategoryModel');

            $this->addName();
            $this->addSku();
            $this->addBarcode();
            $this->addCostPrice();
            $this->addSellPrice();
            $this->addMinStock();
            $this->addMaxStock();
            $this->addCategory();
            $this->addManufacturer();
            $this->addBrand();
            $this->addVariant();
            $this->addRemarks();
            $this->addPacking();
            $this->addQuantityPerCase();

            $this->customSubmit('Save Item');
        }

        public function addName() {
            $this->add([
                'name' => 'name',
                'type' => 'text',
                'required' => true,
                'options' => [
                    'label' => 'Item Name'
                ],
                'class' => 'form-control'
            ]);
        }

        public function addSku() {
            $this->add([
                'name' => 'sku',
                'type' => 'text',
                'required' => true,
                'options' => [
                    'label' => 'Product Code'
                ],
                'class' => 'form-control'
            ]);
        }

        public function addBarcode() {
            $this->add([
                'name' => 'barcode',
                'type' => 'text',
                'options' => [
                    'label' => 'Barcode'
                ],
                'class' => 'form-control'
            ]);
        }

        public function addCostPrice() {
            $this->add([
                'name' => 'cost_price',
                'type' => 'text',
                'required' => true,
                'options' => [
                    'label' => 'Cost Price'
                ],
                'class' => 'form-control'
            ]);
        }

        public function addSellPrice() {
            $this->add([
                'name' => 'sell_price',
                'type' => 'text',
                'required' => true,
                'options' => [
                    'label' => 'Sell Price'
                ],
                'class' => 'form-control'
            ]);
        }

        public function addMinStock() {
            $this->add([
                'name' => 'min_stock',
                'type' => 'number',
                'required' => true,
                'options' => [
                    'label' => 'Minimum Stocks'
                ],
                'class' => 'form-control'
            ]);
        }

        public function addMaxStock() {
            $this->add([
                'name' => 'max_stock',
                'type' => 'number',
                'required' => true,
                'options' => [
                    'label' => 'Maximum Stocks'
                ],
                'class' => 'form-control'
            ]);
        }


        public function addCategory() {
            
            $categories = $this->categoryModel->all([
                'active' => 1,
                'category' => CategoryService::ITEM
            ],'name asc');
            $categories = arr_layout_keypair($categories,['id','name']);
            $this->add([
                'name' => 'category_id',
                'type' => 'select',
                'required' => true,
                'options' => [
                    'label' => 'Category',
                    'option_values' => $categories
                ],
                'class' => 'form-control'
            ]);
        }


        public function addVariant() {
            $this->add([
                'name' => 'variant',
                'type' => 'text',
                'options' => [
                    'label' => 'Variant'
                ],
                'class' => 'form-control'
            ]);
        }

        public function addRemarks() {
            $this->add([
                'name' => 'remarks',
                'type' => 'textarea',
                'options' => [
                    'label' => 'Description',
                    'rows' => 3
                ],
                'required' => true,
                'class' => 'form-control'
            ]);
        }

        public function addManufacturer() {
            $categories = $this->categoryModel->all([
                'active' => 1,
                'category' => CategoryService::MANUFACTURER
            ],'name asc');

            $categories = arr_layout_keypair($categories,['id','name']);
            $this->add([
                'name' => 'manufacturer_id',
                'type' => 'select',
                'required' => true,
                'options' => [
                    'label' => 'Manufacturer',
                    'option_values' => $categories
                ],
                'class' => 'form-control'
            ]);
        }

        public function addBrand() {
            $categories = $this->categoryModel->all([
                'active' => 1,
                'category' => CategoryService::BRAND
            ],'name asc');
            
            $categories = arr_layout_keypair($categories,['id','name']);
            $this->add([
                'name' => 'brand_id',
                'type' => 'select',
                'required' => true,
                'options' => [
                    'label' => 'Brand Name',
                    'option_values' => $categories
                ],
                'class' => 'form-control'
            ]);
        }

        /**
         * for medical items
         */
        public function addPacking() {
            $this->add([
                'name' => 'packing',
                'type' => 'number',
                'options' => [
                    'label' => 'Packing'
                ],
                'class' => 'form-control'
            ]);
        }

        public function addQuantityPerCase() {
            $this->add([
                'name' => 'qty_per_case',
                'type' => 'number',
                'options' => [
                    'label' => 'Quantity Per Case'
                ],
                'class' => 'form-control'
            ]);
        }
    }