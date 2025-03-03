<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="/">My Blog</a>

  <div class="navbar-nav">
    <div class="nav-item ms-auto">
      <form action="/logout" method="post">
        @csrf
        <button type="submit" class="nav-link px3 bg-dark border-0 me-3">Logout <span data-feather="log-out"></span></button>
      </form>
    </div>
  </div>
</header>