<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sponsor Banner</title>
    <style>
        .banner {
            position: relative;
            text-align: center;
            color: rgb(0, 0, 0);
            padding: 20px;
            margin: 20px auto;
            max-width: 900px;
            border-radius: 10px;
        }
        .banner .background {
            background-size: cover;
            background-position: center;
            border-radius: 10px;
            padding: 20px;
        }
        .banner .content {
            position: relative;
        }
        .banner img {
            max-width: 100%;
            border-radius: 5px;
        }
        .banner a {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            color: white;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
        .banner a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
        <!-- Inclure le menu -->
@include('navbar')

    @if($banner)
        <div class="banner" style="background-color: {{ $banner['color'] }};">
            <div class="background" style="background-image: url('{{ $banner['background_image'] }}');">
                <div class="content">
                    <h1>{{ $banner['text'] }}</h1>
                    <img src="{{ $banner['image'] }}" alt="Banner Image">
                    <a href="{{ $banner['link'] }}" target="_blank">Visitez notre site</a>
                </div>
            </div>
        </div>
    @else
        <p>La bannière n'est pas disponible pour le moment.</p>
        @if(isset($error))
            <p>{{ $error }}</p>
        @endif
    @endif
</body>
</html>
