<?php include '../partials/navbar.php';
include '../partials/sidebar.php';
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Subjects</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .subject-card {
            position: relative;
            overflow: hidden;
            border: 1px solid #ddd;
            border-radius: 10px;
            transition: transform 0.3s ease-in-out;
            width: 350px;
            height: 420px;
        }

        .subject-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .subject-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
        }

        .subject-card .card-body {
            padding: 15px;
        }

        .subject-card .subject-info {
            position: absolute;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            width: 100%;
            padding: 15px;
            opacity: 0;
            transform: translateY(100%);
            transition: opacity 0.3s, transform 0.3s;
        }

        .subject-card:hover .subject-info {
            opacity: 1;
            transform: translateY(0);
        }

        /* Adjust the layout to work with sidebar */
        .content-wrapper {
            margin-left: 250px;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .content-wrapper {
                margin-left: 0; /* On smaller screens, no margin for sidebar */
            }
            .subject-card {
                height: auto; /* Allow cards to adjust height based on content */
            }
        }

        /* For mobile responsiveness on smaller screens */
        @media (max-width: 576px) {
            .subject-card {
                height: auto;
                max-width: 100%;
            }

            .subject-info {
                position: relative;
                background: rgba(0, 0, 0, 0.7);
                padding: 10px;
                bottom: unset;
            }
        }
    </style>
</head>
<body>
        <!-- Main Content Area -->
        <div class="content-wrapper">

        <h2 class="text-center">Department Subjects</h2>
            <!-- Subjects Grid -->
            <div class="container my-5">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <div class="col">
                        <div class="card subject-card">
                            <img src="../image/Book1.jpg" class="card-img-top" alt="Subject Image">
                            <div class="card-body">
                                <h5 class="card-title">Subject 1</h5>
                                <p class="card-text">Short description of Subject 1.</p>
                            </div>
                            <div class="subject-info">
                                <p><strong>Credits:</strong> 3</p>
                                <p><strong>Faculty:</strong> Dr. ABC</p>
                                <p><strong>Schedule:</strong> Mon/Wed/Fri, 10:00 AM - 12:00 PM</p>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card subject-card">
                            <img src="../image/Book1.jpg" class="card-img-top" alt="Subject Image">
                            <div class="card-body">
                                <h5 class="card-title">Subject 2</h5>
                                <p class="card-text">Short description of Subject 2.</p>
                            </div>
                            <div class="subject-info">
                                <p><strong>Credits:</strong> 4</p>
                                <p><strong>Faculty:</strong> Prof. XYZ</p>
                                <p><strong>Schedule:</strong> Tue/Thu, 2:00 PM - 4:00 PM</p>
                            </div>
                        </div>
                    </div>

                     <div class="col">
                        <div class="card subject-card">
                            <img src="../image/Book1.jpg" class="card-img-top" alt="Subject Image">
                            <div class="card-body">
                                <h5 class="card-title">Subject 2</h5>
                                <p class="card-text">Short description of Subject 2.</p>
                            </div>
                            <div class="subject-info">
                                <p><strong>Credits:</strong> 4</p>
                                <p><strong>Faculty:</strong> Prof. XYZ</p>
                                <p><strong>Schedule:</strong> Tue/Thu, 2:00 PM - 4:00 PM</p>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card subject-card">
                            <img src="../image/Book1.jpg" class="card-img-top" alt="Subject Image">
                            <div class="card-body">
                                <h5 class="card-title">Subject 2</h5>
                                <p class="card-text">Short description of Subject 2.</p>
                            </div>
                            <div class="subject-info">
                                <p><strong>Credits:</strong> 4</p>
                                <p><strong>Faculty:</strong> Prof. XYZ</p>
                                <p><strong>Schedule:</strong> Tue/Thu, 2:00 PM - 4:00 PM</p>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card subject-card">
                            <img src="../image/Book1.jpg" class="card-img-top" alt="Subject Image">
                            <div class="card-body">
                                <h5 class="card-title">Subject 2</h5>
                                <p class="card-text">Short description of Subject 2.</p>
                            </div>
                            <div class="subject-info">
                                <p><strong>Credits:</strong> 4</p>
                                <p><strong>Faculty:</strong> Prof. XYZ</p>
                                <p><strong>Schedule:</strong> Tue/Thu, 2:00 PM - 4:00 PM</p>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card subject-card">
                            <img src="../image/Book1.jpg" class="card-img-top" alt="Subject Image">
                            <div class="card-body">
                                <h5 class="card-title">Subject 2</h5>
                                <p class="card-text">Short description of Subject 2.</p>
                            </div>
                            <div class="subject-info">
                                <p><strong>Credits:</strong> 4</p>
                                <p><strong>Faculty:</strong> Prof. XYZ</p>
                                <p><strong>Schedule:</strong> Tue/Thu, 2:00 PM - 4:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
