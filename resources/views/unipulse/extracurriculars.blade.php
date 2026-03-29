@extends('layouts.unipulse')

@section('title', 'Ekstrakurikuler - SMANeka')
@section('description', 'Daftar Ekstrakurikuler SMANeka - Kembangkan bakat dan minat Anda')

@section('content')

<!-- Extracurricular Section -->
<section id="extracurricular" class="extracurricular section">
  <div class="container">
    
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2>Ekstrakurikuler</h2>
      <p>Kembangkan bakat dan minat melalui berbagai kegiatan ekstrakurikuler</p>
    </div><!-- End Section Title -->

    <div class="row gy-4" data-aos="fade-up" data-aos-delay="100">
      @forelse($extracurriculars as $extracurricular)
      <div class="col-lg-3 col-md-6">
        <div class="extracurricular-card">
          <div class="extracurricular-img">
            @if($extracurricular->image)
            <img src="{{ asset('storage/' . $extracurricular->image) }}" alt="{{ $extracurricular->name }}" class="img-fluid">
            @else
            <img src="{{ asset('assets/img/education/education-2.webp') }}" alt="{{ $extracurricular->name }}" class="img-fluid">
            @endif
            <div class="extracurricular-overlay">
              <div class="overlay-content">
                <i class="bi bi-people-fill"></i>
                <span>Gabung Sekarang</span>
              </div>
            </div>
          </div>
          <div class="extracurricular-content">
            <h4>{{ $extracurricular->name }}</h4>
            <p>{{ Str::limit($extracurricular->description, 100) }}</p>
            <a href="#" class="extracurricular-link" onclick="openExtracurricularModal({{ $extracurricular->id }}); return false;">
              <span>Lihat Detail</span>
              <i class="bi bi-chevron-right"></i>
            </a>
          </div>
        </div>
      </div>
      @empty
      <div class="col-12">
        <div class="no-extracurricular text-center py-5">
          <i class="bi bi-trophy" style="font-size: 4rem; color: #ccc;"></i>
          <p class="text-muted mt-3">Belum ada ekstrakurikuler yang terdaftar.</p>
        </div>
      </div>
      @endforelse
    </div>

  </div>
</section>

<!-- Extracurricular Modal -->
<div class="modal fade" id="extracurricularModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="extracurricular-modal-content">
          <div class="modal-img-wrapper">
            <img id="modalExtracurricularImg" src="" alt="" class="img-fluid">
          </div>
          <div class="modal-info">
            <h2 id="modalExtracurricularName"></h2>
            <p id="modalExtracurricularDesc"></p>
            <div class="modal-features">
              <h4>Manfaat Bergabung:</h4>
              <ul>
                <li><i class="bi bi-check-circle-fill"></i> Mengembangkan bakat dan minat</li>
                <li><i class="bi bi-check-circle-fill"></i> Melatih kepemimpinan dan teamwork</li>
                <li><i class="bi bi-check-circle-fill"></i> Memperluas relasi dan pertemanan</li>
                <li><i class="bi bi-check-circle-fill"></i> Meningkatkan kreativitas dan skill</li>
                <li><i class="bi bi-check-circle-fill"></i> Berpartisipasi dalam kompetisi</li>
              </ul>
            </div>
            <div class="modal-cta">
              @php
                $whatsappNumber = setting('contact_whatsapp', '');
                $cleanNumber = preg_replace('/[^0-9]/', '', $whatsappNumber);
                
                if (strlen($cleanNumber) > 0) {
                  if (str_starts_with($cleanNumber, '0')) {
                    $cleanNumber = '62' . substr($cleanNumber, 1);
                  }
                  if (!str_starts_with($cleanNumber, '62') && strlen($cleanNumber) >= 10) {
                    $cleanNumber = '62' . $cleanNumber;
                  }
                  $whatsappBaseLink = 'https://wa.me/' . $cleanNumber . '?text=';
                } else {
                  $whatsappBaseLink = '#';
                }
              @endphp
              <a href="{{ $whatsappBaseLink }}" target="_blank" rel="noopener" class="btn-join" id="btnGabungWhatsApp" data-base-text="Halo, saya tertarik untuk bergabung dengan ekstrakurikuler ">
                <i class="bi bi-whatsapp"></i>
                <span>Gabung Sekarang via WhatsApp</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  // Store all extracurriculars data
  const extracurriculars = @json($extracurriculars);
  let extracurricularModal = null;

  function openExtracurricularModal(extracurricularId) {
    console.log('Opening modal for extracurricular ID:', extracurricularId);
    
    // Find extracurricular index
    const currentIndex = extracurriculars.findIndex(e => e.id === extracurricularId);
    
    if (currentIndex === -1) {
      console.error('Extracurricular not found!');
      return;
    }

    // Populate modal
    populateModal(extracurriculars[currentIndex]);
    
    // Initialize modal if not already initialized
    if (!extracurricularModal) {
      extracurricularModal = new bootstrap.Modal(document.getElementById('extracurricularModal'));
    }

    // Show modal
    extracurricularModal.show();
  }

  function populateModal(extracurricular) {
    // Set image
    const imgSrc = extracurricular.image ? `{{ asset('storage/') }}/${extracurricular.image}` : `{{ asset('assets/img/education/education-2.webp') }}`;
    document.getElementById('modalExtracurricularImg').src = imgSrc;

    // Set name
    document.getElementById('modalExtracurricularName').textContent = extracurricular.name;

    // Set description
    document.getElementById('modalExtracurricularDesc').textContent = extracurricular.description || 'Deskripsi belum tersedia.';
    
    // Update WhatsApp link with extracurricular name
    const btnGabung = document.getElementById('btnGabungWhatsApp');
    if (btnGabung && btnGabung.href !== '#') {
      const baseText = btnGabung.getAttribute('data-base-text') || 'Halo, saya tertarik untuk bergabung dengan ekstrakurikuler ';
      const fullMessage = encodeURIComponent(baseText + extracurricular.name);
      const baseHref = btnGabung.href.split('?')[0];
      btnGabung.href = baseHref + '?text=' + fullMessage;
    }
  }

  // Make function globally accessible
  window.openExtracurricularModal = openExtracurricularModal;
</script>
@endpush

@push('styles')
<style>
  .extracurricular {
    padding: 80px 0;
    background: var(--surface-color);
  }

  .extracurricular-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.4s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .extracurricular-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
  }

  .extracurricular-img {
    position: relative;
    overflow: hidden;
    height: 220px;
  }

  .extracurricular-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
  }

  .extracurricular-card:hover .extracurricular-img img {
    transform: scale(1.1);
  }

  .extracurricular-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(49, 53, 117, 0.9) 0%, rgba(24, 49, 82, 0.9) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.4s ease;
  }

  .extracurricular-card:hover .extracurricular-overlay {
    opacity: 1;
  }

  .overlay-content {
    text-align: center;
    color: white;
    transform: translateY(20px);
    transition: transform 0.4s ease;
  }

  .extracurricular-card:hover .overlay-content {
    transform: translateY(0);
  }

  .overlay-content i {
    font-size: 2rem;
    display: block;
    margin-bottom: 0.5rem;
  }

  .overlay-content span {
    font-size: 1rem;
    font-weight: 600;
  }

  .extracurricular-content {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
  }

  .extracurricular-content h4 {
    font-size: 1.25rem;
    margin-bottom: 0.75rem;
    color: var(--heading-color);
    font-weight: 600;
  }

  .extracurricular-content p {
    font-size: 0.9375rem;
    color: color-mix(in srgb, var(--default-color), transparent 20%);
    line-height: 1.6;
    margin-bottom: 1rem;
    flex: 1;
  }

  .extracurricular-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--accent-color);
    font-weight: 600;
    font-size: 0.9375rem;
    text-decoration: none;
    transition: all 0.3s ease;
  }

  .extracurricular-link:hover {
    color: var(--accent-color-dark);
    gap: 0.75rem;
  }

  .extracurricular-link i {
    transition: transform 0.3s ease;
  }

  .extracurricular-link:hover i {
    transform: translateX(4px);
  }

  .no-extracurricular i {
    opacity: 0.3;
  }

  /* Modal Styles */
  #extracurricularModal .modal-content {
    border-radius: 16px;
    overflow: hidden;
  }

  #extracurricularModal .modal-header {
    border: none;
    padding: 1rem 1.5rem;
    position: absolute;
    top: 0;
    right: 0;
    z-index: 10;
    background: transparent;
  }

  #extracurricularModal .btn-close {
    background: rgba(255, 255, 255, 0.9);
    opacity: 1;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
  }

  #extracurricularModal .btn-close:hover {
    background: white;
    transform: scale(1.1);
  }

  .extracurricular-modal-content {
    display: flex;
    flex-direction: column;
  }

  .modal-img-wrapper {
    width: 100%;
    height: 300px;
    overflow: hidden;
    background: #f8f9fa;
  }

  .modal-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .modal-info {
    padding: 2rem;
  }

  .modal-info h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: var(--heading-color);
    font-weight: 700;
  }

  .modal-info p {
    font-size: 1.0625rem;
    line-height: 1.8;
    color: color-mix(in srgb, var(--default-color), transparent 10%);
    margin-bottom: 2rem;
  }

  .modal-features h4 {
    font-size: 1.25rem;
    margin-bottom: 1rem;
    color: var(--heading-color);
    font-weight: 600;
  }

  .modal-features ul {
    list-style: none;
    padding: 0;
    margin: 0 0 2rem;
  }

  .modal-features ul li {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
    font-size: 1rem;
    color: color-mix(in srgb, var(--default-color), transparent 15%);
  }

  .modal-features ul li i {
    color: var(--accent-color);
    font-size: 1.25rem;
    margin-top: 0.25rem;
  }

  .modal-cta {
    text-align: center;
    padding-top: 1.5rem;
    border-top: 2px solid color-mix(in srgb, var(--accent-color), transparent 85%);
  }

  .btn-join {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 2.5rem;
    background: linear-gradient(135deg, #313575 0%, #183152 100%);
    color: white;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(49, 53, 117, 0.3);
  }

  .btn-join:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(49, 53, 117, 0.4);
  }

  .btn-join i {
    font-size: 1.25rem;
  }

  @media (min-width: 768px) {
    .extracurricular-modal-content {
      flex-direction: row;
    }

    .modal-img-wrapper {
      width: 50%;
      height: auto;
      min-height: 500px;
    }

    .modal-info {
      width: 50%;
      padding: 3rem;
    }
  }

  @media (max-width: 768px) {
    .modal-info h2 {
      font-size: 1.5rem;
    }

    .modal-info p {
      font-size: 1rem;
    }

    .modal-features ul li {
      font-size: 0.9375rem;
    }
  }
</style>
@endpush
