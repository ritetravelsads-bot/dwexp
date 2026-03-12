<body class="bg-white text-dark antialiased">
  <header class="fixed w-full z-50 bg-white backdrop-blur-md border-b border-borderGrey">
    <div class="container mx-auto px-4 h-20 flex items-center justify-between">
      <!-- Logo -->
      <a href="/">
       <img src="assets/img/logo.png" class="h-10 md:h-16" alt="Dwarka Expressway Logo">
      </a>
      <!-- Desktop Nav -->
      <nav class="hidden md:flex space-x-8 font-semibold text-sm uppercase tracking-wide">
        <a href="/" class="hover:text-primary transition">Home</a>
        <a href="/#residential-project" class="hover:text-primary transition">Projects</a>
        <a href="/#location" class="hover:text-primary transition">Connectivity</a>
        <a href="/#amenities" class="hover:text-primary transition">Amenities</a>
        <a href="/#contact" class="hover:text-primary transition">Contact</a>
        <a href="/about" class="hover:text-primary transition">About Us</a>
      </nav>
      <!-- Desktop CTA -->
      <Button onclick="showForm()" class="morph relative inline-block bg-dark rounded text-white md:px-4 px-2 py-2.5 font-bold text-sm uppercase hover:bg-black transition">
         Free Site Visit
       
</Button>
      <!-- Mobile Menu Button -->
      <button id="menuBtn" class="md:hidden text-2xl" aria-label="Menu">
        <i class="fa-solid fa-bars text-primary"></i>
      </button>
    </div>
    <!-- Mobile Menu -->
    <div id="mobileMenu" class="md:hidden hidden bg-white/30 border-t border-borderGrey rounded-b-lg">
      <nav class="flex flex-col px-4 py-6 space-y-4 font-semibold text-sm uppercase">
        <a href="/">Home</a>
        <a href="/#projects">Projects</a>
        <a href="/#amenities">Amenities</a>
        <a href="/#location">Connectivity</a>
        <a href="/#contact">Contact</a>
        <a href="/about">About Us</a>
      </nav>
    </div>
  </header>