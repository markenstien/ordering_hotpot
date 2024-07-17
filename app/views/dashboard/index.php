<?php build('content')?>

<div class="row">
	<div class="col-md-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
			<div class="d-flex justify-content-between align-items-baseline">
				<h6 class="card-title mb-0">Sales</h6>
			</div>
			<div class="row">
				<div class="col-6 col-md-12 col-xl-5">
					<h3 class="mb-2"><?php echo amountHTML($orderAmountTotal ?? 0)?></h3>
					<div class="d-flex align-items-baseline">
						<p class="text-success">
						<span>Within 30 days</span>
						</p>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>

	<div class="col-md-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
			<div class="d-flex justify-content-between align-items-baseline">
				<h6 class="card-title mb-0">Items</h6>
			</div>
			<div class="row">
				<div class="col-6 col-md-12 col-xl-5">
					<h3 class="mb-2"><?php echo $totalItem?></h3>
					<div class="d-flex align-items-baseline">
						<p class="text-success">
						<span>Item Variants</span>
						</p>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>

	<div class="col-md-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
			<div class="d-flex justify-content-between align-items-baseline">
				<h6 class="card-title mb-0">Staffs</h6>
			</div>
			<div class="row">
				<div class="col-6 col-md-12 col-xl-5">
					<h3 class="mb-2"><?php echo $totalUser?></h3>
					<div class="d-flex align-items-baseline">
						<p class="text-success">
						<span>Active</span>
						</p>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>

<div class="reports">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title text-center">Sales Report</h4>
		</div>

		<div class="card-body">
			<div id="monthlySalesChart"></div>
		</div>

		<div class="card-header">
			<h4 class="card-title text-center">Top 10</h4>
		</div>

		<div class="card-body">
			<div id="top10Pie"></div>
		</div>
	</div>
</div>

<div class="table-resonsive">
	<table class="table table-bordered dataTable">
		<thead>
			<th>Item</th>
			<th>Amount</th>
			<th>Discount</th>
		</thead>

		<tbody>
			<?php foreach($items as $key => $row) :?>
				<tr>
					<td><?php echo $row->item_name?></td>
					<td><?php echo $row->sold_price?></td>
					<td><?php echo $row->discount_price?></td>
				</tr>
			<?php endforeach?>
		</tbody>
	</table>
</div>
<?php endbuild()?>

<?php build('scripts') ?>
	<script src="<?php echo _path_tmp('main-tmp/assets/vendors/apexcharts/apexcharts.min.js')?>"></script>
	<script>
		  var salesPerMonthKeys = ['<?php echo implode("','", array_keys($salesPerMonth))?>'];
		  var salesPerMonthValues = [<?php echo implode(",", array_values($salesPerMonth))?>];

		  var itemstop10Keys = ['<?php echo implode("','", array_keys($top10salesChart))?>'];
		  var itemstop10Values = [<?php echo implode(",", array_values($top10salesChart))?>];
		  
		  var colors = {
			primary        : "#6571ff",
			secondary      : "#7987a1",
			success        : "#05a34a",
			info           : "#66d1d1",
			warning        : "#fbbc06",
			danger         : "#ff3366",
			light          : "#e9ecef",
			dark           : "#060c17",
			muted          : "#7987a1",
			gridBorder     : "rgba(77, 138, 240, .15)",
			bodyColor      : "#000",
			cardBg         : "#fff"
		}

		var fontFamily = "'Roboto', Helvetica, sans-serif"

		// Monthly Sales Chart
		if($('#monthlySalesChart').length) {
			var options = {
			chart: {
				type: 'bar',
				height: '318',
				parentHeightOffset: 0,
				foreColor: colors.bodyColor,
				background: colors.cardBg,
				toolbar: {
				show: false
				},
			},
			theme: {
				mode: 'light'
			},
			tooltip: {
				theme: 'light'
			},
			colors: [colors.primary],  
			fill: {
				opacity: .9
			} , 
			grid: {
				padding: {
				bottom: -4
				},
				borderColor: colors.gridBorder,
				xaxis: {
				lines: {
					show: true
				}
				}
			},
			series: [{
				name: 'Sales',
				data: salesPerMonthValues
			}],
			xaxis: {
				type: 'date',
				categories: salesPerMonthKeys,
				axisBorder: {
				color: colors.gridBorder,
				},
				axisTicks: {
				color: colors.gridBorder,
				},
			},
			yaxis: {
				title: {
				text: 'Number of Sales',
				style:{
					size: 9,
					color: colors.muted
				}
				},
			},
			legend: {
				show: true,
				position: "top",
				horizontalAlign: 'center',
				fontFamily: fontFamily,
				itemMargin: {
				horizontal: 8,
				vertical: 0
				},
			},
			stroke: {
				width: 0
			},
			dataLabels: {
				enabled: true,
				style: {
				fontSize: '10px',
				fontFamily: fontFamily,
				},
				offsetY: -27
			},
			plotOptions: {
				bar: {
				columnWidth: "50%",
				borderRadius: 4,
				dataLabels: {
					position: 'top',
					orientation: 'vertical',
				}
				},
			},
			}
			
			var apexBarChart = new ApexCharts(document.querySelector("#monthlySalesChart"), options);
			apexBarChart.render();
		}
		// Monthly Sales Chart - END

		if ($('#top10Pie').length) {
			var options = {
			chart: {
				height: 300,
				type: "pie",
				foreColor: colors.bodyColor,
				background: colors.cardBg,
				toolbar: {
				show: false
				},
			},
			theme: {
				mode: 'light'
			},
			tooltip: {
				theme: 'light'
			},
			colors: [colors.primary,colors.warning,colors.danger, colors.info],
			legend: {
				show: true,
				position: "top",
				horizontalAlign: 'center',
				fontFamily: fontFamily,
				itemMargin: {
				horizontal: 8,
				vertical: 0
				},
			},
			stroke: {
				colors: ['rgba(0,0,0,0)']
			},
			series: itemstop10Values,
			labels : itemstop10Keys
			};
			
			var chart = new ApexCharts(document.querySelector("#top10Pie"), options);
			chart.render();  
		}

		setInterval(function() {
			let differenceInMinutes = dateDifferenceInMinutes($('#dateTimeToday').html());
			let differenceText = minutesToHours(differenceInMinutes);
			$("#duration").html(differenceText);

			//every 1 sec
		}, 1000);
	</script>
<?php endbuild()?>
<?php loadTo()?>

<?php loadTo()?>