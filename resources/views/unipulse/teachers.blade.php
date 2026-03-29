@extends('layouts.unipulse')

@section('title', 'Guru & Staff - SMANeka')
@section('description', 'Profil Guru dan Staff Pengajar SMANeka')

@section('content')

<!-- Teachers Section -->
<section id="teachers" class="teachers section">
  <div class="container">
    
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2>Guru & Staff</h2>
      <p>Kenali lebih dekat para pendidik profesional yang berkomitmen untuk kesuksesan siswa</p>
    </div><!-- End Section Title -->

    <div class="row gy-4" id="teachersGrid" data-aos="fade-up" data-aos-delay="100">
      @foreach($teachers as $teacher)
      <div class="col-lg-3 col-md-6">
        <div class="teacher-card" data-teacher-id="{{ $teacher->id }}" style="cursor: pointer;" onclick="openTeacherModal({{ $teacher->id }})">
          <div class="teacher-img">
            @if($teacher->photo)
            <img src="{{ asset('storage/' . $teacher->photo) }}" alt="{{ $teacher->name }}" class="img-fluid">
            @else
            <img src="{{ asset('assets/img/person/person-1.webp') }}" alt="{{ $teacher->name }}" class="img-fluid">
            @endif
          </div>
          <div class="teacher-info">
            <h4>{{ $teacher->name }}</h4>
            @if($teacher->position)
            <span class="teacher-position">{{ $teacher->position }}</span>
            @endif
            @if($teacher->subject)
            <span class="teacher-subject">{{ $teacher->subject }}</span>
            @endif
          </div>
          <div class="teacher-overlay">
            <div class="view-profile">
              <i class="bi bi-eye"></i>
              <span>Lihat Profil</span>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>

  </div>
</section>

<!-- Teacher Detail Modal -->
<div class="modal fade" id="teacherModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="teacher-modal-content">
          <!-- Navigation Arrows -->
          <button class="modal-nav prev" onclick="prevTeacher()">
            <i class="bi bi-chevron-left"></i>
          </button>
          <button class="modal-nav next" onclick="nextTeacher()">
            <i class="bi bi-chevron-right"></i>
          </button>

          <div class="row g-0">
            <div class="col-lg-5">
              <div class="teacher-modal-img">
                <img id="modalTeacherImg" src="" alt="" class="img-fluid">
              </div>
            </div>
            <div class="col-lg-7">
              <div class="teacher-modal-info">
                <h2 id="modalTeacherName"></h2>
                <div class="teacher-meta">
                  <div id="modalTeacherPosition" class="meta-item">
                    <i class="bi bi-briefcase"></i>
                    <span></span>
                  </div>
                  <div id="modalTeacherSubject" class="meta-item">
                    <i class="bi bi-book"></i>
                    <span></span>
                  </div>
                </div>
                <div class="teacher-bio">
                  <h4>Tentang</h4>
                  <p id="modalTeacherBio"></p>
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
  </div>
</div>

@endsection

@push('scripts')
<script>
  // Store all teachers data
  const teachers = @json($teachers);
  let currentTeacherIndex = 0;

  function openTeacherModal(teacherId) {
    // Find teacher index
    currentTeacherIndex = teachers.findIndex(t => t.id === teacherId);
    
    // Populate modal
    populateModal();
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('teacherModal'));
    modal.show();
  }

  function populateModal() {
    const teacher = teachers[currentTeacherIndex];
    
    // Set image
    const imgSrc = teacher.photo ? `{{ asset('storage/') }}/${teacher.photo}` : `{{ asset('assets/img/person/person-1.webp') }}`;
    document.getElementById('modalTeacherImg').src = imgSrc;
    
    // Set name
    document.getElementById('modalTeacherName').textContent = teacher.name;
    
    // Set position
    const positionEl = document.getElementById('modalTeacherPosition');
    if (teacher.position) {
      positionEl.querySelector('span').textContent = teacher.position;
      positionEl.style.display = 'flex';
    } else {
      positionEl.style.display = 'none';
    }
    
    // Set subject
    const subjectEl = document.getElementById('modalTeacherSubject');
    if (teacher.subject) {
      subjectEl.querySelector('span').textContent = teacher.subject;
      subjectEl.style.display = 'flex';
    } else {
      subjectEl.style.display = 'none';
    }
    
    // Set bio
    const bioEl = document.getElementById('modalTeacherBio');
    if (teacher.bio) {
      bioEl.textContent = teacher.bio;
    } else {
      bioEl.textContent = 'Informasi biografi belum tersedia.';
    }
    
    // Set counter
    document.getElementById('modalCounter').textContent = `${currentTeacherIndex + 1} / ${teachers.length}`;
  }

  function nextTeacher() {
    currentTeacherIndex = (currentTeacherIndex + 1) % teachers.length;
    populateModal();
  }

  function prevTeacher() {
    currentTeacherIndex = (currentTeacherIndex - 1 + teachers.length) % teachers.length;
    populateModal();
  }

  // Keyboard navigation
  document.addEventListener('keydown', function(e) {
    if (e.key === 'ArrowRight') {
      nextTeacher();
    } else if (e.key === 'ArrowLeft') {
      prevTeacher();
    }
  });
</script>
@endpush

@push('styles')
<style>
  .teachers {
    padding: 80px 0;
    background: var(--surface-color);
  }

  .teacher-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.4s ease;
    position: relative;
  }

  .teacher-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
  }

  .teacher-img {
    position: relative;
    overflow: hidden;
    height: 280px;
  }

  .teacher-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
  }

  .teacher-card:hover .teacher-img img {
    transform: scale(1.1);
  }

  .teacher-info {
    padding: 1.5rem;
    text-align: center;
  }

  .teacher-info h4 {
    font-size: 1.25rem;
    margin: 0 0 0.5rem;
    color: var(--heading-color);
    font-weight: 600;
  }

  .teacher-position {
    display: block;
    font-size: 0.9375rem;
    color: var(--accent-color);
    font-weight: 600;
    margin-bottom: 0.25rem;
  }

  .teacher-subject {
    display: block;
    font-size: 0.875rem;
    color: color-mix(in srgb, var(--default-color), transparent 30%);
  }

  .teacher-overlay {
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

  .teacher-card:hover .teacher-overlay {
    opacity: 1;
  }

  .view-profile {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: white;
    font-size: 1rem;
    font-weight: 600;
    transform: translateY(20px);
    transition: transform 0.4s ease;
  }

  .teacher-card:hover .view-profile {
    transform: translateY(0);
  }

  .view-profile i {
    font-size: 1.25rem;
  }

  /* Modal Styles */
  #teacherModal .modal-content {
    border-radius: 16px;
    overflow: hidden;
  }

  #teacherModal .modal-header {
    border: none;
    padding: 1rem 1.5rem;
    position: absolute;
    top: 0;
    right: 0;
    z-index: 10;
    background: transparent;
  }

  #teacherModal .btn-close {
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

  #teacherModal .btn-close:hover {
    background: white;
    transform: scale(1.1);
  }

  .teacher-modal-content {
    position: relative;
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
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }

  .modal-nav:hover {
    background: white;
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
  }

  .modal-nav.prev {
    left: 20px;
  }

  .modal-nav.next {
    right: 20px;
  }

  .modal-nav i {
    font-size: 1.5rem;
    color: var(--primary-color);
  }

  .teacher-modal-img {
    height: 100%;
    min-height: 500px;
  }

  .teacher-modal-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .teacher-modal-info {
    padding: 3rem;
    background: white;
  }

  .teacher-modal-info h2 {
    font-size: 2rem;
    margin-bottom: 1.5rem;
    color: var(--heading-color);
    font-weight: 700;
  }

  .teacher-meta {
    display: flex;
    gap: 2rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
  }

  .meta-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1rem;
    color: color-mix(in srgb, var(--default-color), transparent 20%);
  }

  .meta-item i {
    font-size: 1.25rem;
    color: var(--accent-color);
  }

  .teacher-bio h4 {
    font-size: 1.25rem;
    margin-bottom: 1rem;
    color: var(--heading-color);
    font-weight: 600;
  }

  .teacher-bio p {
    font-size: 1.0625rem;
    line-height: 1.8;
    color: color-mix(in srgb, var(--default-color), transparent 10%);
  }

  .modal-counter {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 2px solid color-mix(in srgb, var(--accent-color), transparent 85%);
    text-align: center;
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--accent-color);
  }

  @media (max-width: 992px) {
    .teacher-modal-img {
      min-height: 300px;
    }

    .teacher-modal-info {
      padding: 2rem;
    }

    .teacher-modal-info h2 {
      font-size: 1.75rem;
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
  }
</style>
@endpush
