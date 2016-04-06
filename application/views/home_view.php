<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url('assets/favicon-32x32.png') ?>">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Home</title>

        <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/navbar.css') ?>" rel="stylesheet">

    </head>
    <body>

        <div class="container">

            <!-- Static navbar -->
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">                        
                        <a class="navbar-brand" href="#">Billionaire</a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <?php $class = strtolower($this->router->fetch_class()); ?>
                            <li class="<?php echo $class == 'home' ? 'active' : '' ?>">
                                <a href="<?php echo base_url('home') ?>">Home</a>
                            </li>
                            <li class="<?php echo $class == 'event' ? 'active' : '' ?>">
                                <a href="<?php echo base_url('event') ?>">Event</a>
                            </li>
                            <li class="<?php echo $class == 'event_dev' ? 'active' : '' ?>">
                                <a href="<?php echo base_url('event_dev') ?>">Event Dev</a>
                            </li>
                            <li class="<?php echo $class == 'user' ? 'active' : '' ?>">
                                <a href="<?php echo base_url('user') ?>">User</a>
                            </li>
                            <li class="<?php echo $class == 'user_dev' ? 'active' : '' ?>">
                                <a href="<?php echo base_url('user_dev') ?>">User Dev</a>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="<?php echo base_url('signin/out') ?>">Signout</a></li>
                        </ul>                        
                    </div><!--/.nav-collapse -->
                </div><!--/.container-fluid -->
            </nav>

            <h3>Home</h3>

        </div>

        <script src="<?php echo base_url('assets/jquery/jquery-2.2.2.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>

    </body>
</html>