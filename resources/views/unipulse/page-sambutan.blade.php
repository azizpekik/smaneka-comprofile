@extends('layouts.unipulse')

@section('title', 'Sambutan Kepala Sekolah - SMANeka')
@section('description', 'Sambutan dari Kepala Sekolah SMANeka')

@section('content')

<!-- Sambutan Section -->
<section id="sambutan" class="about section">
  <div class="container">

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row g-5 align-items-stretch">
        <!-- Left - Image -->
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
            <span class="subtitle">Sambutan Kepala Sekolah</span>
            <h2>Assalamu'alaikum Warahmatullahi Wabarakatuh</h2>
            
            <p>Puji syukur kita panjatkan ke hadirat Allah SWT atas rahmat dan karunia-Nya, sehingga kita dapat mengakses website SMANeka ini. Website ini hadir sebagai media informasi dan komunikasi antara sekolah dengan masyarakat, khususnya para orang tua dan siswa.</p>

            <p>SMANeka berkomitmen untuk terus meningkatkan kualitas pendidikan guna mencetak generasi yang unggul dalam prestasi, luhur dalam budi pekerti, serta mampu bersaing di era global. Kami menyadari bahwa pendidikan bukan hanya tentang transfer pengetahuan, tetapi juga tentang pembentukan karakter dan nilai-nilai kehidupan.</p>

            <p>Kami mengucapkan terima kasih kepada semua pihak yang telah mendukung dan berkontribusi dalam pengembangan SMANeka. Semoga Allah SWT senantiasa memberikan bimbingan dan kemudahan dalam setiap langkah kita.</p>

            <p class="mt-4"><strong>Wassalamu'alaikum Warahmatullahi Wabarakatuh</strong></p>
            
            <div class="signature-section mt-5">
              <p class="mb-1">Kepala Sekolah SMANeka</p>
              <p class="fw-bold">Dr. Nama Kepala Sekolah, M.Pd</p>
              <p class="text-muted">NIP. 19700101 199501 1 001</p>
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
  .signature-section {
    padding-left: 2rem;
    border-left: 3px solid var(--accent-color);
  }
</style>
@endpush
