            </main> <!-- End Main Content -->
        </div> <!-- End page-container -->
    </div> <!-- End d-flex -->

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?= base_url('js/app.js?v=4.0') ?>"></script>

    <script>
        // SweetAlert2 for flash messages
        <?php if (session()->getFlashdata('success')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= session()->getFlashdata('success') ?>',
                showConfirmButton: false,
                timer: 1800
            });
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')) : ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '<?= session()->getFlashdata('error') ?>',
                showConfirmButton: true,
            });
        <?php endif; ?>
        <?php if (session()->getFlashdata('msg')) : ?>
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                text: '<?= session()->getFlashdata('msg') ?>',
                showConfirmButton: false,
                timer: 1800
            });
        <?php endif; ?>
    </script>

</body>
</html>