<?php build('content') ?>
	<?php Flash::show()?>
	<div class="row">
		<div class="col-md-4">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">User Preview</h4>
					<?php echo wLinkDefault(_route('user:edit', $user->id), 'Edit User', [
						'icon' => 'edit'
					])?>
				</div>

				<div class="card-body">
					<div><img src="<?php echo $user->profile?>" style="width: 150px;"></div>
					<span class="badge badge-primary">USERID : #<?php echo $user->user_identification?></span>
					<div class="table-responsive">
						<table class="table table-bordered">
							<tr>
								<td style="width:35%">Name</td>
								<td><?php echo $user->lastname . ',' . $user->firstname?></td>
							</tr>
							<tr>
								<td style="width:35%">Gender</td>
								<td><?php echo $user->gender?></td>
							</tr>
							<tr>
								<td style="width:35%">Email</td>
								<td><?php echo $user->email?></td>
							</tr>
							<?php if(!empty($user->phone)) :?>
							<tr>
								<td style="width:35%">Phone</td>
								<td><?php echo $user->phone?></td>
							</tr>
							<?php endif?>

							<?php if(!empty($user->address)) :?>
							<tr>
								<td style="width:35%">Address</td>
								<td><?php echo $user->address?></td>
							</tr>
							<?php endif?>
						</table>
					</div>
				</div>
			</div>	
		</div>

		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Order History</h4>
				</div>

				<div class="card-body">
					<?php if(isEqual(whoIs('user_type'),['admin','staff']) || isEqual(whoIs('id'), $id)) :?>
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<th>#</th>
								<th>Reference</th>
								<th>Date</th>
								<th>Total</th>
								<th>Payment</th>
								<th>Action</th>
							</thead>

							<tbody>
								<?php foreach($orders as $key => $row) :?>
									<tr>
										<td><?php echo ++$key?></td>
										<td><?php echo $row->reference?></td>
										<td><?php echo $row->created_at?></td>
										<td><?php echo amountHTML($row->net_amount)?></td>
										<td>
											<?php
												$color = 'danger';
												$text  = 'Unpaid';
												if($row->is_paid) {
													$color = 'success';
													$text = 'Paid';
												}

												echo wBadgeWrap($text, $color);
											?>
										</td>
										<td>
											<?php echo wLinkDefault(_route('receipt:order', $row->id), ' Show Order');?>
										</td>
									</tr>
								<?php endforeach?>
							</tbody>
						</table>
					</div>
					<?php else:?>
						<p>Order History is set to private</p>
					<?php endif?>
				</div>
			</div>
		</div>
	</div>


<?php endbuild()?>
<?php loadTo()?>