<?php 

    class Product extends Controller
    {   
        public function __construct()
        {
            parent::__construct();
            $this->itemModel = model('ItemModel');
        }
        public function searchProductByBarcode() {

            $req = request()->inputs();

            if(!empty($req['barcode'])) {
                $item = $this->itemModel->all([
                    'barcode' => $req['barcode']
                ]);

                if($item) {
                    $data = $item[0];
                }else{
                    $data = [];
                }
                return ee(api_response($data));
            }
        }

        public function searchProductByCategoryId() {
            $req = request()->inputs();
            if(!empty($req['category_id'])) {
                $data = $this->itemModel->getAll([
                    'where' => [
                        'category_id' => $req['category_id']
                    ]
                ]);
                return ee(api_response($data));
            }
        }
    }