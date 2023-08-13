<?php 
	load(['UserService', 'OrderService'], SERVICES);
	load(['UserForm'] , APPROOT.DS.'form');

	use Form\UserForm;
	use Services\UserService;
	use Services\OrderService;


	class AuthController extends Controller
	{	

		public function __construct()
		{
			$this->user = model('UserModel');
			$this->_form = new UserForm();
			$this->meta = model('CommonMetaModel');
			$this->serviceOrder = new OrderService();
		}

		public function index()
		{
			return $this->login();
		}

		public function login()
		{
			if(isSubmitted())
			{
				$post = request()->posts();

				$res = $this->user->authenticate($post['email'] , $post['password']);

				if(!$res) {
					Flash::set( $this->user->getErrorString() , 'danger');
					return request()->return();
				}else
				{
					Flash::set( "Welcome Back !" . auth('first_name'));
				}

				$cart = OrderService::getPurchaseSession('cart');

				if(!empty($cart)) {
					Flash::set("Welcome back ".whoIs('firstname')." continue your shopping");
					return redirect(_route('cart:index'));
				}
				return redirect('DashboardController');
			}

			if(!empty(whoIs())) {
				return redirect(_route('user:profile'));
			}
			$form = $this->_form;

			$form->init([
				'url' => _route('auth:login')
			]);

			$form->customSubmit('Login' , 'submit' , ['class' => 'btn btn-primary btn-sm']);

			$data = [
				'title' => 'Login Page',
				'form'  => $form
			];

			return $this->view('auth/login' , $data);
		}


		public function register() {

			if(isSubmitted()) {
				$post = request()->posts();

				$post['user_type'] = UserService::USER_CUSTOMER;
				
				$post['is_verified'] = false;
				$isOkay = $this->user->save($post);
				if(!$isOkay) {
					Flash::set($this->user->getErrorString(),'danger');
					return request()->return();
				}
				$this->meta->createVerifyUserCode($this->user->retVal['id']);

				$href = URL.DS.'AuthController/code/?action=activate&code='.seal($this->meta->retVal['id']);
				$link = "<a href ='{$href}'> Link </a>";

				$emailContent = " Good day <strong>{$post['firstname']}</strong>,<br/>";
				$emailContent .= " You Recieved this email because you used your email to register on ". COMPANY_NAME .'<br/>';
				$emailContent .= " Verify your registration to enjoy Always new and affordable drug, prices make your hearts healthy too. <br/></br>";
				$emailContent .= " Click this {$link} or use this code to activate your account".$this->meta->retVal['code'];

				$emailBody = wEmailComplete($emailContent);
				_mail($post['email'], 'ACCOUNT VERIFICATION', $emailBody);

				Flash::set("User has been created, verification link and code has been sent to your email '{$post['email']}'");
				return redirect(_route('auth:code'));
			}

			$form = $this->_form;

			$form->init([
				'url' => _route('auth:register')
			]);

			$form->customSubmit('Register' , 'submit' , ['class' => 'btn btn-primary btn-sm']);

			$this->data['form'] = $form;
			return $this->view('auth/register', $this->data);
		}

		public function code() {
			$req = request()->inputs();
			if(isSubmitted()) {
				$code = request()->post('verification_code');
				$codeValue = $this->meta->single([
					'meta_value' => $code
				]);
			}

			if(!empty($req['action']) && !empty($req['code'])) {
				$id = unseal($req['code']);
				$codeValue = $this->meta->get($id);
			}


			if(!empty($codeValue)) {
				if(!$codeValue) {
					Flash::set("Invalid Code");
					return request()->return();
				}

				$this->meta->delete($codeValue->id);

				$isOkay = $this->user->update([
					'is_verified' => true
				], $codeValue->parent_id);

				if($isOkay) {
					Flash::set("Account Verified");
					$this->user->startAuth($codeValue->parent_id);
					return redirect(_route('user:show', $codeValue->parent_id));
				}
			} else {
				Flash::set("Code no longer valid", 'danger');
				return redirect(_route('auth:login'));
			}

			return $this->view('auth/code');
		}
		

		public function logout()
		{
			session_destroy();
			Flash::set("Successfully logged-out");
			return redirect( _route('auth:login') );
		}
	}