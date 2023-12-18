<!DOCTYPE html>
<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4f2c3df144.js" crossorigin="anonymous"></script>
</head>
<style>

    section {
        padding: 50px 0 0 0;
    }

    .card {
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
    }

    .avatar {
        object-fit: cover;
        border-radius: 50%;
    }

    .gradient-custom {
        /* fallback for old browsers */
        background: #f6d365;

        /* Chrome 10-25, Safari 5.1-6 */
        background: -webkit-linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1));

        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        background: linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1))
    }
</style>

<body>
    <?php //$user: array(1) { [0]=> array(7) { ["id"]=> int(1) ["surname"]=> string(6) "samsam" ["name"]=> string(3) "del" ["artist_name"]=> string(7) "Unknown" ["email"]=> string(24) "samuel.deliens@gmail.com" ["password"]=> string(60) "$2y$10$5U3prZxFC62jZlI5jUSJzO9u0zi8q2lanZqkk0d9EPz2mnf35idwu" ["created_at"]=> string(19) "2023-12-17 21:25:58" } }
    ?>
    <section>
        <div class="container">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2>Profile</h2>
                        <hr class="divider">
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <div class="card mb-3" style="border-radius: .5rem; border: none">
                        <div class="row g-0">
                            <div class="col-md-4 gradient-custom text-center text-white"
                                style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                <img src="https://www.gravatar.com/avatar/<?php echo md5($user[0]['email']); ?>?s=200"
                                    alt="Avatar" class="img-fluid my-5 avatar" style="width: 150px;" />
                                <h5><?php echo $user[0]['name'] . ' ' . $user[0]['surname']; ?></h5>
                                <p><?php echo $user[0]['artist_name']; ?></p>
                                <i class="far fa-edit mb-8" onclick="window.location.href='/profile/edit'" style="cursor:pointer"></i>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body p-4">
                                    <h6>Information</h6>
                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <div class="col-6 mb-3">
                                            <h6>Email</h6>
                                            <p class="text-muted"><?php echo $user[0]['email']; ?></p>
                                        </div>
                                        <!-- Add more information as needed -->
                                    </div>
                                    <h6>Password</h6>
                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <div class="col-12 mb-3">
                                            <p class="text-muted"><?php echo $user[0]['password']; ?></p>
                                        </div>
                                    </div>
                                    <h6>Date de création</h6>
                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <div class="col-12 mb-3">
                                            <p class="text-muted"><?php echo $user[0]['created_at']; ?></p>
                                        </div>
                                    </div>
                                    <h6>Musics Upload</h6>
                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <div class="col-12">
                                            <p class="text-muted"><?php echo count($user_music); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (isset($_SESSION['success'])) { ?>
            <div class="container text-center text-success">
                <?php echo $_SESSION['success']; ?>
                <i class="fas fa-check-circle"></i>
            </div>
            <?php }?>
        </div>
    </section>
</body>