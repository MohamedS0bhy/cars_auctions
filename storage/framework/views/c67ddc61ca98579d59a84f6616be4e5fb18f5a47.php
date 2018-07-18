<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Auction</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>">
</head>
<body onload="">

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
                
                <li><a href="<?php echo e(url('/new/auction')); ?>">Add Auction</a></li>
                
            </ul>
            <ul class="nav navbar-nav navbar-right">
                    <li><a href="#" onclick="event.preventDefault();logout()">Logout</a></li>
            </ul>
            
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <?php if(\Session::has('success')): ?>
    <div class="alert alert-success">
        <ul>
            <li><?php echo \Session::get('success'); ?></li>
        </ul>
    </div>
    <?php endif; ?>

    <?php if(\Session::has('failed')): ?>
    <div class="alert alert-danger">
        <ul>
            <li><?php echo \Session::get('failed'); ?></li>
        </ul>
    </div>
    <?php endif; ?>
    <?php if(count($errors) > 0): ?>
    <div class="alert alert-danger">
      <strong>Whoops!</strong> There were some problems with your input.<br><br>
      <ul>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($i .' '. $error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
    <?php endif; ?>
    
    <div style="display:none" class="alert alert-danger" id="dangerMessage"></div>
    <div style="display:none" class="alert alert-success" id="successMessage"></div>

    <div class="container">
        <div class="row" id="newAuction">

            <form action="<?php echo e(url('/new/auction')); ?>"  method="POST" class="form-horizontal" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for="carName" class="col-sm-3 control-label">Car Name</label>
                    <div class="col-sm-9">
                        <input type="text" name="car_name" value="<?php echo e(old('car_name')); ?>" class="form-control" id="carName" required>
                    </div>
                </div>
                    
                <div class="form-group">
                    <label for="carPrice" class="col-sm-3 control-label">Price</label>

                    <div class="col-sm-9">
                    <input type="text" name="price" value="<?php echo e(old('price')); ?>" class="form-control" id="carPrice" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="startBidAmount" class="col-sm-3 control-label">Start Bid</label>

                    <div class="col-sm-9">
                    <input type="text" name="start_bid_amount" value="<?php echo e(old('start_bid_amount')); ?>" class="form-control" id="startBidAmount" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="location" class="col-sm-3 control-label">Location</label>

                    <div class="col-sm-9">
                    <input type="text" name="location" value="<?php echo e(old('location')); ?>"  class="form-control" id="location" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="startBidDate" class="col-sm-3 control-label">Start Bid Date</label>

                    <div class="col-sm-9">
                    <input type="date" name="start_bid_date" value="<?php echo e(old('start_bid_date')); ?>"  class="form-control" id="startBidDate" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="endBidDate" class="col-sm-3 control-label">End Bid Date</label>

                    <div class="col-sm-9">
                    <input type="date" name="end_bid_date" value="<?php echo e(old('end_bid_date')); ?>"  class="form-control" id="endBidDate" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="carPics" class="col-sm-3 control-label">Pictures</label>

                    <div class="col-sm-9">
                    <input type="file" name="pics[]" multiple  class="btn btn-file" id="carPics" >
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-lg btn-info" style="padding-left:30px;padding-right: 30px;">Add</button>
                    </div>
                </div>
            </form>
        
        </div>
    </div>

    <script src="<?php echo e(asset('js/jquery-3.1.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery.cookie.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('js/custom.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('js/home.js')); ?>" type="text/javascript"></script>

</body>
</html>