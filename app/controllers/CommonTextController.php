<?php
    use Form\CommonTextForm;
    load(['CommonTextForm'], APPROOT.DS.'form');
    class CommonTextController extends Controller
    {

        public $commonTextModel;

        public function __construct()
        {
            parent::__construct();

            $this->commonTextModel = model('CommonTextModel');
            $this->data['commonTextForm'] = new CommonTextForm();
            _authRequired();
        }

        public function index() {
            $condition = null;
            if(isEqual(whoIs('user_type'), ['customer'])) {
                $condition = [
                    'owner_id' => whoIs('id')
                ];
            }

            $this->data['reviews'] = $this->commonTextModel->getCompanyReviews([
                'where' => $condition
            ]);
            
            return $this->view('commontext/index', $this->data);
        }
        
        public function create() {
            if(isSubmitted()) {
                $post = request()->post();

                if(empty($post['text_content'])) {
                    Flash::set('Invalid review', 'danger');
                    return request()->return();
                }
                $resp = $this->commonTextModel->store([
                    'text_content' => $post['text_content'],
                    'owner_id' => whoIs('id'),
                    'catalog'  => 'company_reviews',
                    'is_visible' => false
                ]);
                Flash::set('Review Created');
                return redirect(_route('common-text:show', $resp));
            }
            return $this->view('commontext/create', $this->data);
        }
        
        public function edit($id) {
            if(isSubmitted()) {
                $post = request()->post();

                if(empty($post['text_content'])) {
                    Flash::set('Invalid review', 'danger');
                    return request()->return();
                }
                $this->commonTextModel->update([
                    'text_content' => $post['text_content']
                ], $post['id']);

                $this->commonTextModel->deny($post['id']);

                Flash::show('Review Updated');

                return redirect(_route('common-text:show', $id));
            }

            $review = $this->commonTextModel->getCompanyReviews([
                'where' => [
                    'review.id' => $id
                ]
            ])[0] ?? false;

            $this->data['review'] = $review;

            $this->data['commonTextForm']->setValue('text_content', $review->text_content ?? '');
            return $this->view('commontext/edit', $this->data);
        }

        public function show($id) {
            $this->data['review'] = $this->commonTextModel->getCompanyReviews([
                'where' => [
                    'review.id' => $id
                ]
            ])[0] ?? false;

            if(!$this->data['review']) {
                Flash::set('Review not found', 'danger');
                return request()->return();
            }
            return $this->view('commontext/show', $this->data);
        }

        public function approve($id) {
            $this->commonTextModel->approve($id);
            Flash::set('Review Approved');
            return request()->return();
        }

        public function deny($id) {
            $this->commonTextModel->deny($id);
            Flash::set('Review Denied', 'danger');

            return request()->return();
        }
    }