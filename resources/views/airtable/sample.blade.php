<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Custom Fonts (Adjust as needed) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">

    <style>
        *{
            font-family: 'Inter', sans-serif !important;
        }
        body {
            background-color: #FFFFFF;
            color: #000000;
        }

        /* Navbar */
        .navbar-brand {
            font-weight: 600;
            letter-spacing: -0.5px;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            color: #000000;
        }

        .navbar-nav .nav-link:hover {
            color: #6c757d;
        }

        .btn-add-listing {
            background-color: #ac7339;
            color: #ffffff;
            font-weight: 500;
            border-radius: 4px;
            padding: 0.5rem 1rem;
            text-decoration: none;
        }

        .btn-add-listing:hover {
            background-color: #945f2a;
            color: #fff;
        }

        /* Hero Section */
        .hero-section {
            text-align: center;
            padding: 4rem 1rem;
        }

        .hero-section h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .hero-section p {
            font-size: 1.125rem;
            color: #555555;
            margin-bottom: 2rem;
        }

        .hero-search .form-control {
            border: 1px solid #ddd;
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
        }

        .categories-filter {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .categories-filter button {
            background-color: #f5f5f5;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            color: #333;
            cursor: pointer;
        }

        .categories-filter button:hover {
            background-color: #ebebeb;
        }

        /* Results Section */
        .results-count {
            font-weight: 600;
            margin-bottom: 2rem;
        }

        .tool-card {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 1.5rem;
            text-align: left;
            position: relative;
            transition: box-shadow 0.3s;
            height: 100%;
        }

        .tool-card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .featured-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background-color: #ffe9cc;
            color: #ac7339;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
        }

        .tool-card h5 {
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 1.125rem;
        }

        .tool-card p {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 2rem;
        }

        .tool-card .bookmark-btn {
            position: absolute;
            bottom: 1rem;
            right: 1rem;
            background: none;
            border: none;
            cursor: pointer;
        }

        .tool-card .bookmark-btn::before {
            content: '🔖';
            /* Replace with an icon if desired */
            font-size: 1.25rem;
        }

        /* Category Filter on Right (if needed) */
        .category-select {
            margin-bottom: 2rem;
            max-width: 200px;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 2rem 0;
            font-size: 0.875rem;
            color: #777;
        }

        @media (min-width: 992px) {
            .hero-section h1 {
                font-size: 3rem;
            }
        }
    </style>

    <title>No-Code Toolbox</title>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light border-bottom bg-white">
        <div class="container">
            <a class="navbar-brand" href="#">TINYDIRECTORY</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-lg-0 align-items-center mb-2 ms-auto">
                    <li class="nav-item">
                        <a class="nav-link me-3" href="#">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-3" href="#">Subscribe</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-3" href="#">Contact Us</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="#">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn-add-listing" href="#">Add Listing</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1>The No-Code Toolbox</h1>
            <p>Find the perfect tool to take your no-code project from concept to launch</p>
            <div class="row justify-content-center hero-search mb-4">
                <div class="col-12 col-sm-8 col-md-6">
                    <input type="text" class="form-control" placeholder="Search" aria-label="Search">
                </div>
            </div>
            <div class="categories-filter">
                <button>Automation</button>
                <button>Mobile Apps</button>
                <button>Web Apps</button>
                <button>Productivity</button>
                <button>Analytics</button>
            </div>
        </div>
    </section>

    <!-- Results -->
    <section class="results-section">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="results-count">25 Results</div>
                <div class="category-select">
                    <select class="form-select">
                        <option selected>Category</option>
                        <option>Automation</option>
                        <option>Mobile Apps</option>
                        <option>Web Apps</option>
                        <option>Productivity</option>
                        <option>Analytics</option>
                    </select>
                </div>
            </div>

            <div class="row g-3">
                <!-- Example Cards: Repeat similar blocks for all tools -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="tool-card">
                        <span class="featured-badge">Featured</span>
                        <h5>Bubble</h5>
                        <p>Bubble is the best no code tool making development and launching apps and businesses easy.
                        </p>
                        <button class="bookmark-btn"></button>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="tool-card">
                        <span class="featured-badge">Featured</span>
                        <h5>Webflow</h5>
                        <p>Create professional, custom websites in a completely visual canvas with no code.</p>
                        <button class="bookmark-btn"></button>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="tool-card">
                        <span class="featured-badge">Featured</span>
                        <h5>Glide</h5>
                        <p>Turn spreadsheets into software.</p>
                        <button class="bookmark-btn"></button>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="tool-card">
                        <span class="featured-badge">Featured</span>
                        <h5>Softr</h5>
                        <p>Softr turns your Airtable data into beautiful and powerful websites.</p>
                        <button class="bookmark-btn"></button>
                    </div>
                </div>

                <!-- Add more cards as needed to reach 25 results -->
                <!-- ... -->

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-top mt-5">
        <div class="container">
            <p class="mb-0">© Made by TinyBuild Studio ✨</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
