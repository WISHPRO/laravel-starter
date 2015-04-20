<!DOCTYPE html>
<html lang="en" class="app">
<head>
  <meta charset="utf-8" />
  <title>{{ Theme::get('title') }}</title>
  <meta name="keywords" content="{{ Theme::get('keywords') }}">
  <meta name="description" content="{{ Theme::get('description') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  {{ Theme::asset()->styles() }}
  {{ Theme::asset()->scripts() }}
  <!--[if lt IE 9]>
    {{ Theme::asset()->container('ie9')->scripts() }}
  <![endif]-->
</head>
<body>
  <section class="vbox">
    {{ Theme::partial('header-survey') }}
      <section class="hbox stretch bg-white">
        <section id="content">
          <section class="vbox">
            <section class="scrollable padder">
              <div class="wrapper container">
                <div class="m-t-xl m-b-xl text-center wrapper">
                    <img src="{{ Theme::asset()->url('img/prasarana_logo.png') }}" class="m-r-sm">
                    <h3>{{ Theme::get('description') }}</h3>
                    <p class="text-muted">All access or use of this system constitutes user understanding and acceptance of these terms and constitutes<br> unconditional consent to review, monitoring, recording, and action by all authorized personnel.</p>
                  </div>

                  <div class="row m-t-xl m-b-xl">
                    {{ Theme::content() }}
                  </div>

                  <div class="m-t-xl m-b-xl text-center wrapper clearfix">
                      <p class="hbox">
                        <small>ITD, Prasarana Malaysia Berhad<br>© {{ date('Y') }}</small>
                      </p>
                  </div>
              </div>
            </section>
          </section>

        </section>
      </section>
  </section>
  {{ Theme::asset()->container('core-scripts')->scripts() }}
  {{ Theme::asset()->container('post-scripts')->scripts() }}
</body>
</html>