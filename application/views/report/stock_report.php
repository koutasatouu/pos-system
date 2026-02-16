<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Stock Asset Report</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>Rp <?= number_format($total_asset_value, 0, ',', '.'); ?></h3>
                            <p>Total Inventory Value</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Inventory Status</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table-1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Ingredient</th>
                                <th>Current Stock</th>
                                <th>Cost per Unit</th>
                                <th>Asset Value</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($stocks as $s) : ?>
                                <?php
                                $asset_val = $s['current_stock'] * $s['cost_per_unit'];
                                $is_low = $s['current_stock'] <= $s['min_stock'];
                                ?>
                                <tr class="<?= $is_low ? 'table-danger' : ''; ?>">
                                    <td><?= $s['name']; ?></td>
                                    <td>
                                        <strong><?= $s['current_stock'] + 0; ?></strong> <?= $s['unit']; ?>
                                    </td>
                                    <td>Rp <?= number_format($s['cost_per_unit'], 0, ',', '.'); ?></td>
                                    <td class="font-weight-bold">Rp <?= number_format($asset_val, 0, ',', '.'); ?></td>
                                    <td class="text-center">
                                        <?php if ($is_low) : ?>
                                            <span class="badge badge-danger">LOW STOCK</span>
                                        <?php else : ?>
                                            <span class="badge badge-success">OK</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>