<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Items</h4>
            <?php echo wLinkDefault(_route('item:create'), 'Add Item')?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered dataTable">
                    <thead>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Product Code</th>
                        <th>Category</th>
                        <th>Sell Price</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </thead>

                    <tbody>
                        <?php foreach($items as $key => $row) :?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <td><?php echo isset($row->image->full_url) ? "<img src='{$row->image->full_url}'/>" : ''?></td>
                                <td><?php echo $row->name?></td>
                                <td><?php echo $row->sku?></td>
                                <td><?php echo $row->category_name?></td>
                                <td><?php echo amountHTML($row->sell_price)?></td>
                                <td><?php echo $row->total_stock?></td>
                                <td>
                                    <?php 
                                        $anchor_items = [
                                            [
                                                'url' => _route('item:show' , $row->id),
                                                'text' => 'View',
                                                'icon' => 'eye'
                                            ],

                                            [
                                                'url' => _route('item:edit' , $row->id),
                                                'text' => 'Edit',
                                                'icon' => 'edit'
                                            ]
                                        ];
                                    echo anchorList($anchor_items)?>
                                </td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>