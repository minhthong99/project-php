<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop - SB Admin</title>
    <base href="http://localhost:8080/basket/">
    <link href="templates/admin/css/custom.css" rel="stylesheet" />
    <link href="templates/admin/css/styles.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" rel="stylesheet" />


    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="templates/admin/js/jquery-1.10.2.js"></script>
    <script src="library/ckeditor/ckeditor.js"></script>
    <script src="library/ckfinder/ckfinder.js"></script>
    <script src="library/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="admin/dashboard/">Shop | Admin </a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">

                <div class="input-group-append">

                </div>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li>
                <a class="nav-link" target="blank" href="http://localhost:8080/basket/" >
                <i class="fas fa-home"></i>
                    <span>Website</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                 
                    <div class="dropdown-divider">
                       
                    </div>
                    <a class="dropdown-item" href="admin/auth/account.php">Chi tiết</a>
                    <a class="dropdown-item" href="admin/auth/logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </nav>