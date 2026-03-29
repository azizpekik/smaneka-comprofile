@extends('layouts.unipulse')

@section('title', $page->title . ' - SMANeka')
@section('description', Str::limit(strip_tags($page->content), 160))

@section('content')

<!-- Page Content Section -->
<section id="page-content" class="page-content section">
  <div class="container">
    
    <!-- Page Header -->
    <div class="page-header" data-aos="fade-up">
      <h1>{{ $page->title }}</h1>
    </div>

    <!-- Page Body -->
    <div class="page-body" data-aos="fade-up" data-aos-delay="100">
      <div class="content-wrapper">
        {!! $page->content !!}
      </div>
    </div>

  </div>
</section>

@endsection

@push('styles')
<style>
  .page-content {
    padding: 80px 0;
    background: var(--surface-color);
  }

  .page-header {
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 3px solid var(--accent-color);
  }

  .page-header h1 {
    font-size: 2.5rem;
    color: var(--heading-color);
    margin: 0;
    font-weight: 700;
  }

  .page-body {
    max-width: 900px;
  }

  .content-wrapper {
    font-size: 1.0625rem;
    line-height: 1.8;
    color: color-mix(in srgb, var(--default-color), transparent 10%);
  }

  .content-wrapper h2,
  .content-wrapper h3,
  .content-wrapper h4 {
    margin-top: 2.5rem;
    margin-bottom: 1rem;
    color: var(--heading-color);
    font-weight: 600;
  }

  .content-wrapper h2 {
    font-size: 2rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid color-mix(in srgb, var(--accent-color), transparent 80%);
  }

  .content-wrapper h3 {
    font-size: 1.5rem;
  }

  .content-wrapper h4 {
    font-size: 1.25rem;
  }

  .content-wrapper p {
    margin-bottom: 1.5rem;
  }

  .content-wrapper ul,
  .content-wrapper ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
  }

  .content-wrapper li {
    margin-bottom: 0.75rem;
  }

  .content-wrapper img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1.5rem 0;
  }

  .content-wrapper blockquote {
    border-left: 4px solid var(--accent-color);
    padding-left: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    color: color-mix(in srgb, var(--default-color), transparent 20%);
  }

  .content-wrapper table {
    width: 100%;
    border-collapse: collapse;
    margin: 1.5rem 0;
  }

  .content-wrapper th,
  .content-wrapper td {
    padding: 1rem;
    border: 1px solid color-mix(in srgb, var(--default-color), transparent 80%);
    text-align: left;
  }

  .content-wrapper th {
    background: color-mix(in srgb, var(--accent-color), transparent 95%);
    font-weight: 600;
  }

  .content-wrapper a {
    color: var(--accent-color);
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .content-wrapper a:hover {
    color: var(--accent-color-dark);
    text-decoration: underline;
  }

  @media (max-width: 768px) {
    .page-header h1 {
      font-size: 2rem;
    }

    .content-wrapper {
      font-size: 1rem;
    }
  }
</style>
@endpush
