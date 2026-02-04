<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Change Password</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('user') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- left column -->
        <div class="col-md-4">
            <!-- general form elements -->
            <div class="card card-primary card-outline">
                <!-- /.card-header -->
                <!-- form start -->
                <?= form_open('user/changePassword') ?>
                <div class="card-body">
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter current password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password1">New Password</label>
                        <input type="password" class="form-control" id="new_password1" name="new_password1" placeholder="Enter new password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password2">Confirm New Password</label>
                        <input type="password" class="form-control" id="new_password2" name="new_password2" placeholder="Confirm new password" required>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
                </form>
            </div>
            <!-- /.card -->

        </div>
        <!--/.col (left) -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->