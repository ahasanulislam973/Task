<!--footer start-->
<footer class="site-footer">
    <div class="text-center">
        <?php
        echo COPYRIGHT_TEXT; ?>
        <a href="#" class="go-top">
            <i class="fa fa-angle-up"></i>
        </a>
    </div>
</footer>
<!--footer end-->

</section>

<!-- js placed at the end of the document so the pages load faster -->

<script class="include" type="text/javascript"
        src="<?php echo baseUrl('assets/js/jquery.dcjqaccordion.2.7.js'); ?>"></script>
<script src="<?php echo baseUrl('assets/js/jquery.scrollTo.min.js'); ?>"></script>
<script src="<?php echo baseUrl('assets/js/jquery.nicescroll.js'); ?>" type="text/javascript"></script>
<script src="<?php echo baseUrl('assets/js/jquery.sparkline.js'); ?>" type="text/javascript"></script>
<script src="<?php echo baseUrl('assets/js/jquery-easy-pie-chart/jquery.easy-pie-chart.js'); ?>"></script>
<script src="<?php echo baseUrl('assets/js/owl.carousel.js'); ?>"></script>
<script src="<?php echo baseUrl('assets/js/jquery.customSelect.min.js'); ?>"></script>
<script src="<?php echo baseUrl('assets/js/respond.min.js'); ?>"></script>

<!--right slidebar-->
<script src="<?php echo baseUrl('assets/js/slidebars.min.js'); ?>"></script>

<!--common script for all pages-->
<script src="<?php echo baseUrl('assets/js/common-scripts.js'); ?>"></script>

<!--script for this page-->
<script src="<?php echo baseUrl('assets/js/sparkline-chart.js'); ?>"></script>
<script src="<?php echo baseUrl('assets/js/easy-pie-chart.js'); ?>"></script>
<script src="<?php echo baseUrl('assets/js/count.js'); ?>"></script>

<script src="<?php echo baseUrl('assets/dashboard-table/js/respond.js'); ?>"></script>

<script>

    //owl carousel
    $(document).ready(function () {
        $("#owl-demo").owlCarousel({
            navigation: true,
            slideSpeed: 300,
            paginationSpeed: 400,
            singleItem: true,
            autoPlay: true

        });
    });

    //custom select box
    $(function () {
        $('select.styled').customSelect();
    });

    /*$(window).on("resize", function () {
        var owl = $("#owl-demo").data("owlCarousel");
        owl.reinit();
    });*/

</script>
<?php ob_end_flush(); ?>
</body>
</html>