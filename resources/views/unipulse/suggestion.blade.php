@extends('layouts.unipulse')

@section('title', 'Kritik & Saran - SMANeka')
@section('description', 'Kritik dan Saran untuk SMANeka - Sampaikan pendapat Anda untuk kemajuan sekolah')

@section('content')

<!-- Suggestion Section -->
<section id="suggestion" class="suggestion section">
  <div class="container">
    
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2>Kritik & Saran</h2>
      <p>Sampaikan kritik dan saran Anda untuk kemajuan SMANeka</p>
    </div><!-- End Section Title -->

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success mb-4" data-aos="fade-in">
      <i class="bi bi-check-circle-fill"></i>
      <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Error Messages -->
    @if($errors->any())
    <div class="alert alert-danger mb-4" data-aos="fade-in">
      <i class="bi bi-exclamation-circle-fill"></i>
      <ul class="mb-0">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <div class="row justify-content-center">
      <!-- Suggestion Form -->
      <div class="col-lg-8" data-aos="fade-up">
        <div class="suggestion-form-card">
          <h3>Form Kritik & Saran</h3>
          <p class="form-description">Silakan isi form di bawah ini. Kami sangat menghargai masukan dari Anda.</p>
          
          <form action="{{ route('kritik-saran.submit') }}" method="POST" class="suggestion-form">
            @csrf
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Nama Lengkap <span class="required">*</span></label>
                  <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                  @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email">Email <span class="required">*</span></label>
                  <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                  @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            
            <div class="form-group">
              <label for="phone">No. HP <span class="required">*</span></label>
              <input type="tel" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
              @error('phone')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            
            <div class="form-group">
              <label for="message">Kritik & Saran <span class="required">*</span></label>
              <textarea id="message" name="message" rows="5" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
              @error('message')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            
            <!-- Captcha -->
            <div class="form-group captcha-group">
              <label for="captcha">Kode Verifikasi <span class="required">*</span></label>
              <div class="captcha-wrapper">
                <div class="captcha-image">
                  <img src="{{ captcha_src('flat') }}" id="captcha-image" alt="Captcha">
                </div>
                <button type="button" class="btn-refresh-captcha" onclick="refreshCaptcha()" title="Refresh Captcha">
                  <i class="bi bi-arrow-clockwise"></i>
                </button>
              </div>
              <input type="text" id="captcha" name="captcha" class="form-control @error('captcha') is-invalid @enderror" placeholder="Masukkan kode di atas" required>
              @error('captcha')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            
            <button type="submit" class="btn-submit">
              <span>Kirim Kritik & Saran</span>
              <i class="bi bi-send"></i>
            </button>
          </form>
        </div>
      </div>
    </div>

  </div>
</section>

@endsection

@push('styles')
<style>
  .suggestion {
    padding: 80px 0;
    background: var(--surface-color);
  }

  .alert {
    padding: 1rem 1.5rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .alert-success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
    border: 2px solid #10b981;
  }

  .alert-success i {
    color: #10b981;
    font-size: 1.25rem;
  }

  .alert-danger {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
    border: 2px solid #ef4444;
  }

  .alert-danger i {
    color: #ef4444;
    font-size: 1.25rem;
  }

  .alert-danger ul {
    list-style: none;
    padding-left: 0;
  }

  .suggestion-form-card {
    background: white;
    border-radius: 16px;
    padding: 2.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  }

  .suggestion-form-card h3 {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    color: var(--heading-color);
    font-weight: 600;
    text-align: center;
  }

  .form-description {
    text-align: center;
    color: color-mix(in srgb, var(--default-color), transparent 30%);
    margin-bottom: 2rem;
  }

  .suggestion-form .form-group {
    margin-bottom: 1.5rem;
  }

  .suggestion-form label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--heading-color);
  }

  .suggestion-form .required {
    color: #ef4444;
  }

  .suggestion-form .form-control {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid color-mix(in srgb, var(--default-color), transparent 85%);
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: var(--surface-color);
    color: var(--default-color);
  }

  .suggestion-form .form-control:focus {
    outline: none;
    border-color: var(--accent-color);
    box-shadow: 0 0 0 3px color-mix(in srgb, var(--accent-color), transparent 90%);
  }

  .suggestion-form .form-control.is-invalid {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
  }

  .invalid-feedback {
    color: #ef4444;
    font-size: 0.875rem;
    margin-top: 0.375rem;
  }

  .suggestion-form textarea.form-control {
    resize: vertical;
    min-height: 120px;
  }

  /* Captcha Styles */
  .captcha-group {
    background: color-mix(in srgb, var(--surface-color), transparent 50%);
    padding: 1.5rem;
    border-radius: 8px;
    border: 2px solid color-mix(in srgb, var(--default-color), transparent 90%);
  }

  .captcha-wrapper {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
  }

  .captcha-image img {
    border-radius: 8px;
    border: 2px solid color-mix(in srgb, var(--default-color), transparent 85%);
  }

  .btn-refresh-captcha {
    padding: 0.75rem 1rem;
    background: var(--surface-color);
    border: 2px solid color-mix(in srgb, var(--default-color), transparent 85%);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    color: var(--default-color);
  }

  .btn-refresh-captcha:hover {
    border-color: var(--accent-color);
    background: color-mix(in srgb, var(--accent-color), transparent 95%);
  }

  .btn-refresh-captcha i {
    font-size: 1.25rem;
    transition: transform 0.3s ease;
  }

  .btn-refresh-captcha:hover i {
    transform: rotate(180deg);
  }

  .btn-submit {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    width: 100%;
    padding: 1rem 2rem;
    background: linear-gradient(135deg, #313575 0%, #183152 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(49, 53, 117, 0.3);
  }

  .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(49, 53, 117, 0.4);
  }

  .btn-submit i {
    transition: transform 0.3s ease;
  }

  .btn-submit:hover i {
    transform: translateX(4px);
  }

  @media (max-width: 768px) {
    .suggestion-form-card {
      padding: 1.5rem;
    }

    .captcha-wrapper {
      flex-direction: column;
      align-items: flex-start;
    }
  }
</style>
@endpush

@push('scripts')
<script>
  function refreshCaptcha() {
    const captchaImage = document.getElementById('captcha-image');
    if (captchaImage) {
      captchaImage.src = '/captcha/flat?' + Date.now();
    }
  }
</script>
@endpush
