<div class="jumbotron">
    <h1>PHP Graph Tutorial</h1>
    <p class="lead">This sample app shows how to use the Microsoft Graph API to access a user's data from PHP</p>
    <?php if(isset($userEmail)){ ?>
        <h4>Welcome <?php echo $userName ?></h4>
        <p>Use the navigation bar at the top of the page to get started.</p>
    <?php }else{ ?>
        <a href="/sns/ms_auth" class="btn btn-primary btn-large">Click here to sign in</a>
    <?php } ?>
</div>