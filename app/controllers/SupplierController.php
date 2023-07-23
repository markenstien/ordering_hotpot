<?php
    load(['SupplierForm'], APPROOT.DS.'form');
    use Form\SupplierForm;

    class SupplierController extends Controller
    {
        public function __construct()
        {
            $this->supplierForm = new SupplierForm();
            $this->data['supplier_form'] = $this->supplierForm;

            $this->model = model('SupplierModel');
        }

        public function index()
        {
            $this->data['suppliers'] = $this->model->all(null,'created_at asc');
            return $this->view('supplier.index',$this->data);
        }

        public function create()
        {
            $request = request()->inputs();

            if (isSubmitted()) {
                $res = $this->model->createOrUpdate($request);
                if(!$res) {
                    Flash::set($this->model->getErrorString(), 'danger');
                    return request()->return();
                }
                Flash::set("Supplier {$request['name']} has been saved");
                return redirect(_route('supplier:index'));
            }

            $this->data['supplier_form']->init([
                'action' => _route('supplier:create'),
                'method' => 'post'
            ]);

            return $this->view('supplier/create',$this->data);
        }

        public function show($id) {
            $this->data['supplier'] = $this->model->get($id);
            $this->data['id'] = $id;
            return $this->view('supplier/show', $this->data);
        }

        public function edit($id) 
        {
            $request = request()->inputs();
            if (isSubmitted()) {
                $res = $this->model->createOrUpdate($request, $request['id']);
                if(!$res) {
                    Flash::set($this->model->getErrorString(),'danger');
                }else{
                    Flash::set($this->model->getMessageString());
                }
                return redirect(_route('supplier:edit', $id));
            }

            $supplier = $this->model->get($id);
            $this->data['id'] = $id;
            $this->data['supplier'] = $supplier;
            $this->data['supplier_form']->init([
                'action' => _route('supplier:edit', $id),
                'method' => 'post'
            ]);
            $this->data['supplier_form']->setValueObject($supplier);
            $this->data['supplier_form']->addId($id);

            return $this->view('supplier/edit', $this->data);
        }
    }