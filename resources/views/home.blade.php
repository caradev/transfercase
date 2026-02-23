<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>TRANSFERCASES UNLIMITED INC</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <meta name="description"
              content="@yield('metadesc', 'Since 1989 we’ve been offering drivers and the local 4 wheel drive(4WD) community the best rebuilt and updated transfer cases in the market')">
        <meta name="author" content="Transfercase Unlimited">
        <meta name="page-type"
              content="Since 1989 we’ve been offering drivers and the local 4 wheel drive(4WD) community the best rebuilt and updated transfer cases in the market.">
        <meta name="page-topic" content="Transfercase manufacturing">


        <meta name="keywords" content="transfercase, automobile transfercase, car, car transfercase">

        <meta name="msapplication-TileColor" content="#12a6ea">
        <meta name="theme-color" media="(prefers-color-scheme: dark)" content="#de5b04">
        <meta name="theme-color" media="(prefers-color-scheme: light)" content="#FF7212">
        <meta name="audience" content="all">
        <meta name="language" content="en">
        <meta property="og:locale" content="en_US">
        <meta property="og:type" content="website">
        <meta property="og:title" content="Transfercase Unlimited">
        <meta property="og:description" content="Transfercase Unlimited">
        <meta property="og:url" content="https://transfercase.com/">
        <meta property="og:site_name" content="transfercase.com">
<!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;700&family=Heebo:wght@400;700&display=swap"
              rel="stylesheet">

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
  <body>
      <div class="bg-hero md:bg-bottom bg-no-repeat bg-cover">
          <div class="absolute inset-x-0 top-0 z-50">
            <x-navbar />
          </div>

          <div class="relative isolate px-6 pt-14 lg:px-8">


              <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
                  <div class="text-white">
                      <h1 class="text-4xl font-bold tracking-tight sm:text-6xl">EXPERT SERVICE. <br/> UNBEATABLE
                          PRODUCTS</h1>
                      <p class="mt-6 text-lg leading-8">
                          Quality work is our first priority.</p>
                      <div class="mt-10 flex items-center justify-center gap-x-6">
                          <a href="#contact"
                             class="bg-orange-600 font-brand text-xl px-6 py-4 font-semibold text-white shadow-sm
                           hover:bg-transparent hover:border-2 hover:border-orange-600 focus-visible:outline
                           focus-visible:outline-offset-2 focus-visible:outline-orange-600 transition-all duration-300">Get
                              started <span
                                  aria-hidden="true">→</span></a>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <main id="main">
          <div class="flex flex-col md:grid md:grid-cols-2 gap-7 items-center max-w-5xl mx-auto">

              <div>
{{--                  <livewire:display />--}}
              </div>

              <div class="space-y-6">
                  <h2 class="text-4xl font-bold">
                      The Best Transfer Cases in Long Island, New York
                  </h2>
                  <div class="flex flex-col">
                      <div>
                          <h3 class="text-2xl font-bold font-brand">
                              Professional Standard
                          </h3>
                          <p>
                              Since 1989 we’ve been offering drivers and the local 4 wheel drive(4WD) community the
                              best rebuilt and updated transfer cases in the market, providing strength and
                              performance that lasts for years to come.
                          </p>
                      </div>

                      <div>
                          <h3 class="text-2xl font-bold font-brand">
                              Best Materials
                          </h3>
                          <p>
                              Over the next 30+ years, TCU has strived every day to provide outstanding
                              workmanship, excellent customer service that stand the test of time. Our ongoing
                              vision to serve 4 wheel drive motorists has helped us become the go-to, most trusted
                              transfer cases shop in Long Island, NY
                          </p>
                      </div>
                  </div>
              </div>
          </div>

          {{--        Contact Section--}}
          <div class="contact max-5-xl mx-auto flex flex-col md:grid md:grid-cols-2 items-center">
              <section class="grid items-center place-content-center space-y-6">
                  <div class="space-y-6">
                      <p class="text-4xl font-brand font-bold">We are open:</p>
                      <ul>
                          <li>Monday - Friday: 6:30a.m. - 5p.m.</li>
                          <li>Saturday: 9a.m. - 12p.m.</li>
                          <li>Sunday: CLOSED</li>
                      </ul>
                  </div>
                  <div class="space-y-3">
                      <p class="text-4xl font-brand font-bold">Give us a call:</p>
                      <div>(631) 226-1448</div>
                  </div>
              </section>
              <section class="bg-white dark:bg-gray-900" id="contact">
                  <div class="py-8 lg:py-16 px-4 mx-auto max-w-3xl">
                      <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">
                          Contact Us</h2>
                      <p class="mb-8 lg:mb-16 font-light text-center text-gray-500 dark:text-gray-400 sm:text-xl">
                          Send us a message using the form below and we will get back to you as quick as possible. Be sure
                          to include as much information as possible so we can better assist you.
                      </p>
{{--                      <livewire:inquiry-form />--}}
                  </div>
              </section>
          </div>
      </main>
      <footer class="h-40 bg-brandBlue text-white">
          <div class="grid justify-center items-center h-full">
              Copyright &copy; 2023 Transfercase Unlimited Inc.
          </div>
      </footer>


  </body>
</html>
