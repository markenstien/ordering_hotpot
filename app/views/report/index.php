<?php build('content') ?>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Report</h4>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-lg">
                    <tr>
                        <td>Sales Report</td>
                        <td><a href="<?php echo _route('report:sales')?>" class="btn btn-primary btn-lg">Prepare</a></td>
                    </tr>

                    <tr>
                        <td>Inventory Report</td>
                        <td><a href="<?php echo _route('report:stocks')?>" class="btn btn-primary btn-lg">Prepare</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
<?php endbuild()?>

<?php loadTo()?>