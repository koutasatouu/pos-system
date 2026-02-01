<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('user') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Edit Profile</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- left column -->
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Quick Example</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <?= form_open_multipart('user/edit') ?>
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center mt-5">
                            <img class="profile-user-img img-fluid img-circle" src="<?= base_url('assets/img/profile/') . $user['image'] ?>" alt="User profile picture">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>" placeholder="Enter email" readonly>
                            </div>
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="name" class="form-control" id="name" name="name" value="<?= $user['name'] ?>" placeholder="Full Name">
                            </div>
                            <div class="form-group">
                                <label for="image">File input</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
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