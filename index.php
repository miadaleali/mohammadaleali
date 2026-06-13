<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fullscreen Layout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    @font-face {
        font-family: 'A Mashin Tahrir-Old';
        src: url('assets/fonts/AMashinTahrir-Old.eot');
        src: url('assets/fonts/AMashinTahrir-Old.eot?#iefix') format('embedded-opentype'),
            url('assets/fonts/AMashinTahrir-Old.woff2') format('woff2'),
            url('assets/fonts/AMashinTahrir-Old.woff') format('woff'),
            url('assets/fonts/AMashinTahrir-Old.ttf') format('truetype'),
            url('assets/fonts/AMashinTahrir-Old.svg#AMashinTahrir-Old') format('svg');
        font-weight: normal;
        font-style: normal;
        font-display: swap;
    }

    html,
    body {
        font-family: 'A Mashin Tahrir-Old';
        font-weight: normal;
        font-style: normal;
        height: 100%;
        margin: 0;
        overflow: hidden;
        background-color: #dbab38;
        background-image: url("https://www.transparenttextures.com/patterns/french-stucco.png");
    }

    .titr {
        font-size: 3.5rem;
    }

    .full-height {
        height: 100dvh;
    }

    .image-wrapper {
        height: 100%;
    }

    .image-wrapper img {
        max-height: 80%;
        width: auto;
        object-fit: contain;
        max-width: 120%;
        -webkit-mask-image: radial-gradient(circle,
                rgba(0, 0, 0, 1) 4%,
                rgba(0, 0, 0, 0) 100%);
        mask-image: radial-gradient(circle,
                rgba(0, 0, 0, 1) 4%,
                rgba(0, 0, 0, 0) 100%);

    }

    .nav-bar {
        padding-top: 60%;
    }

    .kooch-img {
        position: absolute;
        top: 20%;
        width: 600px;
        left: 0;
        z-index: 0;
        mix-blend-mode: multiply;
        opacity: 0.2;
    }

    .khat-img {
        position: absolute;
        top: 0;
        left: 40%;
        width: 600px;
        z-index: 0;
        mix-blend-mode: multiply;
        opacity: 0.06;
    }

    @media (max-width: 767px) {
        .image-wrapper {
            height: 40vh;
            width: 150%;
        }

        .image-wrapper img {
            max-height: 100%;
            width: 150%;
            object-fit: contain;
            max-width: 160%;
            width: 600px;

        }

        .kooch-img {
            position: absolute;
            top: 45%;
            width: 300px;
            left: 0;
            z-index: 0;
            mix-blend-mode: multiply;
            opacity: 0.2;
        }

        .nav-bar {
            padding-top: 3%;
        }

        .link-hr {
            display: none;
        }
    }

    /* From Uiverse.io by Navarog21 */
    button {
        width: 5em;
        position: relative;
        height: 2em;
        border: 3px ridge #b17e09;
        outline: none;
        background-color: transparent;
        color: rgb(81, 68, 0);
        transition: 1s;
        border-radius: 0.3em;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
        margin-bottom: 1rem;
    }

    button::after {
        content: "";
        position: absolute;
        top: -10px;
        left: 3%;
        width: 95%;
        height: 40%;
        overflow: hidden;
        background-color: #dbab38;
        background-image: url("https://www.transparenttextures.com/patterns/french-stucco.png");
        transition: 0.5s;
        transform-origin: center;
    }

    button::before {
        content: "";
        transform-origin: center;
        position: absolute;
        top: 80%;
        left: 3%;
        width: 95%;
        height: 40%;
        overflow: hidden;
        background-color: #dbab38;
        background-image: url("https://www.transparenttextures.com/patterns/french-stucco.png");
        transition: 0.5s;
    }

    button:hover::before,
    button:hover::after {
        transform: scale(0)
    }

    button:hover {
        box-shadow: inset 0px 0px 25px #9a6d04;
    }

    .ltr {
        direction: ltr;
    }

    .rtl {
        direction: rtl;
    }

    .link-hr {
        border: 1px solid #000000;
        width: 140%;
        right: -145%;
    }
    </style>
</head>

<body>
    <img class="kooch-img" src="assets/img/unnamed.jpg">
    <img class="khat-img" src="assets/img/r.jpeg" alt="">

    <div class="container-fluid full-height">
        <div class="row h-100 ltr">

            <!-- تصویر -->
            <div class="col-12 col-md-6 order-1 order-md-2 d-flex justify-content-center align-items-center p-0">
                <div class="image-wrapper d-flex justify-content-center align-items-center">
                    <img src="assets/img/Father.jpg" class="img-fluid" alt="image">
                </div>
            </div>

            <!-- محتوا -->
            <div class="col-12 col-md-6 d-flex align-items-center justify-content-center order-2 order-md-1">
                <div class="text-center p-4 rtl">
                    <h1 class="titr">سید محمد آل علی</h1>
                    <h3 class="mb-5">شاعر، نویسنده و نقاش </h3>
                    <div class="position-relative nav-bar">
                        <hr class="z-2 link-hr position-absolute ">
                        <button onclick="location.href='poetry.php'" class="">اشعار</button>
                        <button onclick="location.href='gallery.php'" class="">نقاشی</button>
                        <button class="">رمان</button>
                        <button class="">بیوگرافی</button>
                        <button class="">ارتباط</button>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>