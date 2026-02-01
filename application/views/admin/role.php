<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Role</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <?php if ($user['role_id'] == 1) {
                                echo '<a href="' . base_url('admin') . '">Home</a>';
                            } else {
                                echo '<a href="' . base_url('user') . '">Home</a>';
                            } ?>
                        </li>
                        <li class="breadcrumb-item active">Role</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <button class="btn btn-sm btn-info mb-2" data-toggle="modal" data-target="#roleModal">
                                <i class="fas fa-plus"></i> Add New Role
                            </button>
                            <table id="table-2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Role</th>
                                        <th>Action(s)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($role as $r) : ?>
                                        <tr>
                                            <td>
                                                <?php static $i = 0;
                                                echo ++$i; ?>
                                            </td>
                                            <td><?= $r['role'] ?></td>
                                            <td>
                                                <!-- Always show Role Access button -->
                                                <a href="<?= base_url('admin/roleaccess/') . $r['id']; ?>" class="btn btn-xs btn-info">
                                                    <i class="fas fa-id-card"></i>
                                                </a>

                                                <!-- Edit/Delete available only for non-protected role (id != 1) -->
                                                <?php if ($r['id'] != 1) : ?>
                                                    <button class="btn btn-xs btn-primary btn-edit-role" data-id="<?= $r['id'] ?>" data-role="<?= htmlspecialchars($r['role'], ENT_QUOTES) ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-xs btn-danger btn-delete-role" data-id="<?= $r['id'] ?>" data-role="<?= htmlspecialchars($r['role'], ENT_QUOTES) ?>">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                <?php else : ?>
                                                    <!-- if a non-admin user somehow sees this row, show Protected label -->
                                                    <?php if ($user['role_id'] !== 1) : ?>
                                                        <button class="btn btn-xs btn-danger" disabled>Protected</button>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Role</th>
                                        <th>Action(s)</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/updaterole'); ?>" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Role</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="role_id" value="">
                    <div class="form-group">
                        <label>Role Name</label>
                        <input type="text" class="form-control" name="role" placeholder="Role Name...">
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
<!-- Delete Role Modal -->
<div class="modal fade" id="deleteRoleModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/deleterole'); ?>" method="post">
                <input type="hidden" name="role_id" value="">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Role</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete role <strong class="role-name"></strong>?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.modal -->
<div class="modal fade" id="roleModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Role</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/role'); ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Role Name</label>
                                <input type="text" class="form-control" placeholder="Role Name..." name="role">
                            </div>
                        </div>
                    </div>

                    <!-- textarea -->
                    <!-- <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Textarea</label>
                                <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Textarea Disabled</label>
                                <textarea class="form-control" rows="3" placeholder="Enter ..." disabled></textarea>
                            </div>
                        </div>
                    </div> -->

                    <!-- select -->
                    <!-- <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Select</label>
                                <select class="form-control">
                                    <option>option 1</option>
                                    <option>option 2</option>
                                    <option>option 3</option>
                                    <option>option 4</option>
                                    <option>option 5</option>
                                </select>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->