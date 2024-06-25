<?php build('content')?>
	<?php Flash::show()?>
	<div class="row">
		<div class="col-md-7">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Reservation Preview</h4>
				</div>

				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered">
							<tr>
								<td><?php echo $_form->label('guest_name')?></td>
								<td><?php echo $appointment->guest_name?></td>
							</tr>
							<tr>
								<td><?php echo $_form->label('date')?></td>
								<td><?php echo $appointment->date?></td>
							</tr>
							<tr>
								<td><?php echo $_form->label('start_time')?></td>
								<td><?php echo date('h:i:s A', strtotime($appointment->start_time))?></td>
							</tr>

							<tr>
								<td><?php echo $_form->label('guest_email')?></td>
								<td><?php echo $appointment->guest_email?></td>
							</tr>

							<tr>
								<td><?php echo $_form->label('guest_phone')?></td>
								<td><?php echo $appointment->guest_phone?></td>
							</tr>
							
							<tr>
								<td>Notes</td>
								<td><?php echo $appointment->notes?></td>
							</tr>
							<tr>
								<td>Status</td>
								<td>
									<?php $statusColor = '';
										switch($appointment->status) {
											case 'arrived':
												$statusColor = 'success';
											break;

											case 'pending':
												$statusColor = 'warning';
											break;

											case 'cancelled':
												$statusColor = 'danger';
											break;
										}
									?>
									<?php echo wSpanBuilder($appointment->status, 'success')?>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="card-footer">
					<?php if(isEqual($appointment->status, ['pending', 'scheduled'])) :?>
						<a href="<?php echo _route('appointment:approve', $appointment->id)?>" class="btn btn-primary btn-lg">Arrived</a>
						<a href="<?php echo _route('appointment:cancel', $appointment->id)?>" class="btn btn-danger btn-lg">Cancelled</a>
					<?php endif?>
				</div>
			</div>
		</div>
	</div>
<?php endbuild()?>
<?php loadTo()?>