@extends('layouts.unipulse')

@section('title', 'Sejarah Sekolah - SMANeka')
@section('description', 'Sejarah perkembangan SMANeka dari awal berdiri hingga sekarang')

@section('content')

<!-- Sejarah Section -->
<section id="sejarah" class="about section">
  <div class="container">

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row g-5 align-items-stretch">
        <!-- Left - Image with Badge -->
        <div class="col-lg-5" data-aos="fade-right" data-aos-delay="150">
          <div class="campus-showcase">
            <img src="{{ asset('assets/img/education/kepala-sekolah.jpg') }}" alt="Sejarah SMANeka" class="img-fluid">
            <div class="experience-badge">
              <span class="years">25+</span>
              <span class="label">Years of Excellence</span>
            </div>
          </div>
        </div>

        <!-- Right - Content -->
        <div class="col-lg-7" data-aos="fade-left" data-aos-delay="200">
          <div class="story-content">
            <span class="subtitle">Our History</span>
            <h2>Sejarah SMANeka</h2>
            <p>SMANeka didirikan pada tahun 1998 dengan visi untuk menjadi lembaga pendidikan unggulan yang mampu mencetak generasi berkualitas. Dari awal berdiri, sekolah ini telah berkomitmen untuk menyediakan pendidikan berkualitas dengan fasilitas modern dan tenaga pengajar profesional.</p>

            <p>Seiring berjalannya waktu, SMANeka terus berkembang dan berinovasi dalam bidang pendidikan. Berbagai prestasi telah diraih oleh siswa-siswi di tingkat nasional maupun internasional, baik dalam bidang akademik maupun non-akademik.</p>

            <div class="row g-4 mt-4">
              <div class="col-6">
                <div class="history-milestone">
                  <h4 class="text-primary">1998</h4>
                  <p class="mb-0">Pendirian SMANeka</p>
                </div>
              </div>
              <div class="col-6">
                <div class="history-milestone">
                  <h4 class="text-primary">2005</h4>
                  <p class="mb-0">Akreditasi A Pertama</p>
                </div>
              </div>
              <div class="col-6">
                <div class="history-milestone">
                  <h4 class="text-primary">2015</h4>
                  <p class="mb-0">Penghargaan Sekolah Adiwiyata</p>
                </div>
              </div>
              <div class="col-6">
                <div class="history-milestone">
                  <h4 class="text-primary">2024</h4>
                  <p class="mb-0">Sekolah Penggerak</p>
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

@push('styles')
<style>
  .history-milestone {
    padding: 1.5rem;
    background: var(--surface-color);
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  }
  
  .history-milestone h4 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
  }
  
  .history-milestone p {
    font-size: 0.9rem;
    color: var(--text-muted);
  }
</style>
@endpush
