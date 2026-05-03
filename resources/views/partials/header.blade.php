<!-- UniPulse Header -->
<header id="header" class="header position-relative">
  <div class="container">
    <div class="header-top d-flex align-items-center justify-content-between">
      <div class="contact-info d-none d-lg-flex align-items-center">
        <i class="bi bi-envelope"></i>
        <a href="mailto:{{ setting('contact_email') }}">{{ setting('contact_email') }}</a>
        <i class="bi bi-phone ms-4"></i>
        <span>{{ setting('contact_phone') }}</span>
      </div>
      <div class="social-links d-flex align-items-center">
        @if(setting('social_facebook'))
        <a href="{{ setting('social_facebook') }}" target="_blank"><i class="bi bi-facebook"></i></a>
        @endif
        @if(setting('social_instagram'))
        <a href="{{ setting('social_instagram') }}" target="_blank"><i class="bi bi-instagram"></i></a>
        @endif
        @if(setting('social_youtube'))
        <a href="{{ setting('social_youtube') }}" target="_blank"><i class="bi bi-youtube"></i></a>
        @endif
        @if(setting('social_tiktok'))
        <a href="{{ setting('social_tiktok') }}" target="_blank"><i class="bi bi-tiktok"></i></a>
        @endif
      </div>
    </div>

    <div class="header-main d-flex align-items-center justify-content-between">
      <a href="{{ route('home') }}" class="logo d-flex align-items-center">
        @if(setting('logo'))
        <img src="{{ asset('storage/' . setting('logo')) }}" alt="{{ setting('site_name', 'SMANeka') }}" height="40" class="d-inline-block align-text-top">
        @endif
        <h1 class="sitename">{{ setting('site_name', 'SMANeka') }}</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
          
          @if(isset($menuItems) && $menuItems->count() > 0)
            @php
              // Fixed routes that should NOT use page route
              $fixedRoutes = ['/berita', '/guru-staff', '/guru', '/prestasi', '/ekstrakurikuler', '/galeri', '/kontak', '/profil/sejarah', '/profil/visi-misi'];
            @endphp

            @foreach($menuItems as $menuItem)
              @php
                $slug = ltrim($menuItem->url, '/');
                $hasChildren = $menuItem->children && $menuItem->children->count() > 0;
                $isFixedRoute = in_array($menuItem->url, $fixedRoutes);
                $isRootUrl = $menuItem->url === '/';
              @endphp

              @if($hasChildren)
              <li class="dropdown">
                <a href="{{ $menuItem->url }}"><span>{{ $menuItem->name }}</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  @foreach($menuItem->children as $child)
                  <li>
                    @if(str_starts_with($child->url, '/') && !in_array($child->url, $fixedRoutes))
                    <!-- Child static page - use slug directly -->
                    <a href="{{ route('page', ['slug' => ltrim($child->url, '/')]) }}">{{ $child->name }}</a>
                    @else
                    <!-- Child fixed route or external -->
                    <a href="{{ $child->url }}">{{ $child->name }}</a>
                    @endif
                  </li>
                  @endforeach
                </ul>
              </li>
              @else
              <li>
                @if($isRootUrl)
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">{{ $menuItem->name }}</a>
                @elseif(str_starts_with($menuItem->url, '/') && !$isFixedRoute)
                <a href="{{ route('page', ['slug' => $slug]) }}" class="{{ request()->routeIs('page') && request()->route('page') == $slug ? 'active' : '' }}">{{ $menuItem->name }}</a>
                @else
                <a href="{{ $menuItem->url }}" class="{{ request()->url() == $menuItem->url ? 'active' : '' }}">{{ $menuItem->name }}</a>
                @endif
              </li>
              @endif
            @endforeach
            
            <!-- Hardcoded Menu Kritik & Saran -->
            <li><a href="{{ route('kritik-saran') }}" class="{{ request()->routeIs('kritik-saran') ? 'active' : '' }}">Kritik & Saran</a></li>
          @else
          <!-- Default menu if no menuItems -->
          <li><a href="#about">About</a></li>
          <li><a href="#news">News</a></li>
          <li><a href="#achievements">Achievements</a></li>
          <li><a href="#contact">Contact</a></li>
          @endif
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </div>
</header>
