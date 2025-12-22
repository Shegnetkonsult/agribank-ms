<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank of Agriculture - Home</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Header -->
    <header class="bg-success text-white">
        <nav class="navbar navbar-expand-lg navbar-light container">
            <a class="navbar-brand" href="#">
                <img src="img/logo.png" alt="Bank of Agriculture Logo" class="logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link text-white" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#about">About Us</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#contact">Contact</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="create_account.html">Register</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero text-center text-white d-flex justify-content-center align-items-center">
        <div>
            <h1>Welcome to Bank of Agriculture</h1>
            <p>Your Partner in Agricultural Growth and Financial Stability</p>
            <a href="log_in.html" class="btn btn-primary">Log In</a>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="container py-5">
        <h2 class="text-center">About Us</h2>
        <p>Bank of Agriculture (BOA) is dedicated to supporting the agricultural sector with tailored financial products and services. Our mission is to empower farmers and agribusinesses to achieve sustainable growth and success.</p>
    </section>

    <!-- Services Section -->
    <section id="services" class="bg-light py-5">
        <div class="container">
            <h2 class="text-center">Our Services</h2>
            <div class="row">
                <div class="col-md-4 text-center">
                    <h4>Loans</h4>
                    <p>Flexible loan products designed to meet the needs of farmers and agribusinesses.</p>
                </div>
                <div class="col-md-4 text-center">
                    <h4>Savings</h4>
                    <p>Secure and rewarding savings accounts to help you grow your wealth.</p>
                </div>
                <div class="col-md-4 text-center">
                    <h4>Investments</h4>
                    <p>Investment opportunities that offer attractive returns and contribute to agricultural development.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="container py-5">
        <h2 class="text-center">Contact Us</h2>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Address:</strong> 123 Farm Road, Agriculture City</p>
                <p><strong>Phone:</strong> +123 456 7890</p>
                <p><strong>Email:</strong> info@boanig.com</p>
            </div>
            <div class="col-md-6">
                <form id="contactForm">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="3" placeholder="Your Message" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Send Message</button>
                </form>
                <div id="contactResponse"></div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-success text-white text-center py-3">
        <p>Bank of Agriculture &copy; 2024. All rights reserved.</p>
        <div>
            <a href="#" class="text-white mx-2">Facebook</a>
            <a href="#" class="text-white mx-2">Twitter</a>
            <a href="#" class="text-white mx-2">LinkedIn</a>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#contactForm').on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: 'send_contact_mail.php',
                    data: formData,
                    success: function (response) {
                        $('#contactResponse').html('<div class="alert alert-success">' + response + '</div>');
                        $('#contactForm')[0].reset();
                    },
                    error: function () {
                        $('#contactResponse').html('<div class="alert alert-danger">There was an error sending your message. Please try again later.</div>');
                    }
                });
            });
        });
    </script>
</body>
</html>
