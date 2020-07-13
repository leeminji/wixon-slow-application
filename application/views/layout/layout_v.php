    <?php
        $data['config'] = $_SERVER;
    ?>
    <!DOCTYPE html>
    <html>
    <head>
    <title>PHP Graph Tutorial</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
    <link rel="stylesheet" href="/public/css/style.css" />
    </head>
    <body>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container">
        <a href="/" class="navbar-brand">PHP Graph Tutorial</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="/" class="nav-link">Home</a>
                </li>
                <?php if(isset($userEmail)){ ?>
                <li class="nav-item" data-turbolinks="false">
                    <a href="/calendar" class="nav-link">Calendar</a>
                </li>
                <li class="nav-item" data-turbolinks="false">
                    <a href="/messages" class="nav-link">Messages</a>
                </li>
                <li class="nav-item" data-turbolinks="false">
                    <a href="/MsOneDrive" class="nav-link">MsOneDrive</a>
                </li>
                <?php } ?>
            </ul>
            <ul class="navbar-nav justify-content-end">
                <li class="nav-item">
                    <a class="nav-link" href="https://docs.microsoft.com/graph/overview" target="_blank">
                        <i class="fas fa-external-link-alt mr-1"></i>Docs
                    </a>
                </li>
                <?php if(isset($userEmail)){ ?>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                    aria-haspopup="true" aria-expanded="false">
                    <?php if(isset($user_avatar)){ ?>
                    <img src="<?php echo $user_avatar ?>" class="rounded-circle align-self-center mr-2" style="width: 32px;">
                    <?php }else{ ?>
                    <i class="far fa-user-circle fa-lg rounded-circle align-self-center mr-2" style="width: 32px;"></i>
                    <?php } ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <h5 class="dropdown-item-text mb-0"><?php echo $userName ?></h5>
                    <p class="dropdown-item-text text-muted mb-0"><?php echo $userEmail ?></p>
                    <div class="dropdown-divider"></div>
                    <a href="/sns/ms_auth/signout" class="dropdown-item">Sign Out</a>
                </div>
                </li>
                <?php }else{ ?>
                <li class="nav-item">
                <a href="/sns/ms_auth/signin" class="nav-link">Sign In</a>
                </li>
                <?php } ?>
            </ul>
        </div>
        </div>
    </nav>
    <main role="main" class="container">
        <?php if($this->session->userdata('error')){ ?>
        <div class="alert alert-danger" role="alert">
            <p class="mb-3"><?php echo $this->session->userdata('error') ?></p>
            <?php if($this->session->userdata('errorDetail')){ ?>
            <pre class="alert-pre border bg-light p-2"><code><?php echo $this->session->userdata('errorDetail') ?></code></pre>
            <?php } ?>
        </div>
        <?php } ?>
        <?php if (isset($page)) $this -> load-> view($page, $data); ?>
    </main>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
    </body>
    </html>