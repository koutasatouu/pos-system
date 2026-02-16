<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Stock In (Purchasing)</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <form action="<?= base_url('purchase/process') ?>" method="post">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Invoice Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Invoice Number</label>
                                    <input type="text" name="invoice_no" class="form-control" value="<?= $invoice_no; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" name="date" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Supplier</label>
                                    <select name="supplier_id" class="form-control" required>
                                        <option value="">-- Select Supplier --</option>
                                        <?php foreach ($suppliers as $s) : ?>
                                            <option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Items to Restock</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-success btn-sm" id="add-row">
                                <i class="fas fa-plus"></i> Add Item
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="40%">Ingredient</th>
                                    <th>Unit</th>
                                    <th>Qty</th>
                                    <th>Price per Unit (Rp)</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="cart-table">
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Grand Total:</strong></td>
                                    <td><strong id="grand-total">0</strong></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right">
                            <i class="fas fa-save"></i> Save & Update Stock
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </section>
</div>