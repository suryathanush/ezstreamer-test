@php
use App\Models\Stream;
$stream_count = Stream::count();
@endphp
<x-app-layout>
        <!-- Errors -->
        @if($errors->any())
        <p class="text-red-500 text-md mt-1">Validation Errors for most recent save:</p>
        @error('stream_name')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        @error('description')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        @error('input_url')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        @error('youtube_url')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        @error('youtube_backup_url')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        @error('standby_stream_img')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        @error('youtube_key')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        @error('send_audio')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        <!-- End Errors-->
        @endif

        <!-- Edit each stream -->
        <div class="mt-8">
            <div class="shadow-xl rounded-lg bg-indigo-50 max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <!DOCTYPE html>
<html lang="en">
<head>

<style>
    body {
      background-color: #f8f9fa;
    }

    .section-heading {
      color: #343a40;
      text-transform: uppercase;
      font-size: 2rem;
      margin-bottom: 40px;
    }

    .team-member {
      margin-bottom: 50px;
    }

    .team-member img {
      width: 200px;
      height: 200px;
      border-radius: 50%;
      margin-bottom: 20px;
    }

    .team-member h4 {
      color: #343a40;
      font-size: 1.5rem;
      margin-bottom: 10px;
    }

    .team-member p {
      color: #6c757d;
      font-size: 1.2rem;
    }

    .text-muted {
      color: #6c757d;
    }
  </style>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us</title>
  <!-- Bootstrap CSS link -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  

  <!-- About Us Section -->
  <div class="container mt-5">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h2 class="section-heading text-uppercase">Welcome to Our Company</h2>
        <p class="text-muted lead">At Our Company, we are dedicated to providing high-quality products/services that meet your needs. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam.</p>
      </div>
    </div>
  </div>

  <!-- Team Section -->
  <div class="container mt-5">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h2 class="section-heading text-uppercase">Meet Our Team</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="team-member text-center">
          <img class="mx-auto" src="https://placehold.it/200x200" alt="John Doe">
          <h4>John Doe</h4>
          <p class="text-muted">CEO & Founder</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="team-member text-center">
          <img class="mx-auto" src="https://placehold.it/200x200" alt="Jane Doe">
          <h4>Jane Doe</h4>
          <p class="text-muted">Chief Marketing Officer</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="team-member text-center">
          <img class="mx-auto" src="https://placehold.it/200x200" alt="Bob Smith">
          <h4>Bob Smith</h4>
          <p class="text-muted">Lead Developer</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and Popper.js links (required for Bootstrap components) -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
 
            </div>
        </div>

       

       
</x-app-layout>
