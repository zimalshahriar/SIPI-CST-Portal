<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSE Department Portal</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            background: #0B1930;
            color: white;
            overflow-x: hidden;
        }

        /* Binary Rain Effect */
        .binary-rain {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            z-index: 0;
        }

        .binary {
            position: absolute;
            color: #0f6;
            font-family: monospace;
            font-size: 14px;
            opacity: 0;
            transform: translateY(-50px);
            text-shadow: 0 0 5px #0f6;
            animation: rainDrop 8s linear infinite;
        }

        @keyframes rainDrop {
            0% {
                opacity: 0;
                transform: translateY(-50px) rotate(0deg);
            }
            20% {
                opacity: 0.5;
            }
            70% {
                opacity: 0.5;
            }
            100% {
                opacity: 0;
                transform: translateY(100vh) rotate(360deg);
            }
        }

        /* Circuit Pattern */
        .circuit-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                linear-gradient(90deg, rgba(11, 25, 48, 0.9) 15px, transparent 1%) center,
                linear-gradient(rgba(11, 25, 48, 0.9) 15px, transparent 1%) center,
                rgba(0, 112, 204, 0.2);
            background-size: 16px 16px;
            z-index: -2;
        }

        /* Floating Icons */
        .floating-icon {
            position: absolute;
            color: rgba(0, 240, 255, 0.2);
            animation: float 10s ease-in-out infinite;
            z-index: -1;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(20px, -20px) rotate(90deg); }
            50% { transform: translate(0, 20px) rotate(180deg); }
            75% { transform: translate(-20px, -20px) rotate(270deg); }
        }

        /* Code Snippets */
        .code-snippet {
            position: absolute;
            font-family: monospace;
            color: rgba(0, 255, 166, 0.2);
            pointer-events: none;
            white-space: pre;
            z-index: -1;
        }

        /* Content Styling */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .content-box {
            background: rgba(11, 25, 48, 0.8);
            border: 1px solid rgba(0, 240, 255, 0.3);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 0 30px rgba(0, 240, 255, 0.1);
            backdrop-filter: blur(10px);
            transform: translateZ(0);
        }

        .title-text {
            font-size: 3.5rem;
            color: #fff;
            text-shadow: 0 0 20px rgba(0, 240, 255, 0.5);
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .title-text {
                font-size: 2.5rem;
            }
        }

        .login-btn {
            background: linear-gradient(45deg, #00f2fe, #4facfe);
            border: none;
            padding: 15px 45px;
            border-radius: 30px;
            font-size: 1.2rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 0 20px rgba(0, 242, 254, 0.3);
        }

        .login-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 30px rgba(0, 242, 254, 0.5);
        }

        /* Transition Effect */
        .page-transition {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, #00f2fe, #0B1930);
            z-index: 1000;
            clip-path: circle(0% at 50% 50%);
            transition: clip-path 1s ease-in-out;
        }

        .page-transition.active {
            clip-path: circle(150% at 50% 50%);
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            .content-box {
                margin: 1rem;
                padding: 1.5rem;
            }
            .login-btn {
                padding: 12px 30px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="binary-rain"></div>
    <div class="circuit-pattern"></div>

    <!-- Tech Background Elements -->
    <div class="floating-icon" style="top: 15%; left: 10%;"><i class="fas fa-code fa-3x"></i></div>
    <div class="floating-icon" style="top: 25%; right: 15%;"><i class="fas fa-microchip fa-2x"></i></div>
    <div class="floating-icon" style="top: 60%; left: 20%;"><i class="fas fa-database fa-2x"></i></div>
    <div class="floating-icon" style="top: 75%; right: 25%;"><i class="fas fa-laptop-code fa-3x"></i></div>
    <div class="floating-icon" style="top: 40%; left: 80%;"><i class="fas fa-network-wired fa-2x"></i></div>

    <!-- Code Snippets -->
    <div class="code-snippet" style="top: 20%; left: 5%;">class CSE {
    void innovate() {
        future.create();
    }
}</div>
    <div class="code-snippet" style="bottom: 30%; right: 5%;">def learn():
    while True:
        knowledge++</div>

    <div class="page-transition"></div>

    <div class="hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="content-box text-center">
                        <h1 class="title-text">Welcome to CSE Department</h1>
                        <p class="lead mb-5">Access your necessary resources </p>
                        <button class="login-btn btn btn-primary btn-lg" onclick="transitionToLogin()">
                            Login Now <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // Binary Rain Effect
        function createBinaryRain() {
            const rain = document.querySelector('.binary-rain');
            const binary = document.createElement('div');
            binary.className = 'binary';
            binary.style.left = Math.random() * 100 + 'vw';
            binary.textContent = Math.random() > 0.5 ? '0' : '1';
            rain.appendChild(binary);

            setTimeout(() => {
                binary.remove();
            }, 8000);
        }

        // Create binary rain at intervals
        setInterval(createBinaryRain, 100);

        // Transition to login page
        function transitionToLogin() {
            const transition = document.querySelector('.page-transition');
            transition.classList.add('active');
            
            setTimeout(() => {
                window.location.href = 'login.php';
            }, 1000);
        }

        // Make floating icons and code snippets responsive
        function adjustElements() {
            const vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);
            const vh = Math.max(document.documentElement.clientHeight || 0, window.innerHeight || 0);

            document.querySelectorAll('.floating-icon').forEach(icon => {
                const rect = icon.getBoundingClientRect();
                if (rect.right > vw) icon.style.right = '5%';
                if (rect.bottom > vh) icon.style.bottom = '5%';
            });

            document.querySelectorAll('.code-snippet').forEach(snippet => {
                const rect = snippet.getBoundingClientRect();
                if (rect.right > vw) snippet.style.right = '5%';
                if (rect.bottom > vh) snippet.style.bottom = '5%';
            });
        }

        // Adjust elements on load and resize
        window.addEventListener('load', adjustElements);
        window.addEventListener('resize', adjustElements);
    </script>
</body>
</html>