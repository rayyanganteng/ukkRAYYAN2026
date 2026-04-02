<!-- Footer -->
    <footer class="app-footer">
        <strong>&copy; 2026 Website Profil Sekolah</strong>
    </footer>
</div>
<!-- /.app-wrapper -->

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
<script src="./assets/dist/js/adminlte.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebarWrapper = document.querySelector('.sidebar-wrapper');
    if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars) {
        OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
                theme: 'os-theme-light',
                autoHide: 'leave',
                clickScroll: true,
            },
        });
    }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>