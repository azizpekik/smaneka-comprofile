@extends('layouts.unipulse')

@section('title', 'Galeri - SMANeka')
@section('description', 'Galeri Foto Kegiatan SMANeka')

@section('content')

<!-- Gallery Section -->
<section id="gallery" class="gallery section">
  <div class="container">
    
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2>Galeri Foto</h2>
      <p>Dokumentasi kegiatan dan momen-momen berharga di SMANeka</p>
    </div><!-- End Section Title -->

    <!-- Album Filter -->
    @if($albums->count() > 0)
    <div class="album-filter mb-5" data-aos="fade-down">
      <div class="d-flex flex-wrap gap-2 justify-content-center">
        <button class="album-pill active" onclick="filterAlbum('all')">
          Semua Album
        </button>
        @foreach($albums as $album)
        <button class="album-pill" onclick="filterAlbum({{ $album->id }})">
          {{ $album->name }}
        </button>
        @endforeach
      </div>
    </div>
    @endif

    <!-- Gallery Grid -->
    <div class="gallery-grid" data-aos="fade-up" data-aos-delay="100">
      @forelse($galleries as $photo)
      <div class="gallery-item" data-album="{{ $photo->album_id }}" data-aos="zoom-in">
        <div class="gallery-img-wrapper" onclick="openPhotoModal({{ $photo->id }})">
          <img src="{{ asset('storage/' . $photo->image_path) }}" alt="{{ $photo->caption ?? 'Gallery Photo' }}" class="img-fluid">
          <div class="gallery-overlay">
            <div class="overlay-content">
              <i class="bi bi-zoom-in"></i>
              <span>Lihat Foto</span>
            </div>
          </div>
        </div>
        @if($photo->caption)
        <div class="gallery-caption">
          <p>{{ Str::limit($photo->caption, 60) }}</p>
        </div>
        @endif
      </div>
      @empty
      <div class="no-photos text-center py-5">
        <i class="bi bi-camera" style="font-size: 4rem; color: #ccc;"></i>
        <p class="text-muted mt-3">Belum ada foto galeri.</p>
      </div>
      @endforelse
    </div>

    <!-- Pagination -->
    @if($galleries->hasPages())
    <div class="pagination-wrapper text-center mt-5" data-aos="fade-up">
      <nav aria-label="Gallery Pagination">
        <ul class="pagination-custom">
          {{-- Previous Button --}}
          @if($galleries->onFirstPage())
            <li class="page-item disabled">
              <span class="page-link"><i class="bi bi-chevron-left"></i> Prev</span>
            </li>
          @else
            <li class="page-item">
              <a class="page-link" href="{{ $galleries->previousPageUrl() }}"><i class="bi bi-chevron-left"></i> Prev</a>
            </li>
          @endif

          {{-- Page Numbers --}}
          @foreach($galleries->getUrlRange(1, $galleries->lastPage()) as $page => $url)
            @if($page == $galleries->currentPage())
              <li class="page-item active">
                <span class="page-link">{{ $page }}</span>
              </li>
            @else
              <li class="page-item">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
              </li>
            @endif
          @endforeach

          {{-- Next Button --}}
          @if($galleries->hasMorePages())
            <li class="page-item">
              <a class="page-link" href="{{ $galleries->nextPageUrl() }}">Next <i class="bi bi-chevron-right"></i></a>
            </li>
          @else
            <li class="page-item disabled">
              <span class="page-link">Next <i class="bi bi-chevron-right"></i></span>
            </li>
          @endif
        </ul>
      </nav>
    </div>
    @endif

  </div>
</section>

<!-- Photo Modal -->
<div class="modal fade" id="photoModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="photo-modal-content">
          <!-- Navigation Arrows -->
          <button class="modal-nav prev" onclick="prevPhoto()">
            <i class="bi bi-chevron-left"></i>
          </button>
          <button class="modal-nav next" onclick="nextPhoto()">
            <i class="bi bi-chevron-right"></i>
          </button>

          <div class="modal-photo-wrapper">
            <img id="modalPhotoImg" src="" alt="" class="img-fluid">
          </div>
          
          <div class="modal-photo-info">
            <h3 id="modalPhotoCaption"></h3>
            <div class="photo-meta">
              <span class="photo-album">
                <i class="bi bi-folder"></i>
                <span id="modalPhotoAlbum"></span>
              </span>
              <span class="photo-date">
                <i class="bi bi-calendar3"></i>
                <span id="modalPhotoDate"></span>
              </span>
            </div>
            <div class="modal-counter">
              <span id="modalCounter"></span>
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
  // Store all photos data
  const photos = @json($galleries->items());
  let currentPhotoIndex = 0;
  let photoModal = null;

  // Filter by Album
  function filterAlbum(albumId) {
    // Update active pill
    document.querySelectorAll('.album-pill').forEach(pill => {
      pill.classList.remove('active');
      if ((albumId === 'all' && pill.textContent.trim() === 'Semua Album') || 
          pill.getAttribute('onclick').includes(albumId)) {
        pill.classList.add('active');
      }
    });
    
    // Filter gallery items
    const items = document.querySelectorAll('.gallery-item');
    items.forEach(item => {
      const itemAlbum = item.getAttribute('data-album');
      if (albumId === 'all' || itemAlbum == albumId) {
        item.style.display = 'block';
        item.classList.remove('aos-animate');
        setTimeout(() => item.classList.add('aos-animate'), 50);
      } else {
        item.style.display = 'none';
      }
    });
  }

  function openPhotoModal(photoId) {
    console.log('Opening modal for photo ID:', photoId);
    
    // Find photo index
    currentPhotoIndex = photos.findIndex(p => p.id === photoId);
    
    if (currentPhotoIndex === -1) {
      console.error('Photo not found!');
      return;
    }

    // Populate modal
    populateModal();
    
    // Initialize modal if not already initialized
    if (!photoModal) {
      photoModal = new bootstrap.Modal(document.getElementById('photoModal'));
    }

    // Show modal
    photoModal.show();
  }

  function populateModal() {
    const photo = photos[currentPhotoIndex];
    
    // Set image
    const imgSrc = photo.image_path ? `{{ asset('storage/') }}/${photo.image_path}` : `{{ asset('assets/img/education/education-2.webp') }}`;
    document.getElementById('modalPhotoImg').src = imgSrc;
    
    // Set caption
    document.getElementById('modalPhotoCaption').textContent = photo.caption || 'Tidak ada keterangan';
    
    // Set album
    document.getElementById('modalPhotoAlbum').textContent = photo.album?.name || 'Umum';
    
    // Set date
    const date = new Date(photo.created_at);
    document.getElementById('modalPhotoDate').textContent = date.toLocaleDateString('id-ID', { 
      year: 'numeric', 
      month: 'long', 
      day: 'numeric' 
    });
    
    // Set counter
    document.getElementById('modalCounter').textContent = `${currentPhotoIndex + 1} / ${photos.length}`;
  }

  function nextPhoto() {
    currentPhotoIndex = (currentPhotoIndex + 1) % photos.length;
    populateModal();
  }

  function prevPhoto() {
    currentPhotoIndex = (currentPhotoIndex - 1 + photos.length) % photos.length;
    populateModal();
  }

  // Keyboard navigation
  document.addEventListener('keydown', function(e) {
    if (e.key === 'ArrowRight') {
      nextPhoto();
    } else if (e.key === 'ArrowLeft') {
      prevPhoto();
    }
  });

  // Make functions globally accessible
  window.openPhotoModal = openPhotoModal;
  window.nextPhoto = nextPhoto;
  window.prevPhoto = prevPhoto;
  window.filterAlbum = filterAlbum;
</script>
@endpush

@push('styles')
<style>
  .gallery {
    padding: 80px 0;
    background: var(--surface-color);
  }

  /* Album Filter */
  .album-filter {
    padding: 1.5rem 0;
  }

  .album-pill {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    background: var(--surface-color);
    color: var(--heading-color);
    border: 2px solid color-mix(in srgb, var(--default-color), transparent 85%);
    border-radius: 50px;
    font-size: 0.9375rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  }

  .album-pill:hover {
    background: var(--accent-color);
    color: white;
    border-color: var(--accent-color);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
  }

  .album-pill.active {
    background: linear-gradient(135deg, #313575 0%, #183152 100%);
    color: white;
    border-color: #313575;
    box-shadow: 0 4px 15px rgba(49, 53, 117, 0.3);
  }

  @media (max-width: 768px) {
    .album-filter {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }

    .album-filter .d-flex {
      flex-wrap: nowrap;
    }

    .album-pill {
      white-space: nowrap;
      padding: 0.5rem 1rem;
      font-size: 0.875rem;
    }
  }

  /* Gallery Grid */
  .gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
  }

  .gallery-item {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.4s ease;
  }

  .gallery-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
  }

  .gallery-img-wrapper {
    position: relative;
    overflow: hidden;
    height: 250px;
    cursor: pointer;
  }

  .gallery-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
  }

  .gallery-item:hover .gallery-img-wrapper img {
    transform: scale(1.1);
  }

  .gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(49, 53, 117, 0.85) 0%, rgba(24, 49, 82, 0.85) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.4s ease;
  }

  .gallery-item:hover .gallery-overlay {
    opacity: 1;
  }

  .overlay-content {
    text-align: center;
    color: white;
    transform: translateY(20px);
    transition: transform 0.4s ease;
  }

  .gallery-item:hover .overlay-content {
    transform: translateY(0);
  }

  .overlay-content i {
    font-size: 2.5rem;
    display: block;
    margin-bottom: 0.5rem;
  }

  .overlay-content span {
    font-size: 1rem;
    font-weight: 600;
  }

  .gallery-caption {
    padding: 1rem;
    background: white;
  }

  .gallery-caption p {
    font-size: 0.9375rem;
    color: color-mix(in srgb, var(--default-color), transparent 15%);
    margin: 0;
    line-height: 1.5;
  }

  .no-photos i {
    opacity: 0.3;
  }

  /* Custom Pagination */
  .pagination-wrapper {
    padding: 2rem 0;
  }

  .pagination-custom {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 0.5rem;
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .pagination-custom .page-item {
    margin: 0;
  }

  .pagination-custom .page-link,
  .pagination-custom .page-item.disabled .page-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    background: white;
    color: var(--heading-color);
    border: 2px solid color-mix(in srgb, var(--default-color), transparent 85%);
    border-radius: 8px;
    font-size: 0.9375rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  }

  .pagination-custom .page-link:hover {
    background: var(--accent-color);
    color: white;
    border-color: var(--accent-color);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
  }

  .pagination-custom .page-item.active .page-link {
    background: linear-gradient(135deg, #313575 0%, #183152 100%);
    color: white;
    border-color: #313575;
    box-shadow: 0 4px 15px rgba(49, 53, 117, 0.3);
  }

  .pagination-custom .page-item.disabled .page-link {
    opacity: 0.5;
    cursor: not-allowed;
    background: color-mix(in srgb, var(--default-color), transparent 95%);
    color: color-mix(in srgb, var(--heading-color), transparent 50%);
    border-color: color-mix(in srgb, var(--default-color), transparent 80%);
  }

  .pagination-custom .page-link i {
    font-size: 0.875rem;
  }

  @media (max-width: 576px) {
    .pagination-custom {
      gap: 0.25rem;
    }

    .pagination-custom .page-link {
      padding: 0.5rem 0.875rem;
      font-size: 0.8125rem;
    }

    .pagination-custom .page-link i {
      display: none;
    }
  }

  /* Modal Styles */
  #photoModal .modal-content {
    border-radius: 16px;
    overflow: hidden;
    background: #000;
  }

  #photoModal .modal-header {
    border: none;
    padding: 1rem 1.5rem;
    position: absolute;
    top: 0;
    right: 0;
    z-index: 10;
    background: transparent;
  }

  #photoModal .btn-close {
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

  #photoModal .btn-close:hover {
    background: white;
    transform: scale(1.1);
  }

  .photo-modal-content {
    position: relative;
    display: flex;
    flex-direction: column;
  }

  .modal-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.9);
    border: none;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 5;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
  }

  .modal-nav:hover {
    background: white;
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
  }

  .modal-nav.prev {
    left: 20px;
  }

  .modal-nav.next {
    right: 20px;
  }

  .modal-nav i {
    font-size: 1.5rem;
    color: #333;
  }

  .modal-photo-wrapper {
    width: 100%;
    background: #000;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .modal-photo-wrapper img {
    max-width: 100%;
    max-height: 70vh;
    object-fit: contain;
  }

  .modal-photo-info {
    padding: 2rem;
    background: white;
  }

  .modal-photo-info h3 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    color: var(--heading-color);
    font-weight: 600;
  }

  .photo-meta {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
  }

  .photo-album,
  .photo-date {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9375rem;
    color: color-mix(in srgb, var(--default-color), transparent 20%);
  }

  .photo-album i,
  .photo-date i {
    color: var(--accent-color);
    font-size: 1.125rem;
  }

  .modal-counter {
    padding-top: 1.5rem;
    border-top: 2px solid color-mix(in srgb, var(--accent-color), transparent 85%);
    text-align: center;
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--accent-color);
  }

  @media (min-width: 768px) {
    .photo-modal-content {
      flex-direction: row;
    }

    .modal-photo-wrapper {
      width: 70%;
      min-height: 500px;
    }

    .modal-photo-info {
      width: 30%;
      padding: 2.5rem;
    }
  }

  @media (max-width: 768px) {
    .modal-nav {
      width: 40px;
      height: 40px;
    }

    .modal-nav i {
      font-size: 1.25rem;
    }

    .modal-photo-info h3 {
      font-size: 1.25rem;
    }

    .photo-meta {
      gap: 1rem;
    }
  }
</style>
@endpush
