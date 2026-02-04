<div class="content-wrapper">
    <style>
        /* Large, stylish profile image */
        .profile-user-img-large {
            width: 220px;
            height: 220px;
            object-fit: cover;
            border: 5px solid #fff;
            /* outline: 4px solid #007bff; */
            outline: 4px solid #c0c0c0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            margin: 0 auto;
            display: block;
            transition: all 0.3s ease;
        }

        .profile-user-img-large:hover {
            transform: scale(1.02);
            /* box-shadow: 0 15px 40px rgba(0, 123, 255, 0.3); */
            box-shadow: 0 15px 40px rgba(128, 128, 128, 0.3);
        }

        .file-upload-container {
            max-width: 220px;
            margin: 0 auto;
        }
    </style>

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
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Customize Your Profile</h3>
                        </div>
                        <?= form_open_multipart('user/edit') ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-5 text-center d-flex flex-column justify-content-center">
                                    <div class="form-group">
                                        <img class="profile-user-img-large img-circle mb-4" src="<?= base_url('assets/img/profile/') . $user['image'] ?>" alt="User profile picture">

                                        <div class="file-upload-container">
                                            <div class="custom-file text-left">
                                                <input type="file" class="custom-file-input" id="image" name="image">
                                                <label class="custom-file-label" for="image">Change Picture</label>
                                            </div>
                                            <small class="text-muted d-block mt-2">Format: jpg, png. Max size: 2MB</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Full Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?= $user['name'] ?>">
                                        <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone_number">Phone Number</label>
                                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?= $user['phone_number'] ?>" placeholder="e.g. 08123456789">
                                        <?= form_error('phone_number', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="about">About Me</label>
                                        <textarea class="form-control" id="about" name="about" rows="4" placeholder="Tell us a little about yourself..."><?= $user['about'] ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="<?= base_url('user') ?>" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary pl-4 pr-4">Save Changes</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>