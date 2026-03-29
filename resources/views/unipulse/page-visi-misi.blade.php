@extends('layouts.unipulse')

@section('title', 'Visi & Misi - SMANeka')
@section('description', 'Visi dan Misi SMANeka dalam mencerdaskan kehidupan bangsa')

@section('content')

<!-- Who We Are Section (Visi Misi) -->
<section id="about" class="about section">
  <div class="container">

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row g-5 align-items-stretch">
        <!-- Left - Image with Badge -->
        <div class="col-lg-5" data-aos="fade-right" data-aos-delay="150">
          <div class="campus-showcase">
            @if(setting('who_we_are_image'))
            <img src="{{ asset('storage/' . setting('who_we_are_image')) }}" alt="Kepala Sekolah SMANeka" class="img-fluid">
            @else
            <img src="{{ asset('assets/img/education/kepala-sekolah.jpg') }}" alt="Kepala Sekolah SMANeka" class="img-fluid">
            @endif
            <div class="experience-badge">
              <span class="years">25+</span>
              <span class="label">Years of Excellence</span>
            </div>
          </div>
        </div>

        <!-- Right - Content -->
        <div class="col-lg-7" data-aos="fade-left" data-aos-delay="200">
          <div class="story-content">
            <span class="subtitle">Who We Are</span>
            <h2>Membentuk Masa Depan Melalui Ilmu Pengetahuan & Penemuan</h2>
            <p>SMANeka berkomitmen untuk menciptakan lingkungan pembelajaran yang inspiratif dan inovatif, di mana setiap siswa dapat mengembangkan potensi akademik dan karakter mereka secara optimal.</p>

            <div class="row g-4 mt-2">
              <div class="col-sm-6">
                <div class="purpose-block">
                  <i class="bi bi-bullseye"></i>
                  <h4>Our Mission</h4>
                  <p>Menyelenggarakan pendidikan berkualitas dengan standar nasional dan internasional, mengembangkan potensi akademik dan non-akademik siswa secara optimal, serta menanamkan nilai-nilai karakter dan budi pekerti luhur.</p>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="purpose-block">
                  <i class="bi bi-eye"></i>
                  <h4>Our Vision</h4>
                  <p>Menjadi sekolah unggulan yang menghasilkan generasi cerdas, berkarakter, dan berdaya saing global berlandaskan iman dan taqwa.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
