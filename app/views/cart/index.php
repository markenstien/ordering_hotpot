<?php build('content') ?>
	<div class="container-xxl py-5 bg-dark hero-header mb-5">
		<div class="container my-5 py-5">
			<div class="row align-items-center g-5">
				<div class="col-lg-6 text-center text-lg-start">
					<h1 class="display-3 text-white animated slideInLeft">Cart<br>Overview</h1>
				</div>
				<div class="col-lg-6 text-center text-lg-end overflow-hidden">
					<img class="img-fluid" src="img/hero.png" alt="">
				</div>
			</div>
		</div>
	</div>

	<div class="container-xxl">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Cart Items</h4>
			</div>

			<div class="card-body">
				<?php Flash::show()?>
				<?php if($items) :?>
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<th>#</th>
							<th>Item</th>
							<th>Price</th>
							<th style="width:15%">Quantity</th>
							<th>Amount</th>
							<th>Action</th>
						</thead>

						<tbody>
							<?php $totalAmount = 0?>
							<?php foreach($items as $key => $row) :?>
								<?php $totalAmount += $row->sold_price?>
								<tr>
									<td><?php echo ++$key?></td>
									<td> <img src="<?php echo $row->image->full_url ?? ''?>" alt="" style="width: 50px;"> <?php echo wLinkDefault(_route('home:catalog-view', $row->item_id), $row->name)?></td>
									<td><?php echo amountHTML($row->price, 'PHP')?></td>
									<td><?php echo $row->quantity?></td>
									<td><?php echo amountHTML($row->sold_price, 'PHP')?></td>
									<td>
										<?php echo wLinkDefault(_route('cart:delete', $row->id), 'Delete')?>
									</td>
								</tr>
							<?php endforeach?>
						</tbody>
					</table>
				</div>
				<?php else:?>
					<p>No Cart Items add now here. <?php echo wLinkDefault(_route('home:shop'), 'Show now')?> </p>
				<?php endif?>
			</div>

			<?php if($items) :?>
				<div class="card-footer">
					<div class="row">
						<div class="col-md-6">
							<?php echo wLinkDefault(_route('cart:checkout'), 'Checkout', [
								'class' => 'btn btn-primary btn-lg'
							])?>
						</div>
						<div class="col-md-6" style="text-align:right">
							<h3><?php echo amountHTML($totalAmount)?></h3>
						</div>
					</div>
				</div>
			<?php endif?>
		</div>
	</div>
<?php endbuild()?>
<?php loadTo('tmp/landing')?>