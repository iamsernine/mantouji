<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/home.css">
    <title>Home</title>
</head>
<body>
    <div class="home">
        <x-navbar />
        <div class="content-container">
            <div class="content">
                <div class="left-content">
                    <p>Start Your unforgettable journey <span> with us. </span></p>
                    <p>the best travel for your journey begins now</p>
                </div>
            </div>
        </div>
    </div>

    <div class="auth">
        <div class="auth-header">
            <p>Please Tell us who you are !</p>
        </div>
        <div class="auth-cards">
            <div class="card">
                <div class="card-content-header">
                    <div class="card-content">
                        <div class="card-container-image">
                            <img src="/images/icones/client.png" alt="" srcset="">
                        </div>
                        <p><a href="{{Route('register', ['type' => 0])}}">Client ?</a></p>
                    </div>
                </div>
            </div>
            <div class="auth-card-or">
                <p>OR</p>
            </div>
            <div class="card">
                <div class="card-content-header">
                    <div class="card-content">
                        <div class="card-container-image">
                            <img src="/images/icones/store.png" alt="" srcset="">
                        </div>
                        <p><a href="{{Route('register', ['type' => 1])}}">Jm3iya ?</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>2025-Copyright</p>
    </div>

    <script src="js/navbar.js"></script>
</body>
</html>