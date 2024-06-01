<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #23242a;
        }
        .container {
            display: flex;
            width: 800px;
            height: 450px;
            background: #1c1c1c;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
        }
        .slideshow {
            position: relative;
            width: 50%;
            height: 100%;
            overflow: hidden;
        }
        .slideshow img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
        .slideshow img.active {
            opacity: 1;
        }
        .form-container {
            position: relative;
            width: 50%;
            height: 100%;
            background: #28292d;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .box {
            position: relative;
            width: 100%;
            height: 110%;
            background: #1c1c1c;
            border-radius: 8px;
            overflow: hidden;
        }
        .box::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 380px;
            height: 420px;
            background: linear-gradient(0deg, transparent, transparent, #45f3ff, #45f3ff);
            transform-origin: bottom right;
            animation: animate 6s linear infinite;
        }
        .box::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 380px;
            height: 420px;
            background: linear-gradient(0deg, transparent, transparent, #45f3ff, #45f3ff);
            transform-origin: bottom right;
            animation: animate 6s linear infinite;
            animation-delay: -3s;
        }
        @keyframes animate {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
        .form {
            position: absolute;
            inset: 2px;
            border-radius: 8px;
            background: #28292d;
            z-index: 10;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
        }
        .form h2 {
            color: #45f3ff;
            font-weight: 500;
            text-align: center;
            letter-spacing: 0.1em;
        }
        .inputBox {
            position: relative;
            width: 300px;
            margin-top: 35px;
        }
        .inputBox input {
            position: relative;
            width: 100%;
            padding: 20px 10px 10px;
            background: transparent;
            outline: none;
            border: none;
            color: #23242a;
            font-size: 1em;
            letter-spacing: 0.05em;
            z-index: 10;
        }
        .inputBox span {
            position: absolute;
            left: 0;
            padding: 20px 0px 10px;
            pointer-events: none;
            color: #8f8f8f;
            font-size: 1em;
            letter-spacing: 0.05em;
            transition: 0.5s;
        }
        .inputBox input:valid ~ span,
        .inputBox input:focus ~ span {
            color: #45f3ff;
            transform: translateX(0px) translateY(-34px);
            font-size: 0.75em;
        }
        .inputBox i {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 2px;
            background: #45f3ff;
            border-radius: 4px;
            transition: 0.5s;
            pointer-events: none;
            z-index: 9;
        }
        .inputBox input:valid ~ i,
        .inputBox input:focus ~ i {
            height: 44px;
        }
        .links {
            display: flex;
            justify-content: space-between;
        }
        .links a {
            margin: 10px 0;
            font-size: 0.75em;
            color: #8f8f8f;
            text-decoration: none;
        }
        .links a:hover,
        .links a:nth-child(2) {
            color: #45f3ff;
        }
        input[type="submit"] {
            border: none;
            outline: none;
            background: #45f3ff;
            padding: 11px 25px;
            width: 100px;
            margin-top: 10px;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
        }
        input[type="submit"]:active {
            opacity: 0.8;
        }
        .error-message {
            position: absolute;
            bottom: -20px; 
            left: 0;
            color: #ff0000; 
            font-size: 0.75em; 
        }
        .invalid-feedback {
            color: #ff0000;
            font-size: 0.75em;
            position: fixed;
            padding: 10px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="slideshow">
            <img src="{{ asset('images/book1.jpg') }}" class="active" alt="Book 1">
            <img src="{{ asset('images/book2.jpg') }}" alt="Book 2">
            <img src="{{ asset('images/book3.jpg') }}" alt="Book 3">
        </div>
        <div class="form-container">
            <div class="box">
                <div class="form">
                    <h2>Login</h2>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="inputBox">
                            <input id="email" type="email" name="email" required autocomplete="email" autofocus>
                            <span>Email</span>
                            <i></i>
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        <div class="inputBox">
                            <input id="password" type="password" name="password" required autocomplete="current-password">
                            <span>Password</span>
                            <i></i>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        <input type="submit" value="Login">
                    </form>
                </div>
                
            </div>
        </div>
    </div>
    <script>
        const slides = document.querySelectorAll('.slideshow img');
        let currentSlide = 0;
        setInterval(() => {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add('active');
        }, 3000); 
    </script>
</body>
</html>
