@extends('layouts.unipulse')

@section('title', 'Guest Book - SMANeka')
@section('description', 'Buku Tamu SMANeka - Tinggalkan pesan dan kesan Anda')

@section('content')

<!-- Guest Book Section -->
<section id="guestbook" class="guestbook section">
  <div class="container">
    
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2>Guest Book</h2>
      <p>Tinggalkan pesan dan kesan Anda selama berkunjung di SMANeka</p>
    </div><!-- End Section Title -->

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success mb-4" data-aos="fade-in">
      <i class="bi bi-check-circle-fill"></i>
      <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="row gy-4">
      <!-- Guest Book Form -->
      <div class="col-lg-5" data-aos="fade-right">
        <div class="guestbook-form-card">
          <h3>Tulis Pesan</h3>
          <form action="{{ route('guestbook.submit') }}" method="POST" class="guestbook-form">
            @csrf
            <div class="form-group">
              <label for="name">Nama Lengkap <span class="required">*</span></label>
              <input type="text" id="name" name="name" class="form-control" required>
            </div>
            
            <div class="form-group">
              <label for="position">Instansi/Jabatan</label>
              <input type="text" id="position" name="position" class="form-control">
            </div>
            
            <div class="form-group">
              <label for="address">Alamat</label>
              <textarea id="address" name="address" rows="2" class="form-control"></textarea>
            </div>
            
            <div class="form-group">
              <label for="purpose">Tujuan Kunjungan <span class="required">*</span></label>
              <textarea id="purpose" name="purpose" rows="4" class="form-control" required></textarea>
            </div>
            
            <button type="submit" class="btn-submit">
              <span>Kirim Pesan</span>
              <i class="bi bi-send"></i>
            </button>
          </form>
        </div>
      </div>

      <!-- Guest Book Entries -->
      <div class="col-lg-7" data-aos="fade-left">
        <div class="guestbook-entries">
          <h3>Pesan Terbaru</h3>
          
          @forelse($guestbooks as $guestbook)
          <div class="guestbook-entry" data-aos="fade-up">
            <div class="entry-header">
              <div class="entry-avatar">
                {{ strtoupper(substr($guestbook->name, 0, 1)) }}
              </div>
              <div class="entry-info">
                <h4>{{ $guestbook->name }}</h4>
                @if($guestbook->position)
                <span class="entry-position">{{ $guestbook->position }}</span>
                @endif
                <span class="entry-date">
                  <i class="bi bi-calendar3"></i>
                  {{ $guestbook->created_at->format('d M Y') }}
                </span>
              </div>
            </div>
            @if($guestbook->address)
            <div class="entry-address">
              <i class="bi bi-geo-alt"></i>
              <span>{{ $guestbook->address }}</span>
            </div>
            @endif
            <div class="entry-purpose">
              <strong>Tujuan:</strong>
              <p>{{ $guestbook->purpose }}</p>
            </div>
          </div>
          @empty
          <div class="no-entries text-center py-5">
            <i class="bi bi-book" style="font-size: 4rem; color: #ccc;"></i>
            <p class="text-muted mt-3">Belum ada pesan tamu.</p>
          </div>
          @endforelse
        </div>
      </div>
    </div>

  </div>
</section>

@endsection

@push('styles')
<style>
  .guestbook {
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

  .guestbook-form-card {
    background: white;
    border-radius: 16px;
    padding: 2.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    position: sticky;
    top: 100px;
  }

  .guestbook-form-card h3 {
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
    color: var(--heading-color);
    font-weight: 600;
  }

  .guestbook-form .form-group {
    margin-bottom: 1.5rem;
  }

  .guestbook-form label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--heading-color);
  }

  .guestbook-form .required {
    color: #ef4444;
  }

  .guestbook-form .form-control {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid color-mix(in srgb, var(--default-color), transparent 85%);
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: var(--surface-color);
    color: var(--default-color);
  }

  .guestbook-form .form-control:focus {
    outline: none;
    border-color: var(--accent-color);
    box-shadow: 0 0 0 3px color-mix(in srgb, var(--accent-color), transparent 90%);
  }

  .guestbook-form textarea.form-control {
    resize: vertical;
    min-height: 80px;
  }

  .btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
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

  .guestbook-entries {
    background: white;
    border-radius: 16px;
    padding: 2.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  }

  .guestbook-entries h3 {
    font-size: 1.5rem;
    margin-bottom: 2rem;
    color: var(--heading-color);
    font-weight: 600;
  }

  .guestbook-entry {
    background: color-mix(in srgb, var(--accent-color), transparent 97%);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border-left: 4px solid var(--accent-color);
    transition: all 0.3s ease;
  }

  .guestbook-entry:hover {
    transform: translateX(4px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
  }

  .entry-header {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
    align-items: center;
  }

  .entry-avatar {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #E8A202 0%, #d08a02 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    font-weight: bold;
    flex-shrink: 0;
  }

  .entry-info h4 {
    font-size: 1.125rem;
    margin: 0 0 0.25rem;
    color: var(--heading-color);
    font-weight: 600;
  }

  .entry-position {
    display: block;
    font-size: 0.875rem;
    color: var(--accent-color);
    font-weight: 600;
    margin-bottom: 0.25rem;
  }

  .entry-date {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8125rem;
    color: color-mix(in srgb, var(--default-color), transparent 30%);
  }

  .entry-date i {
    font-size: 0.875rem;
  }

  .entry-address {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: color-mix(in srgb, var(--default-color), transparent 20%);
    margin-bottom: 0.75rem;
  }

  .entry-address i {
    color: var(--accent-color);
  }

  .entry-purpose {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid color-mix(in srgb, var(--accent-color), transparent 85%);
  }

  .entry-purpose strong {
    display: block;
    font-size: 0.875rem;
    color: var(--heading-color);
    margin-bottom: 0.5rem;
  }

  .entry-purpose p {
    font-size: 0.9375rem;
    color: color-mix(in srgb, var(--default-color), transparent 10%);
    line-height: 1.7;
    margin: 0;
  }

  .no-entries i {
    opacity: 0.3;
  }

  @media (max-width: 992px) {
    .guestbook-form-card {
      position: static;
    }
  }

  @media (max-width: 768px) {
    .guestbook-form-card,
    .guestbook-entries {
      padding: 1.5rem;
    }

    .entry-header {
      flex-direction: column;
      text-align: center;
    }

    .entry-avatar {
      margin: 0 auto;
    }
  }
</style>
@endpush
