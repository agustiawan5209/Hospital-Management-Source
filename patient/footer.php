<div class="sidebar-overlay" data-reff=""></div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- <script src="<?= BASE_URL ?>/assets/js/jquery-3.2.1.min.js"></script> -->
<script src="<?= BASE_URL ?>/assets/js/popper.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/bootstrap.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/jquery.dataTables.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/jquery.slimscroll.js"></script>
<script src="<?= BASE_URL ?>/assets/js/Chart.bundle.js"></script>
<script src="<?= BASE_URL ?>/assets/js/chart.js"></script>
<script src="<?= BASE_URL ?>/assets/js/app.js"></script>
<script src="<?= BASE_URL ?>/assets/js/select2.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/moment.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>


<script>
    $(function() {
        $('#datetimepicker3').datetimepicker({
            format: 'LT'

        });
        $('#datetimepicker4').datetimepicker({
            format: 'LT'
        });

        function addActiveClass() {
            const currentUrl = window.location.pathname.replace(/patient\//, "");;
            const links = document.querySelectorAll("nav li a");

            for (const link of links) {
                const href = link.getAttribute("href");
                const basename = '/' + href.split("/").pop();
                if (basename === currentUrl) {
                    link.parentNode.classList.add("active");
                }
            }
        }

        addActiveClass();


    });
    <?php
    if (isset($_SESSION['message'])) {
    ?>
        swal({
            title: "Wow!",
            text: <?= "'" . $_SESSION['message'] . "'" ?>,
            type: "success"
        }).then(okay => {
            if (okay) {
                <?php unset($_SESSION['message']); ?>
            }
        });
    <?php
    }
    ?>
</script>

</body>

</html>