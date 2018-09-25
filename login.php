<?php
    session_start();
    if (isset($_SESSION['username'])) {
        header("location:index.php");
    }

    include_once('includes/config.php');
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Bootstrap Material Design">
        <meta name="keywords" content="Bootstrap Material Design, Sass">
        <meta name="author" content="Federico Zivolo, Kevin Ross, and Bootstrap Material Design contributors">

        <title><?php echo COMPANYNAME ; ?> &middot; WITS</title>

        <style>
            .form-signin {
                max-width: 25rem;
                margin: auto;
                padding-top: 100px;
            }
        </style>


        <!-- Material Design fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

        <!-- Bootstrap Material Design -->
        <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
        
        <!-- Custom styles for this template -->
        <link href="css/landing.css" rel="stylesheet" type="text/css" />

    </head>

    <body>

        <div class="container">

            <form class="form-signin m-x-auto" name="form1" method="post" action="checklogin.php">
                <h3 class="companyName"><?php echo COMPANYNAME ; ?> &middot; WITS</h3>
                <div class="form-group">
                    <label for="myusername" class="bmd-label-floating">Username</label>
                    <input name="myusername" id="myusername" type="text" class="form-control" autofocus>
                </div>
                <div class="form-group">
                    <label for="mypassword" class="bmd-label-floating">Password</label>
                    <input name="mypassword" id="mypassword" type="password" class="form-control">
                </div>

                <button name="Submit" id="submit" class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            </form>

        </div>


        <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
        <script src="https://cdn.rawgit.com/HubSpot/tether/v1.3.4/dist/js/tether.min.js"></script>
        <script src="https://cdn.rawgit.com/FezVrasta/snackbarjs/1.1.0/dist/snackbar.min.js"></script>
        <script src="/bootstrap-material-design/dist/bootstrap-material-design.iife.min.js"></script>


        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="https://maxcdn.bootstrapcdn.com/js/ie10-viewport-bug-workaround.js"></script>

        <script>
            $(function () {
                $('body').bootstrapMaterialDesign();
            })
        </script>



        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="js/jquery-2.2.4.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script type="text/javascript" src="js/bootstrap.js"></script>
        <!-- The AJAX login script -->
        <script src="js/login.js"></script>

    </body>

    </html>