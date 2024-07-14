<?php
    use Form\BankOrgForm;
    load(['BankOrgForm'], APPROOT.DS.'form');

    class BankOrgController extends Controller
    {   
        public $bankOrgForm;
        public function __construct()
        {
            parent::__construct();
            
            $this->bankOrgForm = new BankOrgForm();
            $this->model = model('BankOrgModel');
        }
        public function index() {
            $this->data['bankOrgForm'] = $this->bankOrgForm;
            $this->data['banks'] = $this->model->all();

            return $this->view('bank_org/index', $this->data);
        }

        public function create() {
            if(isSubmitted()) {
                $post = request()->post();

                $resp = $this->model->store([
                    'bank_name' => $post['bank_name'],
                    'bank_code' => $post['bank_code']
                ]);

                if($resp) {
                    Flash::set("Bank created '{$post['bank_name']}'");
                    return redirect(_route('bank-org:index'));
                }
                Flash::set('Something went wrong', 'danger');
                return request()->return();
            }
            $this->data['bankOrgForm'] = $this->bankOrgForm;
            return $this->view('bank_org/create', $this->data);
        }

        public function edit($id) {

            if(isSubmitted()) {
                $post = request()->post();
                $resp = $this->model->update([
                    'bank_name' => $post['bank_name'],
                    'bank_code' => $post['bank_code'],
                ], $id);

                if(!$resp) {
                    Flash::set("Bank Update failed");
                } else {
                    Flash::set("Bank Updated");
                }
                return redirect(_route('bank-org:index'));
            }

            $bankOrg = $this->model->single($id);
            $this->bankOrgForm->setValueObject($bankOrg);
            $this->bankOrgForm->addId($id);
            $this->data['bankOrgForm'] = $this->bankOrgForm;
            return $this->view('bank_org/edit', $this->data);
        }

        public function delete($id) {
            $this->model->delete($id);
            return redirect(_route('bank-org:index'));
        }
    }