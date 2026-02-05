<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active">User Management</li>
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
                            <h3 class="card-title">Registered Users List</h3>
                        </div>
                        <div class="card-body">
                            <table id="table-2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($all_users as $u) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= htmlspecialchars($u['name']) ?></td>
                                            <td><?= htmlspecialchars($u['email']) ?></td>
                                            <td>
                                                <?= $u['role_id'] == 1 ? '<span class="badge badge-primary">Admin</span>' : '<span class="badge badge-secondary">Member</span>'; ?>
                                            </td>
                                            <td>
                                                <?= $u['is_active'] == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>'; ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-xs btn-primary btn-edit-user" data-id="<?= $u['id']; ?>" data-role="<?= $u['role_id']; ?>" data-active="<?= $u['is_active']; ?>" data-toggle="modal" data-target="#editUserModal">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <button class="btn btn-xs btn-danger btn-delete-user" data-id="<?= $u['id']; ?>" data-name="<?= htmlspecialchars($u['name'], ENT_QUOTES); ?>" data-toggle="modal" data-target="#deleteUserModal">
                                                    <i class="fas fa-trash-alt"></i>
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

<div class="modal fade" id="editUserModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit User Access</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/edituser'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">

                    <div class="form-group">
                        <label>Role</label>
                        <select name="role_id" id="edit_role" class="form-control">
                            <option value="1">Administrator</option>
                            <option value="2">Member</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Active Status</label>
                        <select name="is_active" id="edit_active" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteUserModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/deleteuser'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" id="delete_id">
                    <p>Are you sure you want to delete user <strong id="delete_name"></strong>?</p>
                    <small class="text-danger">This action cannot be undone.</small>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>