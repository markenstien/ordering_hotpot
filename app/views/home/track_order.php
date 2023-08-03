<?php build('content') ?>
	<div class="container" style="padding: 50px 0px;">
		<div class="col-md-5 mx-auto">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Enter your Order Number</h4>
				</div>

				<div class="card-body">
					<?php Flash::show()?>
					<?php Form::open(['method' => 'post'])?>
						<div class="form-group">
							<?php
								Form::label('Order #');
								Form::text('order_number', '', [
									'class' => 'form-control',
									'required' => true
								])
							?>
						</div>

						<div class="form-group mt-2">
							<?php Form::submit('', 'Search')?>
						</div>
					<?php Form::close()?>
				</div>
			</div>
		</div>
	</div>
<?php endbuild()?>
<?php loadTo('tmp/landing')?>