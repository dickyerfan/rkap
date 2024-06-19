<button id="btn-up"><i class="fas fa-chevron-circle-up logo"></i></button>
<footer class="py-2 bg-light mt-auto logo">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <!-- <div class="text-muted">Copyright &copy; DIE Art'S Production 2022</div> -->
            <div class="text-muted">Built With <span class="text-danger">&hearts;</span> by DIE Art'S Production 2022</div>
        </div>
    </div>
</footer>
</div>
</div>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="exampleModalLabel">Yakin Mau Logout.?</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">Pilih "Logout" jika anda yakin mau keluar</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Sweetalert2 -->
<script src="<?php echo base_url('assets/'); ?>sweetalert2.all.min.js"></script>

<script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url() ?>assets/js/scripts.js"></script>
<script src="<?= base_url() ?>assets/js/Chart.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url() ?>assets/demo/chart-area-demo.js"></script>
<script src="<?= base_url() ?>assets/demo/chart-bar-demo.js"></script>
<script src="<?= base_url() ?>assets/js/datatables-simple-demo.js"></script>

<!-- datatable bootstrap5 -->
<script src="<?= base_url(); ?>assets/datatables/bootstrap5/jquery-3.5.1.js"></script>
<script src="<?= base_url(); ?>assets/datatables/bootstrap5/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/datatables/bootstrap5/dataTables.bootstrap5.min.js"></script>
<!-- select2 js -->
<script src="<?= base_url() ?>assets/select2/select2.min.js"></script>
<script src="<?= base_url('assets/js/bootstrap-datepicker.js') ?>"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>

<script>
    $('.select2').select2({
        theme: 'bootstrap-5'
    });

    // $(function() {
    //     $('#datepicker').datepicker({
    //         format: 'yyyy-mm-dd',
    //         autoclose: true,
    //         todayHiglight: true,
    //     });
    // });
</script>

<script>
    $('.btn-danger').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        Swal.fire({
            title: 'Yakin mau Di Hapus?',
            text: 'Jika yakin tekan Hapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href;
            }
        })
    })

    $("#btn-up").click(function() {
        $("html,body").animate({
            scrollTop: 0
        }, 500);
    });
</script>
<script>
    $('#belum').on('click', function() {
        $('#tanya').show();
    })
    $('#ambilSaldo').on('click', function() {
        $('#tampilTanggal').show();
    })

    $('#tombol_pilih').on('click', function() {
        $('#tanya').hide();
    })
    $('#tanggalPilih').on('click', function() {
        $('#tampilTanggal').hide();
    })

    $('#cetak').on('click', function() {
        window.print();
    })
</script>
<!-- <script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 5000);
</script> -->

<!-- <script>
    window.setTimeout(function() {
        $( ".alert" ).animate({
    left: "+=50",
    width: "350"
  }, 5000, function() {
  }).fadeTo(1000, 0).slideUp(1000, function(){
            $(this).remove(); 
        });
    }, 1000);
</script> -->

<!-- <script>
    window.setTimeout(function() {
        $(".alert").fadeOut(1000, function() {
            $(this).remove();
        });
    }, 5000); // 5 detik
</script> -->

<script>
    window.setTimeout(function() {
        $(".alert").animate({
            left: "0",
            width: "80%" // Menggunakan persentase lebar agar lebih responsif
        }, 5000, function() {
            // Animasi selesai
        }).fadeTo(1000, 0).slideUp(1000, function() {
            $(this).remove();
        });
    }, 1000);
</script>
<script>
    $(document).ready(function() {
        $('.hapus-link').click(function(event) {
            event.preventDefault();
            var deleteUrl = $(this).attr('href');

            Swal.fire({
                title: 'Konfirmasi Penghapusan',
                text: 'Anda yakin ingin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect ke halaman penghapusan setelah konfirmasi
                    window.location.href = deleteUrl;
                }
            });
        });
    });
</script>

</body>

</html>