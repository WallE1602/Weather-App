<?php

$city = "";
$api_key = 'e5c88f9a1e083b0e001eb188a7069d7f';
$status = "";

if (isset($_GET['submit'])) {
    $city = $_GET['city'];

    $url = "http://api.openweathermap.org/data/2.5/forecast?q=$city&units=metric&appid=e5c88f9a1e083b0e001eb188a7069d7f";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $clima = curl_exec($ch);
    curl_close($ch);

    $clima = json_decode($clima, true);

    if ($clima['cod'] == 200) {
        $status = "yes";
    }

    if ($clima['cod'] == 404) {
        $status = "error";
    }
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oy! Weather</title>


    <!-- bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">



    <!-- fonts & icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/6ba562052f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- NAVBAR SECTION -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow p-3 bg-dark" style="background-color: #082032;">

        <!-- container for navbar  -->
        <div class="container">
            <!-- name of the website/brand -->
            <a href="#" class="navbar-brand">
                <img src="assets/weather.png" width="30" height="30" class="d-inline-block align-top" alt=""> Oy! Weather
            </a>

        </div>
    </nav>


    <!-- search bar -->
    <div class="container pt-5">
        <form class="searchbar d-flex" action="" method="GET">
            <input class="form-control me-2" type="text" name="city" id="city" placeholder="Enter City Name...." value="<?php echo $city ?>">
            <button class="btn btn-outline-success" type="submit" value="Submit" class="submit" name="submit">Search</button>

        </form>

        <!-- for the error message -->
        <?php if ($status == "error") { ?>
            <div class="row">
                <div class="alert alert-danger" role="alert">
                    <?php echo $clima['message'] ?>
                </div>
            </div>
        <?php } ?>
    </div>


    <!-- shows the weather box -->
    <?php if ($status == "yes") { ?>
        <div class="containerweatherbox p-3 justify-content-center">
            <div class="weatherbox">
                <!-- today's weather box -->
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-sm">
                            <div class="card p-3">

                                <div class="d-flex">
                                    <h5 class="flex-grow-1">
                                        <?php echo $clima['city']['name'] ?>
                                    </h5>
                                    <h6>
                                        <?php
                                        $today = date("D j M, Y | g:i a", strtotime($clima['list']['0']['dt_txt']));
                                        echo $today ?>
                                    </h6>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 order-1 order-lg-1">
                                        <div class="d-flex flex-column temp">
                                            <h1 class="p-3 mb-0 font-weight-bold" id="tempheading">
                                                <i class="fas fa-thermometer-half"></i> <span><?php echo $clima['list']['0']['main']['temp'] ?>° C</span>
                                            </h1>
                                            <p class="p-3 small grey flex-grow-1" id="weathertype">
                                                <?php echo $clima['list']['0']['weather']['0']['main'] ?>
                                            </p>

                                            <ul class="fa-ul">
                                                <li class="mb-2">
                                                    <i class="fas fa-smile"></i><span> Feels Like: <?php echo $clima['list']['0']['main']['feels_like'] ?>°C</span>
                                                </li>
                                                <li class="mb-2">
                                                    <i class="fas fa-temperature-high"></i><span> Temp Max: <?php echo $clima['list']['0']['main']['temp_max'] ?>°C</span>
                                                </li>
                                                <li class="mb-2">
                                                    <i class="fas fa-temperature-low"></i><span> Temp Min: <?php echo $clima['list']['0']['main']['temp_min'] ?>°C</span>
                                                </li>
                                            </ul>

                                        </div>
                                    </div>

                                    <div class="col-lg-6 order-2 order-lg-2 justify-content-center text-center">
                                        <div class="flex-lg-column">
                                            <img src="http://openweathermap.org/img/wn/<?php echo $clima['list']['0']['weather']['0']['icon'] ?>@4x.png">
                                        </div>
                                        <div class="d-flex">
                                            <div class="temp-details flex-grow-1">
                                                <p class="my-1"> <i class="fas fa-wind"></i> <span><?php echo $clima['list']['0']['wind']['speed'] ?> m/s</span> </p>
                                                <p class="my-1"> <i class="fa fa-tint" aria-hidden="true"></i> <span><?php echo $clima['list']['0']['main']['humidity'] ?> %</span> </p>
                                                <p class="my-1"> <i class="fas fa-compass fa-spin"></i> <span><?php echo $clima['list']['0']['main']['pressure'] ?> hPa</span> </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 5 day forecast -->
                <div class="container p-2">
                    <div class="row p-2">
                        <div class="cardcols col-sm">
                            <div class="card mb-2">
                                <div class="flex-lg-row">
                                    <img src="http://openweathermap.org/img/wn/<?php echo $clima['list']['7']['weather']['0']['icon'] ?>@2x.png">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title mb-3">
                                        <?php
                                        $today = date("D j|g:i a", strtotime($clima['list']['7']['dt_txt']));
                                        echo $today ?>
                                    </h5>
                                    <p class="mb-3"><i class="fas fa-thermometer-half"></i><span> Temp: <?php echo $clima['list']['7']['main']['temp'] ?>°C</span></p>
                                    <p class="mb-3"><i class="fas fa-smile"></i><span> Feels Like: <?php echo $clima['list']['7']['main']['feels_like'] ?>°C</span></p>
                                    <p class="mb-3"><i class="fas fa-temperature-high"></i><span> Temp Max: <?php echo $clima['list']['7']['main']['temp_max'] ?>°C</span></p>
                                    <p class="mb-3"><i class="fas fa-temperature-low"></i><span> Temp Min: <?php echo $clima['list']['7']['main']['temp_min'] ?>°C</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="cardcols col-sm">
                            <div class="card mb-2">
                                <div class="flex-lg-row">
                                    <img src="http://openweathermap.org/img/wn/<?php echo $clima['list']['18']['weather']['0']['icon'] ?>@2x.png">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title mb-3">
                                        <?php
                                        $today = date("D j|g:i a", strtotime($clima['list']['18']['dt_txt']));
                                        echo $today ?>
                                    </h5>
                                    <p class="mb-3"><i class="fas fa-thermometer-half"></i><span> Temp: <?php echo $clima['list']['7']['main']['temp'] ?>°C</span></p>
                                    <p class="mb-3"><i class="fas fa-smile"></i><span> Feels Like: <?php echo $clima['list']['7']['main']['feels_like'] ?>°C</span></p>
                                    <p class="mb-3"><i class="fas fa-temperature-high"></i><span> Temp Max: <?php echo $clima['list']['7']['main']['temp_max'] ?>°C</span></p>
                                    <p class="mb-3"><i class="fas fa-temperature-low"></i><span> Temp Min: <?php echo $clima['list']['7']['main']['temp_min'] ?>°C</span></p>

                                </div>
                            </div>
                        </div>

                        <div class="cardcols col-sm">
                            <div class="card mb-2">
                                <div class="flex-lg-row">
                                    <img src="http://openweathermap.org/img/wn/<?php echo $clima['list']['22']['weather']['0']['icon'] ?>@2x.png">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title mb-3">
                                        <?php
                                        $today = date("D j|g:i a", strtotime($clima['list']['22']['dt_txt']));
                                        echo $today ?>
                                    </h5>
                                    <p class="mb-3"><i class="fas fa-thermometer-half"></i><span> Temp: <?php echo $clima['list']['7']['main']['temp'] ?>°C</span></p>
                                    <p class="mb-3"><i class="fas fa-smile"></i><span> Feels Like: <?php echo $clima['list']['7']['main']['feels_like'] ?>°C</span></p>
                                    <p class="mb-3"><i class="fas fa-temperature-high"></i><span> Temp Max: <?php echo $clima['list']['7']['main']['temp_max'] ?>°C</span></p>
                                    <p class="mb-3"><i class="fas fa-temperature-low"></i><span> Temp Min: <?php echo $clima['list']['7']['main']['temp_min'] ?>°C</span></p>

                                </div>
                            </div>
                        </div>

                        <div class="cardcols col-sm">
                            <div class="card mb-2">
                                <div class="flex-lg-row">
                                    <img src="http://openweathermap.org/img/wn/<?php echo $clima['list']['32']['weather']['0']['icon'] ?>@2x.png">
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title mb-3">
                                        <?php
                                        $today = date("D j|g:i a", strtotime($clima['list']['32']['dt_txt']));
                                        echo $today ?>
                                    </h5>
                                    <p class="mb-3"><i class="fas fa-thermometer-half"></i><span> Temp: <?php echo $clima['list']['7']['main']['temp'] ?>°C</span></p>
                                    <p class="mb-3"><i class="fas fa-smile"></i><span> Feels Like: <?php echo $clima['list']['7']['main']['feels_like'] ?>°C</span></p>
                                    <p class="mb-3"><i class="fas fa-temperature-high"></i><span> Temp Max: <?php echo $clima['list']['7']['main']['temp_max'] ?>°C</span></p>
                                    <p class="mb-3"><i class="fas fa-temperature-low"></i><span> Temp Min: <?php echo $clima['list']['7']['main']['temp_min'] ?>°C</span></p>

                                </div>
                            </div>
                        </div>

                        <div class="cardcols col-sm">
                            <div class="card mb-2">
                                <div class="flex-lg-row">
                                    <img src="http://openweathermap.org/img/wn/<?php echo $clima['list']['38']['weather']['0']['icon'] ?>@2x.png">
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title mb-3">
                                        <?php
                                        $today = date("D j|g:i a", strtotime($clima['list']['38']['dt_txt']));
                                        echo $today ?>
                                    </h5>
                                    <p class="mb-3"><i class="fas fa-thermometer-half"></i><span> Temp: <?php echo $clima['list']['7']['main']['temp'] ?>°C</span></p>
                                    <p class="mb-3"><i class="fas fa-smile"></i><span> Feels Like: <?php echo $clima['list']['7']['main']['feels_like'] ?>°C</span></p>
                                    <p class="mb-3"><i class="fas fa-temperature-high"></i><span> Temp Max: <?php echo $clima['list']['7']['main']['temp_max'] ?>°C</span></p>
                                    <p class="mb-3"><i class="fas fa-temperature-low"></i><span> Temp Min: <?php echo $clima['list']['7']['main']['temp_min'] ?>°C</span></p>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    <?php } ?>


    <!-- <div id="weather">
        <?php

        if ($weather) {

            echo '<div class="alert alert-success" role="alert">
            ' . $weather . '
            </div>';
        } else if ($error) {

            echo '<div class="alert alert-danger" role="alert">
            ' . $error . '
            </div>';
        }
        ?>
    </div> -->

    <!-- footer-->
    <!-- <footer class="footer-contact" style="background-color: #524f4f;">
        <div class="footer">
            <div class="container p-3">
                <p id="footer-text"> © 2021 SEFATUL WASI | All rights Reserved.</p>
            </div>
        </div>
    </footer> -->

    <!-- JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>