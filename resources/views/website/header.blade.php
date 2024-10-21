<div class="header_section">
    <div class="container">
       <nav class="navbar navbar-expand-lg navbar-light bg-light">
               <div class="logo"><a href="/"><img src="{{ asset('website/images/logo3.png')}}"></a></div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
             <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <a class="{{ Route::is('index-page') ? 'nav-link nav-link-hover' : 'nav-link' }}" href="/">Home</a>
                </li>
                {{-- <li class="nav-item">
                   <a class="nav-link" href="/">services</a>
                </li> --}}
                <li class="nav-item">
                   <a class="{{ Route::is('about-page') ? 'nav-link nav-link-hover' : 'nav-link' }}" href="{{ route('about-page') }}">About</a>
                </li>
                {{-- <li class="nav-item">
                   <a class="nav-link" href="/">Shop</a>
                </li> --}}
                <li class="nav-item">
                   <a class="{{ Route::is('contact-page') ? 'nav-link nav-link-hover' : 'nav-link' }}" href="{{ route('contact-page') }}">Contact</a>
                </li>
             </ul>
             <form class="form-inline my-2 my-lg-0">
                <div class="search_icon">
                   <ul>
                           {{-- <li><a href="#"><img src="{{ asset('website/images/search-icon.png')}}"></a></li> --}}
                      <li><a href="{{ route('dashboard') }}">LOGIN</a></li>
                   </ul>
                </div>
             </form>
          </div>
       </nav>
    </div>
