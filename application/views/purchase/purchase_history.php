<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Stock In History</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Transaction</li>
                        <li class="breadcrumb-item active">Stock In History</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of Supplier Invoices</h3>
                            <div class="card-tools">
                                <a href="<?= base_url('purchase') ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> New Stock In
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="table-2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice No</th>
                                        <th>Date</th>
                                        <th>Supplier</th>
                                        <th>Total Cost</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($purchases as $p) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><span class="badge badge-info"><?= $p['invoice_no']; ?></span></td>
                                            <td><?= date('d M Y', strtotime($p['date'])); ?></td>
                                            <td><?= $p['supplier_name']; ?></td>
                                            <td class="font-weight-bold">Rp <?= number_format($p['total_cost'], 0, ',', '.'); ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-secondary btn-detail" data-id="<?= $p['id']; ?>" data-invoice="<?= $p['invoice_no']; ?>" data-toggle="modal" data-target="#detailModal">
                                                    <i class="fas fa-eye"></i> View Items
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="detailModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Invoice Details: <span id="modal-invoice"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>Ingredient</th>
                            <th>Qty Added</th>
                            <th>Subtotal Cost</th>
                        </tr>
                    </thead>
                    <tbody id="modal-items">
                        <tr>
                            <td colspan="3" class="text-center">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>