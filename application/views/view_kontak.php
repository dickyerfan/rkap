<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs d-flex align-items-center" style="background-image: url('assets/img/breadcrumbs-bg.jpg');">
        <div class="container position-relative d-flex flex-column align-items-center" data-aos="fade">
            <!-- <h3 style="font-size: 30px;">Kontak</h3> -->
            <h2>Kontak</h2>
            <ol>
                <li><a href="<?= base_url('publik') ?>">Beranda</a></li>
                <li>Kontak</li>
            </ol>

        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">
                <div class="col-lg-6">
                    <div class="info-item  d-flex flex-column justify-content-center align-items-center">
                        <i class="bi bi-map"></i>
                        <h3>Our Address</h3>
                        <p>Jalan Mastrip No 193 A Bondowoso Jawa Timur 68219</p>
                    </div>
                </div><!-- End Info Item -->

                <div class="col-lg-3 col-md-6">
                    <div class="info-item d-flex flex-column justify-content-center align-items-center">
                        <i class="bi bi-envelope"></i>
                        <h3>Email Us</h3>
                        <p>pdambondowoso@gmail.com</p>
                    </div>
                </div><!-- End Info Item -->

                <div class="col-lg-3 col-md-6">
                    <div class="info-item  d-flex flex-column justify-content-center align-items-center">
                        <i class="bi bi-telephone"></i>
                        <h3>Call Us</h3>
                        <p>(0332) 427017</p>
                    </div>
                </div><!-- End Info Item -->

            </div>

            <div class="row gy-4 mt-1">

                <div class="col-lg-6 ">
                    <!-- <iframe src="https://goo.gl/maps/nNXm4XscSQqcz3z26" frameborder="0"
          style="border:0; width: 100%; height: 384px;" allowfullscreen></iframe> -->
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.6191188948856!2d113.8134776507582!3d-7.934787907717636!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd6c2e149d64cb9%3A0x9356649086292771!2sKantor%20PDAM%20Bondowoso!5e0!3m2!1sid!2sid!4v1687395183080!5m2!1sid!2sid" width="100%" height="384px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div><!-- End Google Maps -->

                <div class="col-lg-6">
                    <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                        </div>
                        <div class="my-3">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your message has been sent. Thank you!</div>
                        </div>
                        <div class="text-center"><button type="submit">Send Message</button></div>
                    </form>
                </div><!-- End Contact Form -->

            </div>

        </div>
    </section><!-- End Contact Section -->

</main><!-- End #main -->