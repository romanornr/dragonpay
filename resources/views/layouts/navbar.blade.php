<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
      <a class="navbar-brand" href="#">Payment Gateway</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/shops">Shops</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="/invoices">Invoices</a>
          </li>

          <li class="nav-item">
            <a class="nav-link disabled" href="/masterwallets">masterwallets</a>
          </li>
        </ul>

          <ul class="nav navbar-nav flex-row justify-content-between ml-auto">
              @if (Auth::guest())
              <li class="nav-item">
                  <a class="nav-link disabled" href="/login">Login</a>
              </li>
                  @else
                  <li class="nav-item">
                  <a class="nav-link disabled" href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                      Logout
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                  </form>
                  <li class="nav-item order-2 order-md-1"><a href="#" class="nav-link" title="settings"><i class="fa fa-cog fa-fw fa-lg"></i></a></li>

              @endif
          </ul>
        </ul>
      </div>
    </nav>