<!DOCTYPE html>
<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4f2c3df144.js" crossorigin="anonymous"></script>
</head>
    <style>

        section {
            margin-top: 80px;
        }

        .card {
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            border: none;
            border-radius: 25px;
        }

        .card .card-header {
            background-color: #f6d365;
            background-image: linear-gradient(315deg, #f6d365 0%, #fda083 74%);
            border-bottom: none;
            color: white;
            font-weight: bold;
            border-radius: 25px 25px 0 0;
        }

        .card .card-body {
            border-top: none;
            padding: 40px 50px;
        }

        .avatar {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
    <title>Édition du Profil Client</title>
</head>

<body>
    <section>
        <div class="container-xl px-4 mt-4">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card mb-4 mb-xl-0">
                        <div class="card-header">Profile Picture</div>
                        <div class="card-body text-center">
                            <img src="https://www.gravatar.com/avatar/<?php echo md5($user[0]['email']); ?>?s=200" alt="Avatar" class="avatar">
                            <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                            <button class="btn btn-primary" type="button">
                                Edit
                                <i class="far fa-upload mb-8" onclick="window.location.href='/profile/edit'" style="cursor:pointer; margin-left:10px"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="card mb-4">
                        <div class="card-header">Account Details</div>
                        <div class="card-body">
                            <form action="/profile/edit_process" method="POST">
                                <div class="mb-3 form-group">
                                    <label class="small mb-1" for="username">Username (how your name will appear to other users on the site)</label>
                                    <input class="form-control <?php if(isset($errors["username"])) { ?> is-invalid <?php } ?> " name="username" id="username" type="text" placeholder="Enter your username" value="<?php echo $user[0]['artist_name']; ?>">
                                    <span class="invalid-feedback"><?php echo $errors["artist_name"] ?? ""; ?></span>
                                </div>
                                <div class="row gx-3 mb-3">
                                    <div class="col-md-6 form-group">
                                        <label class="small mb-1" for="firstname">First name</label>
                                        <input class="form-control <?php if(isset($errors["firstname"])) { ?> is-invalid <?php } ?> " name="firstname" id="firstname" type="text" placeholder="Enter your first name" value="<?php echo $user[0]['name']; ?>">
                                        <span class="invalid-feedback"><?php echo $errors["firstname"] ?? ""; ?></span>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="small mb-1" for="lastname">Last name</label>
                                        <input class="form-control <?php if(isset($errors["lastname"])) { ?> is-invalid <?php } ?> " name="lastname" id="lastname" type="text" placeholder="Enter your last name" value="<?php echo $user[0]['surname']; ?>">
                                        <span class="invalid-feedback"><?php echo $errors["lastname"] ?? ""; ?></span>
                                    </div>
                                </div>
                                <!-- Form Group (email address)-->
                                <div class="mb-3 form-group">
                                    <label class="small mb-1" for="email">Email address</label>
                                    <input class="form-control <?php if(isset($errors["email"])) { ?> is-invalid <?php } ?> " name="email" id="email" type="email" placeholder="Enter your email address" value="<?php echo $user[0]['email']; ?>">
                                    <span class="invalid-feedback"><?php echo $errors["email"] ?? ""; ?></span>
                                </div>
                                <!-- Save changes button-->
                                <button class="btn btn-success" type="submit">
                                    Save
                                    <i class="far fa-check mb-8" style="cursor:pointer; margin-left:10px"></i>
                                </button>                                
                                <button class="btn btn-danger" type="button" style="margin-left:10px"  onclick="window.location.href='/profile'" >
                                    Discard
                                    <i class="far fa-trash mb-8" style="cursor:pointer; margin-left:10px"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>