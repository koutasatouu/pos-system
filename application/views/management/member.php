<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Member Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Management</li>
                        <li class="breadcrumb-item active">Members</li>
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

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of Registered Members</h3>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMemberModal">
                                <i class="fas fa-user-plus"></i> Add New Member
                            </button>

                            <table id="table-2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Member Code</th>
                                        <th>Name</th>
                                        <th>Phone (WA)</th>
                                        <th>Email</th>
                                        <th>Points</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($members as $m) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><span class="badge badge-info"><?= $m['code']; ?></span></td>
                                            <td><?= htmlspecialchars($m['name']); ?></td>
                                            <td><?= htmlspecialchars($m['phone']); ?></td>
                                            <td><?= htmlspecialchars($m['email']); ?></td>
                                            <td class="text-success font-weight-bold"><?= $m['points']; ?> pts</td>
                                            <td>
                                                <?= $m['is_active'] ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>'; ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-warning btn-edit" data-id="<?= $m['id']; ?>" data-name="<?= htmlspecialchars($m['name'], ENT_QUOTES); ?>" data-phone="<?= htmlspecialchars($m['phone'], ENT_QUOTES); ?>" data-email="<?= htmlspecialchars($m['email'], ENT_QUOTES); ?>" data-is_active="<?= $m['is_active']; ?>" data-toggle="modal" data-target="#editMemberModal">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger btn-delete" data-id="<?= $m['id']; ?>" data-name="<?= htmlspecialchars($m['name'], ENT_QUOTES); ?>" data-toggle="modal" data-target="#deleteMemberModal">
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

<div class="modal fade" id="newMemberModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Register New Member</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('management/member'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Member Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                    </div>
                    <div class="form-group">
                        <label>Phone Number (WhatsApp)</label>
                        <input type="number" class="form-control" name="phone" placeholder="08..." required>
                        <small class="text-muted">Used for identification.</small>
                    </div>
                    <div class="form-group">
                        <label>Email (Optional)</label>
                        <input type="email" class="form-control" name="email" placeholder="example@mail.com">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editMemberModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Member</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('management/member_edit'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="form-group">
                        <label>Member Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="number" class="form-control" id="edit_phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="is_active" id="edit_active">
                            <option value="1">Active</option>
                            <option value="0">Inactive (Ban)</option>
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

<div class="modal fade" id="deleteMemberModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Member</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('management/member_delete'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" id="delete_id">
                    <p>Are you sure you want to delete <strong id="delete_name"></strong>?</p>
                    <small class="text-danger">This will delete their points history as well.</small>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>