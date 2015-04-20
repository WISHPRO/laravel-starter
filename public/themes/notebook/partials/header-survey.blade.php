<header class="bg-primary dk header navbar navbar-fixed-top-xs">
  <div class="container">
      <div class="navbar-header">
        <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html">
          <i class="fa fa-bars"></i>
        </a>
        <a href="#" class="navbar-brand" data-toggle="fullscreen"><img src="{{ Theme::asset()->url('img/logo.png') }}" class="m-r-sm">{{ Theme::get('description') }}</a>
        <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user">
          <i class="fa fa-cog"></i>
        </a>
      </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li class="active">
            <a href="{{ route('survey.setting') }}"><i class="fa fa-user"></i> &nbsp; {{ Sentry::getUser()->first_name }}</a>
          </li>
          <li>
            <div class="m-t-sm">
              <a href="{{ route('_auth.logout') }}" class="btn btn-sm btn-default m-l"><strong>Sign Out</strong></a>
            </div>
          </li>
        </ul>
      </div>
  </div>
</header>