<?php
    use Form\PettyCashForm;
    load(['PettyCashForm'], APPROOT.DS.'form');

    class PettyCashController extends Controller
    {   
        public function __construct()
        {
            parent::__construct();
            $this->model = model('PettyCashModel');

            $this->pettyCashForm = new PettyCashForm();
        }

        public function index() {
            $this->data['petty_cash'] = $this->model->getSummary();
            return $this->view('petty_cash/index', $this->data);
        }

        public function create() {
            $req = request()->inputs();

            if (isSubmitted()) {
                $res = $this->model->createOrUpdate($req);
                if($res) {
                    Flash::set($this->model->getMessageString());
                }else{
                    Flash::set($this->model->getErrorString());
                }
                return redirect(_route('petty-cash:index'));
            }

            $this->pettyCashForm->init([
                'method' => 'post',
                'action' => _route('petty-cash:create')
            ]);

            $this->data['form'] = $this->pettyCashForm;
            return $this->view('petty_cash/create', $this->data);
        }

        public function edit($id) {
            $req = request()->inputs();

            if (isSubmitted()) {
                $res = $this->model->createOrUpdate($req);

                if ($res) {
                    Flash::set($this->model->getMessageString());
                } else {
                    Flash::set($this->model->getErrorString(), 'danger');
                }

                return redirect(_route('petty-cash:show', $id));
            }

            $this->pettyCashForm->init([
                'method' => 'post',
                'action' => _route('petty-cash:create')
            ]);
            
            $pettyCash = $this->model->get($id);
            $this->pettyCashForm->setValueObject($pettyCash);

            $this->data['form'] = $this->pettyCashForm;
            return $this->view('petty_cash/create', $this->data);
        }

        public function show($id) {
            $pettyCash = $this->model->get($id);
            $this->data['pettyCash'] = $pettyCash;
            return $this->view('petty_cash/show', $this->data);
        }

        public function logs($id = null) {

            if (!is_null($id)) {
                $logs = $this->model->all([
                    'user_id' => $id
                ],'id desc');
            } else {
                $logs = $this->model->all(null, 'id desc');
            }
            $this->data['logs'] = $logs;
            return $this->view('petty_cash/logs', $this->data);
        }
    }