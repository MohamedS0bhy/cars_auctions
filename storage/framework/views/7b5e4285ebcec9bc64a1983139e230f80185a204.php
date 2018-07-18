<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Auction Details</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>">
</head>
<body onload="getAuctionDetails(<?php echo e($id); ?>)">

        <nav class="navbar navbar-default">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo e(url('/')); ?>">Cars Auctions</a>
                </div>
            
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    
                    
                </ul>
                <ul class="nav navbar-nav navbar-right">
                        <li><a href="#" onclick="event.preventDefault();logout()">Logout</a></li>
                </ul>
                
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>

        <div style="display:none" class="alert alert-danger" id="dangerMessage"></div>
        <div style="display:none" class="alert alert-success" id="successMessage"></div>

              


        <div class="container">
            <div class="row" id="auctionDetails">

            </div>
        </div>

    <script src="<?php echo e(asset('js/jquery-3.1.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery.cookie.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('js/custom.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('js/home.js')); ?>" type="text/javascript"></script>
</body>
</html>