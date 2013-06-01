<?php

require_once APP_PATH . DS . 'models/User.php';

if ( !isset( $template->user ) ) {
    header( "Location: /voodoo/error/404.html.php" );
} else {
?>

<html>
<head>
<title>Personal Info Page</title>

    <!-- Link external style sheet-->
    <link rel="stylesheet" href="/voodoo/webroot/css/style.css" type="text/css" />
    <link rel="stylesheet" href="/voodoo/webroot/css/formStyle.css" type="text/css" />

    <!-- link external javascript -->
    <script type="text/javascript" src="/voodoo/webroot/js/jquery.blockUI.js"></script>
    <script type="text/javascript" src="/voodoo/webroot/js/jquery-ui.min.js"></script>
</head>
<body>
    <?php
    include_once '../webroot/include/template/header.php';
    include_once '../webroot/include/template/menu.php';
    include_once '../webroot/include/template/search.php';
?>
    <div id="innerContent">
        <div class="formHeader" style="width: 730px;">
         <h1>Personal Info</h1>
      </div>
        <div id="register">
            <div class="userDetail">
                <label>Email: </label>
                <span><?php echo $template->user->email; ?></span>
            </div>
            <div class="userDetail">
                <label>First Name: </label>
                <span><?php if ( $template->user->fname == NULL ) {
        echo 'N/A';
    } else {
        echo $template->user->fname;
    }?></span>
            </div>
            <div class="userDetail">
                <label>Last Name: </label>
                <span> <?php if ( $template->user->lname == NULL ) {
        echo 'N/A';
    } else {
        echo $template->user->lname;
    }?></span>
            </div>
            <div class="userDetail">
                <label>Street No: </label>
                <span> <?php if ( $template->user->streetNo == NULL ) {
        echo 'N/A';
    } else {
        echo $template->user->streetNo;
    }?></span>
            </div>
            <div class="userDetail">
                <label>Street: </label>
                <span> <?php if ( $template->user->street == NULL ) {
        echo 'N/A';
    } else {
        echo $template->user->street;
    }?></span>
            </div>
            <div class="userDetail">
                <label>Suburb: </label>
                <span> <?php if ( $template->user->suburb == NULL ) {
        echo 'N/A';
    } else {
        echo $template->user->suburb;
    }?></span>
            </div>
            <div class="userDetail">
                <label>State: </label>
                <span> <?php if ( $template->user->state == NULL ) {
        echo 'N/A';
    } else {
        echo $template->user->state;
    }?></span>
            </div>
            <div class="userDetail">
                <label>Postcode: </label>
                <span> <?php if ( $template->user->postcode == NULL ) {
        echo 'N/A';
    } else {
        echo $template->user->postcode;
    }?></span>
            </div>
            <div class="userDetail">
                <label>Phone: </label>
                <span> <?php if ( $template->user->phone == NULL ) {
        echo 'N/A';
    } else {
        echo $template->user->phone;
    }?></span>
            </div>
            <div class="userDetail">
                <label>Date of birth: </label>
                <span> <?php if ( $template->user->dob == NULL ) {
        echo 'N/A';
    } else {
        echo $template->user->dob;
    }?></span>
            </div>
            <div class="wrapper2">
                <div id="btn">
                    <form method="post" action="/voodoo/users/edit" id="editForm">
                        <input type="submit" value="Edit" name="edit" class="button"/>
                    </form>
                </div>
            </div>
        </div>
     </div>
    <?php
}

if ( $_SESSION['updateSuccessful'] == "true" ) {
    unset( $_SESSION['updateSuccessful'] );
?>
        <script type="text/javascript">
            $(document).ready(function() {
            $.growlUI('Voodoo Notification', 'Info updated successfully,
                <?php $name = explode( "@", $_SESSION['user']['email'] );
    echo $name[0];?>');
            });
            </script>
        <?php
}
include_once '../webroot/include/template/footer.php';?>
</body>
</html>
