<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Management</li>
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?php if (validation_errors()) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= validation_errors(); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $error; ?>
                        </div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of Menu Items</h3>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#newProductModal">
                                <i class="fas fa-plus"></i> Add New Product
                            </button>

                            <table id="table-2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Image</th>
                                        <th>Code</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Price (Rp)</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($products as $p) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td>
                                                <img src="<?= base_url('assets/img/product/') . $p['image']; ?>" class="img-thumbnail" width="50">
                                            </td>
                                            <td><span class="badge badge-info"><?= $p['code']; ?></span></td>
                                            <td><?= htmlspecialchars($p['name']); ?></td>
                                            <td><?= htmlspecialchars($p['category_name']); ?></td>
                                            <td><?= number_format($p['price'], 0, ',', '.'); ?></td>
                                            <td>
                                                <?= $p['is_available'] ? '<span class="badge badge-success">Available</span>' : '<span class="badge badge-danger">Sold Out</span>'; ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-warning btn-edit" data-id="<?= $p['id']; ?>" data-name="<?= htmlspecialchars($p['name'], ENT_QUOTES); ?>" data-price="<?= $p['price']; ?>" data-category="<?= $p['category_id']; ?>" data-available="<?= $p['is_available']; ?>" data-toggle="modal" data-target="#editProductModal">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger btn-delete" data-id="<?= $p['id']; ?>" data-name="<?= htmlspecialchars($p['name'], ENT_QUOTES); ?>" data-toggle="modal" data-target="#deleteProductModal">
                                                    <i class="fas fa-trash"></i>
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

<div class="modal fade" id="newProductModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Product</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('management/product'); ?>
            <div class="modal-body">
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" class="form-control" name="name" placeholder="e.g. Kopi Susu Gula Aren" required>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" name="category_id" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $c) : ?>
                                    <option value="<?= $c['id']; ?>"><?= $c['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" class="form-control" name="price" placeholder="15000" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Image</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image" required>
                        <label class="custom-file-label" for="image">Choose file</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="is_available" name="is_available" value="1" checked>
                        <label for="is_available" class="custom-control-label">Available for Sale</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editProductModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Product</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('management/product_edit'); ?>
            <div class="modal-body">
                <input type="hidden" name="id" id="edit_id">
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" class="form-control" id="edit_name" name="name" required>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" id="edit_category" name="category_id" required>
                                <?php foreach ($categories as $c) : ?>
                                    <option value="<?= $c['id']; ?>"><?= $c['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" class="form-control" id="edit_price" name="price" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Image (Leave empty to keep current)</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="edit_image" name="image">
                        <label class="custom-file-label" for="edit_image">Choose file</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="is_available" id="edit_available">
                        <option value="1">Available</option>
                        <option value="0">Sold Out</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteProductModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Product</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('management/product_delete'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" id="delete_id">
                    <p>Are you sure you want to delete <strong id="delete_name"></strong>?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>