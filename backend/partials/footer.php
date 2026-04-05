<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer dengan Scroll</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html {
            scroll-behavior: smooth;
            /* bikin scroll halus */
        }

        section {
            padding: 100px 0;
            min-height: 100vh;
        }

        .footer {
            margin-top: auto;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-50">

    <!-- Section Kontak -->
    <section id="" class="bg-light text-center">
    </section>

    <!-- Footer -->
    <footer class="footer py-3" style="background: linear-gradient(135deg,rgb(43, 27, 117),rgb(3, 18, 150)); color: white;">
        <div class="container">
            <!-- Menu Scroll -->
            <div class="row">
                <div class="col text-center mb-">
                </div>
            </div>

            <hr class="border-light">

            <!-- Copyright -->
            <div class="row">
                <div class="col text-center">
                    <small class="text-light">

                        <a href="" class="text-white fw-bold" style="text-decoration:none;">
                            copyright
                        </a>
                        <span class="fw-bold"> by Nur Ratri Bekti Shinta Tama</span>
                        © <script>
                            document.write(new Date().getFullYear())
                        </script>
                    </small>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>