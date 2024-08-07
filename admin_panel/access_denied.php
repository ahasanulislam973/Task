<?php
session_start();
require_once './config/config.php';
$pageTitle = 'Access Denied';
include_once INCLUDE_DIR . 'header.php';
?>
    <section id="main-content">
        <section class="wrapper site-min-height">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="alert alert-danger">
                        <h2>
                            <strong>
                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                Permission Denied !!
                            </strong>
                        </h2>
                        <h3><?php echo ACCESS_DENIED_MSG; ?></h3>
                    </div>
                </div>
            </div>
        </section>
    </section>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>