<!-- UniPulse Footer -->
<footer id="footer" class="footer dark-background">
  <div class="container footer-top">
    <div class="row gy-4">
      <div class="col-lg-5 col-md-12 footer-about">
        <a href="{{ route('home') }}" class="logo d-flex align-items-center">
          @if(setting('logo'))
          <img src="{{ asset('storage/' . setting('logo')) }}" alt="{{ setting('site_name', 'SMANeka') }}" height="40" class="d-inline-block align-text-top me-2">
          @endif
          <span class="sitename">{{ setting('site_name', 'SMANeka') }}</span>
        </a>
        <p>{{ setting('site_tagline', 'Sistem Manajemen Sekolah SMANeka - Platform digital untuk mengelola informasi sekolah, berita, prestasi, dan kegiatan ekstrakurikuler.') }}</p>
        <div class="social-links d-flex mt-4">
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

      <div class="col-lg-2 col-6 footer-links">
        <h4>Menu Cepat</h4>
        <ul>
          <li><a href="{{ route('home') }}">Home</a></li>
          <li><a href="{{ route('posts') }}">Berita</a></li>
          <li><a href="{{ route('teachers') }}">Guru & Staff</a></li>
          <li><a href="{{ route('achievements') }}">Prestasi</a></li>
          <li><a href="{{ route('extracurriculars') }}">Ekstrakurikuler</a></li>
          <li><a href="{{ route('gallery') }}">Galeri</a></li>
        </ul>
      </div>

      <div class="col-lg-2 col-6 footer-links">
        <h4>Layanan</h4>
        <ul>
          <li><a href="#">PPDB Online</a></li>
          <li><a href="#">E-Learning</a></li>
          <li><a href="#">Perpustakaan</a></li>
          <li><a href="#">Konseling</a></li>
          <li><a href="#">Alumni</a></li>
        </ul>
      </div>

      <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
        <h4>Kontak Kami</h4>
        <p>{{ setting('contact_address', 'Jl. Pendidikan No. 123, Kota Baru') }}</p>
        <p class="mt-3"><i class="bi bi-telephone me-2"></i><strong>Phone:</strong> <span>{{ setting('contact_phone', '(021) 1234-5678') }}</span></p>
        @if(setting('contact_whatsapp'))
        <p><i class="bi bi-whatsapp me-2"></i><strong>WhatsApp:</strong> <span><a href="https://wa.me/{{ str_replace(['-', ' ', '(', ')'], '', setting('contact_whatsapp')) }}" target="_blank" rel="noopener" style="color: #ffffff !important; text-decoration: none;">{{ setting('contact_whatsapp') }}</a></span></p>
        @endif
        <p><i class="bi bi-envelope me-2"></i><strong>Email:</strong> <span><a href="mailto:{{ setting('contact_email') }}" style="color: #ffffff !important; text-decoration: none;">{{ setting('contact_email') }}</a></span></p>
        @if(setting('website'))
        <p><i class="bi bi-globe me-2"></i><strong>Website:</strong> <span><a href="{{ setting('website') }}" target="_blank" rel="noopener" style="color: #ffffff !important; text-decoration: none;">{{ setting('website') }}</a></span></p>
        @endif
      </div>
    </div>
  </div>

  <div class="container copyright text-center mt-4">
    <p>© <span>Copyright</span> <strong class="px-1 sitename">{{ setting('site_name', 'SMANeka') }}</strong> <span>All Rights Reserved</span></p>
    <p class="mt-2 developer-credit"><small>Developed by <a href="https://jagoanmedia.com" target="_blank" rel="noopener" style="color: #ffffff !important;">Jagoan Media</a></small></p>
  </div>
</footer>

@push('styles')
<style>
  .footer .copyright,
  .footer .copyright * {
    background: none !important;
    background-color: transparent !important;
    background-image: none !important;
  }
  .footer .copyright {
    padding-top: 10px !important;
    padding-bottom: 10px !important;
  }
  .footer .copyright p,
  .footer .copyright span,
  .footer .copyright strong {
    color: rgba(255, 255, 255, 0.8) !important;
  }
  .footer .developer-credit,
  .footer .developer-credit a,
  .footer .developer-credit a:visited,
  .footer .developer-credit a:hover,
  .footer .developer-credit a:active {
    color: #ffffff !important;
    text-decoration: none;
  }
  .footer .developer-credit a:hover {
    opacity: 0.7;
    text-decoration: underline;
  }
  #footer .footer-contact a,
  #footer .footer-contact a:visited,
  #footer .footer-contact a:hover,
  #footer .footer-contact a:active {
    color: #ffffff !important;
    text-decoration: none;
  }
  #footer .footer-contact a:hover {
    opacity: 0.7;
    text-decoration: underline;
  }
  #footer a {
    color: #ffffff !important;
  }
</style>
@endpush

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div id="preloader"></div>
