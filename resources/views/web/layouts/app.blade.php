<!DOCTYPE html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('site-title',  'Berlin başta olmak üzere Almanya\'daki tüm etkinlikleri kolayca bulun - Berlindeyiz')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('site-description', "Berlindeyiz, başta Berlin olmak üzere Almanya'nın tüm şehirlerindeki müzik, kültür, sanat, edebiyat, gezi gibi etkinlikleri kolayca bulmanızı sağlar.")">
    <meta name="keywords" content="@yield('site-keywords', "berlin etkinlik, berlin etkinlikleri, berlin etkinlik takvimi, berlin türk etkinlikleri, berlindeyiz, berlinde etkinlik, almanya gezilecek yerler")">

    <meta name="author" content="Berlindeyiz, iletisim@berlindeyiz.de" />
    <meta name="Abstract" content="Berlindeyiz.de" />
    <meta name="Copyright" content="Copyright © 2020. Tüm Hakları Saklıdır. Sitemizin herhangi bir şekilde kopyalanması, çoğaltılması ve dağıtılması halinde yasal haklarımız işletilecektir." />
    <meta name="publisher" content="Berlindeyiz.de" />
    <meta name="robots" content="all" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="Berlindeyiz" />
    <meta property="og:locale" content="tr_TR" />
    <meta property="og:title" content="Berlin Etkinlikleri" />
    <meta property="og:description" content="@yield('site-description', "Berlindeyiz, başta Berlin olmak üzere Almanya'nın tüm şehirlerindeki müzik, kültür, sanat, edebiyat, gezi gibi etkinlikleri kolayca bulmanızı sağlar.")" />

    <link rel="icon" href="https://berlindeyiz.de/images/berlin.jpg">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
          integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay"
          crossorigin="anonymous">
    <link rel="sitemap" type="application/xml" title="Sitemap" href="/sitemap.xml">
    <link rel="icon" href="https://berlindeyiz.de/images/berlindeyiz.png" type="image/fav-icon"/>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Yanone+Kaffeesatz:wght@300&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-PS504YLF2T"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-PS504YLF2T');
    </script>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-KV8QSQM');</script>
    <!-- End Google Tag Manager -->
</head>
<body class="font-sans antialiased">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KV8QSQM"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div id="app">
    <div>
        <div class="min-h-screen  animate__animated animate__fadeIn">
            <header-component></header-component>
            @include('web.layouts.navigation')

            <div class="d-block w-full min-h-screen">
                @yield('content')
            </div>
        </div>

    </div>
</div>
<!--
<div class="fixed-bottom w-full p-10 shadow-sm z-10 bg-white"><p>Siteyi kullanarak çerezleri kabul etmiş sayılırsınız.</p></div>
-->
@include('web.layouts.footer')

