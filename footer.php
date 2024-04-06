<div class="sidebar-overlay" data-reff=""></div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- <script src="assets/js/jquery-3.2.1.min.js"></script> -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/Chart.bundle.js"></script>
<script src="assets/js/chart.js"></script>
<script src="assets/js/app.js"></script>
<script src="assets/js/select2.min.js"></script>
<script src="assets/js/moment.min.js"></script>
<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script>
    $(function() {
        $('#datetimepicker3').datetimepicker({
            format: 'LT'

        });
        $('#datetimepicker4').datetimepicker({
            format: 'LT'
        });

        function addActiveClass() {
            const currentUrl = window.location.pathname.substring(1);
            const links = document.querySelectorAll("nav li a");

            for (const link of links) {
                const href = link.getAttribute("href");
                const basename = href.split("/").pop();

                if (basename === currentUrl) {
                    link.parentNode.classList.add("active");
                }
            }
        }

        addActiveClass();
    });
</script>

</body>

</html>