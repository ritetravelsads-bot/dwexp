<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require_once 'config.php';
$recaptchaSiteKey = getenv('RECAPTCHA_SITE_KEY') ?: '';
if (empty($_SESSION['form_token']) || !is_string($_SESSION['form_token'])) {
    $_SESSION['form_token'] = bin2hex(random_bytes(32));
}
$formToken = $_SESSION['form_token'];
?>
<?php include 'inc/head.php'; ?>
<?php include 'inc/header.php'; ?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "RealEstateAgent",
  "name": "Dwarka Expressway Ncr",
  "image": "https://dwarkaexpresswayncr.com/assets/img/proj/p-1.png",
  "@id": "",
  "url": "https://dwarkaexpresswayncr.com/",
  "telephone": "+91 9873702365",
  "priceRange": "50 lakh - 6 CR",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Unit no. 555 JMD Megapolis Badshahpur Sohna Road, Sector 48",
    "addressLocality": "Gurugram, Haryana",
    "postalCode": "122018",
    "addressCountry": "IN"
  },
  "openingHoursSpecification": {
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": [
      "Monday",
      "Wednesday",
      "Thursday",
      "Friday",
      "Saturday",
      "Sunday"
    ],
    "opens": "09:00",
    "closes": "07:00"
  },
  "sameAs": [
    "https://www.instagram.com/dwarkaexpresswayncr/",
    "https://www.facebook.com/people/Dwarka-Expressway-Ncr/61586373907850/"
  ] 
}
</script>
 <main>
     <button
  onclick="openEmiPopup()"
  class="fixed md:bottom-1/2 bottom-1/3 right-[-50px] z-50 
         -rotate-90 bg-primary p-4 rounded-t-lg
         text-white font-bold text-sm uppercase
         cursor-pointer">
  Emi Calculate
</button>
<section class="relative md:h-[85vh] pt-16 md:pt-20">
  <div class="swiper heroSwiper h-full">
    <div class="swiper-wrapper">

      <!-- SLIDE 1 -->
      <div class="swiper-slide relative">
        <img
          src="assets/img/dwarka-banner-1.webp"
          class="w-full h-[280px] md:h-full object-cover"
          alt="Luxury Property" />

        <div class="absolute inset-0 bg-black/40 flex items-center">
         <div class="container mx-auto px-4">

            <h2
              class="text-white font-teko uppercase leading-none
                     text-3xl sm:text-4xl md:text-6xl flex flex-col">
            <span>Dwarka Expressway </span>  
             <span class="text-primary">Overview</span>
            </h2>

            <p
              class="text-white/70 mt-3 md:mt-4 max-w-md
                     text-sm sm:text-base md:text-lg">
                Dwarka Expressway cuts Delhi-Gurugram travel to 20 mins to airport and premium Projects in Dwarka Expressway with luxury homes and high ROI</p>
         <div>
          <button onclick="window.location.href='#residential-project'"
           class="bg-primary hover:bg-primary/80 text-white px-6 py-2 rounded-lg mt-4">
           View Project
          </button>
          <button onclick="togglePops()" class="bg-dark hover:bg-dark/80 text-white px-6 py-2 rounded-lg mt-4">
            View Floor Plans
          </button>
         </div>
          </div>
        </div>
      </div>

      <!-- SLIDE 2 -->
      <div class="swiper-slide relative">
        <img
          src="assets/img/dwarka-banner-2.webp"
          class="w-full h-[280px] md:h-full object-cover"
          alt="Modern Architecture" />

        <div
          class="absolute inset-0 bg-gradient-to-r
                 from-black/80 to-transparent flex items-center">
          <div class="container mx-auto px-4">

            <h2
              class="text-white font-teko uppercase leading-none
                     text-3xl sm:text-4xl md:text-6xl flex flex-col">
             <span>Investment & Real Estate </span> <span>Potential</span>
            </h2>

            <p
              class="text-white/70 mt-3 md:mt-4 max-w-md
                     text-sm sm:text-base md:text-lg">
                    The rapid infrastructure and new launches has made Dwarka Expressway Real estate one of the most talked-about investment destinations in NCR.
            </p>

          </div>
        </div>
      </div>

      <!-- SLIDE 3 -->
      <div class="swiper-slide relative">
        <img
          src="assets/img/dwarka-banner-3.webp"
          class="w-full h-[280px] md:h-full object-cover"
          alt="Interior Design" />

        <div
          class="absolute inset-0 bg-gradient-to-r
                 from-black/80 to-transparent flex items-center">
          <div class="container mx-auto px-4">

            <h2
              class="text-white font-teko uppercase leading-none
                     text-3xl sm:text-4xl md:text-6xl flex flex-col">
             <span>Dealers & Upcoming </span>
             <span>Opportunities</span>
            </h2>

            <p
              class="text-white/70 mt-3 md:mt-4 max-w-md
                     text-sm sm:text-base md:text-lg">
                    Find trusted Dwarka Expressway property dealers for seamless buying, exclusive deals, and site visits on upcoming properties in Dwarka Expressway.
            </p>

          </div>
        </div>
      </div>
    </div>
  </div>

  </div>
</section>
 
 <section id="residential-project" class="py-20 md:px-10 bg-lightGrey">
    <!-- FILTER BAR -->


    <div class="container mx-auto px-4">
      <div class="flex flex-col md:flex-row justify-between items-end mb-12">
        <div>
          <h3 class=" text-4xl md:text-5xl uppercase leading-none">Featured Projects on Dwarka Expressway</h3>
        </div>
        <!-- <p class="text-gray-500 max-w-xs mt-4 md:mt-0">Handpicked luxury residences offering the best ROI and lifestyle.</p> -->
      </div>

      <div class="w-150 mx-auto">
        <div class="rounded-2xl shadow p-6 mb-5 bg-white">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <!-- Project Name -->
            <div class="relative">
              <input id="projectFilter" type="text" placeholder="Search Project Name"
                class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary">
              <ul id="projectSuggestions"
                class="absolute z-10 bg-white border border-gray-300 w-full mt-1 rounded-lg hidden max-h-40 overflow-y-auto shadow-lg"></ul>
            </div>

            <!-- Location -->
            <input id="locationFilter" type="text" placeholder="Search Sector / Location"
              class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary">

            <!-- Budget -->
            <select id="budgetFilter"
              class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary">
              <option value="">Select Budget</option>
              <option value="1-2.5">₹1 Cr to ₹2.5 Cr</option>
              <option value="2.5-5">₹2.5 – ₹5 Cr</option>
              <option value="5-6">₹5 – ₹6 Cr</option>
              <option value="6+">Above ₹6 Cr</option>
            </select>

          </div>
        </div>

      </div>
      <?php
    function makeSlug($string) {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    }

    $projects = [
      [
        'name' => 'Whiteland Westin Residences',
        'location' => 'Sector 103',
        'price' => '5.5 Cr',
        'image' => 'p-1.webp',
        'badge' => 'Branded Residences',
        'badgeColor' => 'bg-primary',
        'occupancy' => 65,
        'alt' => 'Whiteland Westin Residences in Sector 103'
      ],
      [
        'name' => 'Godrej Vrikshya',
        'location' => 'Sector 103',
        'price' => '3.6 Cr',
        'image' => 'p-2.webp',
        'badge' => 'Forest-themed Living',
        'badgeColor' => 'bg-primary',
        'occupancy' => 82,
        'alt' => 'Godrej Vrikshya in Sector 103'
      ],
      [
        'name' => 'Signature Global De Luxe DXP',
        'location' => 'Sector 37D',
        'price' => '3.5 Cr',
        'image' => 'p-3.webp',
        'badge' => 'High-rise Development',
        'badgeColor' => 'bg-primary',
        'occupancy' => 98,
        'alt' => 'Signature Global De Luxe DXP in Sector 37D'
      ],
      [
        'name' => 'Hero Homes The Palatial',
        'location' => 'Sector 104',
        'price' => '1.8 Cr',
        'image' => 'p-4.webp',
        'badge' => 'Near Completion',
        'badgeColor' => 'bg-primary',
        'occupancy' => 92,
        'alt' => 'Hero Homes in Sector 104'
      ],
      [
        'name' => 'M3M Capital',
        'location' => 'Sector 113',
        'price' => '5.2 Cr',
        'image' => 'p-5.webp',
        'badge' => 'Possession (Dec 2026)',
        'badgeColor' => 'bg-primary',
        'occupancy' => 88,
        'alt' => 'M3M Capital in Sector 113'
      ],
      [
        'name' => 'Elan The Presidential',
        'location' => 'Sector 106',
        'price' => '6.5 Cr',
        'image' => 'p-6.webp',
        'badge' => 'Ultra-Luxury Living',
        'badgeColor' => 'bg-primary',
        'occupancy' => 78,
        'alt' => 'Elan The Presidential in Sector 106'
      ],
      [
        'name' => 'M3M Crown',
        'location' => 'Sector 111',
        'price' => '4.5 Cr',
        'image' => 'p-7.webp',
        'badge' => 'Under Construction (2028)',
        'badgeColor' => 'bg-primary',
        'occupancy' => 85,
        'alt' => 'M3M Crown in Sector 111'
      ],
      [
        'name' => 'Smartworld One DXP',
        'location' => 'Sector 113',
        'price' => '3.5 Cr',
        'image' => 'p-8.webp',
        'badge' => 'Under Construction (2027)',
        'badgeColor' => 'bg-primary',
        'occupancy' => 90,
        'alt' => 'Smartworld One DXP in Sector 113'
      ],
      [
        'name' => 'Puri Diplomatic Residences',
        'location' => 'Sector 111',
        'price' => '4.2 Cr',
        'image' => 'p-9.webp',
        'badge' => 'Exclusive Launch',
        'badgeColor' => 'bg-primary',
        'occupancy' => 60,
        'alt' => 'Puri Diplomatic Residences in Sector 111'
      ],
      [
        'name' => 'Sobha Altus',
        'location' => 'Sector 106',
        'price' => '5.0 Cr',
        'image' => 'p-10.webp',
        'badge' => 'Premium High-rise',
        'badgeColor' => 'bg-primary',
        'occupancy' => 55,
        'alt' => 'Sobha Altus in Sector 106'
      ],
      [
        'name' => 'BPTP Amstoria Verti Greens',
        'location' => 'Sector 102',
        'price' => '3.5 Cr',
        'image' => 'p-11.webp',
        'badge' => 'Ultra-Luxury Living',
        'badgeColor' => 'bg-primary',
        'occupancy' => 12,
        'alt' => 'BPTP Verti Greens in Sector 102'
      ],
      [
        'name' => 'M3M Elie Saab',
        'location' => 'Sector 111',
        'price' => '14 Cr',
        'image' => 'p-12.webp',
        'badge' => 'Branded Residences',
        'badgeColor' => 'bg-primary',
        'occupancy' => 15,
        'alt' => 'M3M Elie Saab Luxury Apartments in Sector 111'
      ],
      [
        'name' => 'BPTP Gaia',
        'location' => 'Sector 102',
        'price' => '4.21 Cr',
        'image' => 'p-13.webp',
        'badge' => 'New Launch (2032)',
        'badgeColor' => 'bg-primary',
        'occupancy' => 10,
        'alt' => 'BPTP Gaia Residences in Sector 102'
      ],
      [
        'name' => 'Landmark The Residency',
        'location' => 'Sector 103',
        'price' => '1.3 Cr',
        'image' => 'p-14.webp',
        'badge' => 'Ready to Move',
        'badgeColor' => 'bg-primary',
        'occupancy' => 90,
        'alt' => 'Landmark The Residency in Sector 103'
      ],
      [
        'name' => 'Adani Realty Iconic Towers',
        'location' => 'Sector 102',
        'price' => '12 Cr',
        'image' => 'p-15.webp',
        'badge' => 'Ready to Move',
        'badgeColor' => 'bg-primary',
        'occupancy' => 88,
        'alt' => 'Adani Oyster Grande Luxury Penthouse Sector 102'
      ],
      [
        'name' => 'HCBS Twin Horizon',
        'location' => 'Sector 102',
        'price' => '4.11 Cr',
        'image' => 'p-16.webp',
        'badge' => 'Under Construction (2028)',
        'badgeColor' => 'bg-primary',
        'occupancy' => 22,
        'alt' => 'HCBS Twin Horizon Sector 102'
      ],
      [
        'name' => 'Central Park Delphine',
        'location' => 'Sector 104',
        'price' => '9 Cr',
        'image' => 'p-17.webp',
        'badge' => 'Luxury High-rise',
        'badgeColor' => 'bg-primary',
        'occupancy' => 8,
        'alt' => 'Central Park Delphine in Sector 104'
      ],
      [
        'name' => 'AIPL Riviera Lake City',
        'location' => 'Sector 103',
        'price' => '2.8 Cr',
        'image' => 'p-18.webp',
        'badge' => 'Lake-facing Living',
        'badgeColor' => 'bg-primary',
        'occupancy' => 5,
        'alt' => 'AIPL Riviera Lake City Sector 103'
      ],
      [
        'name' => 'Tata Raisina Residency',
        'location' => 'Sector 59',
        'price' => '5.5 Cr',
        'image' => 'p-19.webp',
        'badge' => 'Ready to Move',
        'badgeColor' => 'bg-primary',
        'occupancy' => 95,
        'alt' => 'Tata Raisina Residency Sector 59'
      ],
      [
        'name' => 'Mahindra Luminare',
        'location' => 'Sector 59',
        'price' => '7.9 Cr',
        'image' => 'p-20.webp',
        'badge' => 'Ready to Move',
        'badgeColor' => 'bg-primary',
        'occupancy' => 85,
        'alt' => 'Mahindra Luminare Sector 59'
      ],
      [
        'name' => 'Shapoorji Pallonji Joyville',
        'location' => 'Sector 102',
        'price' => '2.1 Cr',
        'image' => 'p-21.webp',
        'badge' => 'Ready to Move',
        'badgeColor' => 'bg-primary',
        'occupancy' => 92,
        'alt' => 'Joyville by Shapoorji Pallonji Sector 102'
      ],
      [
        'name' => 'Omaxe New Heights',
        'location' => 'Sector 78',
        'price' => '1.8 Cr',
        'image' => 'p-22.webp',
        'badge' => 'Established Society',
        'badgeColor' => 'bg-primary',
        'occupancy' => 94,
        'alt' => 'Omaxe New Heights Sector 78'
      ],
      [
        'name' => 'Sobha City',
        'location' => 'Sector 108',
        'price' => '1.95 Cr',
        'image' => 'p-23.webp',
        'badge' => 'Ready to Move',
        'badgeColor' => 'bg-primary',
        'occupancy' => 96,
        'alt' => 'Sobha City Sector 108 Dwarka Expressway'
      ],
      [
        'name' => 'Emaar Palm Hills',
        'location' => 'Sector 77',
        'price' => '3.4 Cr',
        'image' => 'p-24.webp',
        'badge' => 'Ready to Move',
        'badgeColor' => 'bg-primary',
        'occupancy' => 90,
        'alt' => 'Emaar Palm Hills Sector 77'
      ],
      [
        'name' => 'Godrej Meridien',
        'location' => 'Sector 106',
        'price' => '4.8 Cr',
        'image' => 'p-25.webp',
        'badge' => 'Ready to Move',
        'badgeColor' => 'bg-primary',
        'occupancy' => 88,
        'alt' => 'Godrej Meridien Sector 106'
      ],
      [
        'name' => 'Godrej Summit',
        'location' => 'Sector 104',
        'price' => '9.25 Cr',
        'image' => 'p-26.webp',
        'badge' => 'Ready to Move',
        'badgeColor' => 'bg-primary',
        'occupancy' => 98,
        'alt' => 'Godrej Summit Sector 104'
      ],
      [
        'name' => 'DLF The Ultima',
        'location' => 'Sector 81',
        'price' => '7.25 Cr',
        'image' => 'p-27.webp',
        'badge' => 'Ready to Move',
        'badgeColor' => 'bg-primary',
        'occupancy' => 94,
        'alt' => 'DLF The Ultima Sector 81'
      ],
      [
        'name' => 'DLF The Sky Court',
        'location' => 'Sector 86',
        'price' => '2.5 Cr',
        'image' => 'p-28.webp',
        'badge' => 'Ready to Move',
        'badgeColor' => 'bg-primary',
        'occupancy' => 92,
        'alt' => 'DLF The Sky Court Sector 86'
      ],
      [
        'name' => 'Omaxe Dwarka Heights',
        'location' => 'Sector 19B Dwarka',
        'price' => '1.45 Cr',
        'image' => 'p-29.webp',
        'badge' => 'Under Construction',
        'badgeColor' => 'bg-primary',
        'occupancy' => 40,
        'alt' => 'Omaxe Dwarka Heights Sector 19B'
      ],
    ];
    ?>

    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php foreach ($projects as $project): 
                $slug = htmlspecialchars($project['slug'] ?? makeSlug($project['name']));
                $occ = $project['occupancy'] ?? 0;
                // SVG Math: Circumference = 2 * pi * r (r=15.915 approx makes circumference 100)
                $radius = 15.915;
                $circumference = 2 * M_PI * $radius;
                $offset = $circumference - ($occ / 100) * $circumference;
            ?>
                <a href="/<?php echo $slug; ?>" class="group bg-white rounded-2xl shadow-lg overflow-hidden project-card transition-transform hover:-translate-y-1 block">
                    
                    <div class="relative">
                        <?php
                        $imageUrl = $project['image'] ?? '';
                        if (!preg_match('/^(https?:)?\/\//', $imageUrl)) {
                            $imageUrl = 'assets/img/proj/' . ltrim($imageUrl, '/');
                        }
                        ?>
                        <img src="<?php echo htmlspecialchars($imageUrl); ?>" 
                             alt="<?php echo htmlspecialchars($project['alt'] ?? $project['name']); ?>"
                             class="h-56 w-full object-cover transition-transform duration-500 group-hover:scale-105" />
                        
                        <span class="absolute top-3 left-3 <?php echo $project['badgeColor']; ?> text-white text-xs font-medium px-3 py-1 rounded-full shadow-sm">
                            <?php echo $project['badge']; ?>
                        </span>
                    </div>

                    <div class="p-5">
                        <div class="flex justify-between items-start gap-2">
                            <div class="space-y-1 flex-1">
                                <h3 class="text-lg font-semibold leading-tight group-hover:text-primary transition-colors">
                                    <?php echo $project['name']; ?>
                                </h3>
                                <p class="text-xs text-gray-500 flex items-center">
                                    <i class="fa-solid fa-location-dot mr-1"></i>
                                    <?php echo $project['location']; ?>
                                </p>
                                <p class="text-lg font-bold text-red-700 pt-1">
                                    ₹ <?php echo $project['price']; ?>*
                                </p>
                            </div>

                            <div class="flex flex-col items-center justify-center min-w-[60px]">
                                <div class="relative w-12 h-12">
                                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 40 40">
                                        <circle cx="20" cy="20" r="<?php echo $radius; ?>" fill="transparent" stroke="#e5e7eb" stroke-width="4"/>
                                        <circle cx="20" cy="20" r="<?php echo $radius; ?>" fill="transparent" stroke="#15803d" stroke-width="4" 
                                                stroke-dasharray="<?php echo $circumference; ?>" 
                                                stroke-dashoffset="<?php echo $offset; ?>" 
                                                stroke-linecap="round"/>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-[10px] font-bold text-gray-700"><?php echo $occ; ?>%</span>
                                    </div>
                                </div>
                                <span class="text-[9px] uppercase font-bold text-gray-400 mt-1">Occupancy</span>
                            </div>
                        </div>

                        <hr class="my-3 border-gray-100">

                        <div class="flex justify-between items-center">
                            <span class="text-primary font-bold text-xs uppercase group-hover:underline">
                                View Details
                            </span>
                            <i class="fa-solid fa-arrow-right text-primary text-xs transform group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
  </section>
 <section
      id="location"
      class="pb-32 pt-10 bg-white border-b border-borderGrey animate-on-scroll"
    >
      <div
        class="max-w-7xl mx-auto px-6 mb-16 flex flex-col md:flex-row justify-between items-end gap-6"
      >
        <div>
          <h2
            class="text-4xl md:text-5xl font-heading font-semibold text-dark mb-4 tracking-tight"
          >
            Prime Connectivity
          </h2>
          <p class="text-slate-700 font-light max-w-md">
            Strategically Located with Superior Dwarka Expressway connectivity, linking Delhi-NCR's key destinations in minutes.
          </p>
        </div>
        <a
          href="#contact"
          class="text-sm text-dark border-b border-dark pb-1 hover:text-primary hover:border-primary transition-colors"
        >
          View detailed location map
        </a>
      </div>

      <div
        class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center"
      >
        <!-- Location Map Visual -->
        <div
          class="relative overflow-hidden rounded-2xl border border-borderGrey location-image"
        >
          <img
            src="assets/img/prime-Connectivity.webp"
            alt="Aerial view of Dwarka Expressway showing modern infrastructure and connectivity to Delhi-NCR"
            class="w-full h-full object-cover"
          />
          <div class="absolute bottom-6 left-6 right-6">

          </div>
        </div>

        <!-- Connectivity Benefits -->
        <div class="space-y-6">
          <div
            class="flex items-start gap-4 p-4 rounded-xl border border-borderGrey hover:border-primary/20 hover:shadow-md transition-all location-card"
          >
            <div
              class="flex-shrink-0 w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center"
            >
              <svg
                class="w-6 h-6 text-primary"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"
                />
              </svg>
            </div>
            <div>
              <h3 class="text-lg font-semibold text-dark mb-1">
                15 minutes to IGI Airport
              </h3>
              <p class="text-sm text-slate-600">
                Direct expressway access for seamless international travel
              </p>
            </div>
          </div>

          <div
            class="flex items-start gap-4 p-4 rounded-xl border border-borderGrey hover:border-primary/20 hover:shadow-md transition-all location-card"
          >
            <div
              class="flex-shrink-0 w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center"
            >
              <svg
                class="w-6 h-6 text-primary"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                />
              </svg>
            </div>
            <div>
              <h3 class="text-lg font-semibold text-dark mb-1">
                Direct Gurugram Access
              </h3>
              <p class="text-sm text-slate-600">
                20-minute drive to Cyber City and DLF Phase offices
              </p>
            </div>
          </div>

          <div
            class="flex items-start gap-4 p-4 rounded-xl border border-borderGrey hover:border-primary/20 hover:shadow-md transition-all location-card"
          >
            <div
              class="flex-shrink-0 w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center"
            >
              <svg
                class="w-6 h-6 text-primary"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"
                />
              </svg>
            </div>
            <div>
              <h3 class="text-lg font-semibold text-dark mb-1">
                5 km from Diplomatic Enclave
              </h3>
              <p class="text-sm text-slate-600">
                Proximity to embassies and international schools
              </p>
            </div>
          </div>

          <div
            class="flex items-start gap-4 p-4 rounded-xl border border-borderGrey hover:border-primary/20 hover:shadow-md transition-all location-card"
          >
            <div
              class="flex-shrink-0 w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center"
            >
              <svg
                class="w-6 h-6 text-primary"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M13 10V3L4 14h7v7l9-11h-7z"
                />
              </svg>
            </div>
            <div>
              <h3 class="text-lg font-semibold text-dark mb-1">
                Adjacent Metro Station (2026)
              </h3>
              <p class="text-sm text-slate-600">
                Upcoming metro connectivity for daily commute convenience
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Project Highlights Bento Grid -->
    <section class="py-32 px-6 bg-lightGrey animate-on-scroll">
      <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16 max-w-3xl mx-auto">
          <h2
            class="text-4xl md:text-5xl font-heading font-semibold tracking-tight text-dark mb-6"
          >
            Your Dream Home Awaits
          </h2>
          <p class="text-slate-700 font-light">
            Meticulously designed residences with modern architecture,
            vastu-compliant layouts, and premium specifications.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 auto-rows-fr">
          <!-- Large Featured Card -->
          <div
            class="md:col-span-2 relative rounded-2xl overflow-hidden border border-borderGrey group project-card bg-white"
          >
            <div
              class="absolute inset-0 bg-gradient-to-t from-white via-white/60 to-transparent"
            ></div>
            <div
              class="absolute inset-0 bg-gradient-to-r from-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"
            ></div>
            <div class="relative p-8 h-full flex flex-col justify-end">
              <div
                class="w-12 h-12 rounded-full bg-primary/10 backdrop-blur-md flex items-center justify-center text-primary mb-4"
              >
                <svg
                  class="w-6 h-6"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                  />
                </svg>
              </div>
              <h3 class="text-3xl text-dark font-heading font-semibold mb-3">
                Premium Residences
              </h3>
              <div class="space-y-2 mb-4">
                <p class="text-dark font-medium">✓ 3 & 4 BHK from 1850 sq.ft</p>
                <p class="text-slate-700 text-sm">
                  ✓ Vastu-compliant layouts with natural ventilation
                </p>
                <p class="text-slate-700 text-sm">
                  ✓ Private balconies with expressway views
                </p>
                <p class="text-slate-700 text-sm">
                  ✓ Modular kitchen with premium fixtures
                </p>
              </div>
            </div>
          </div>

          <!-- RERA Card -->
          <div
            class="bg-white border border-borderGrey rounded-2xl p-8 hover:shadow-lg transition-all flex flex-col justify-center relative overflow-hidden project-card"
          >
            <div
              class="absolute top-0 right-0 w-32 h-32 bg-primary/10 blur-xl rounded-full"
            ></div>
            <div class="relative">
              <svg
                class="w-8 h-8 text-primary mb-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                />
              </svg>
              <h3 class="text-2xl text-dark font-heading font-semibold mb-2">
                RERA Approved
              </h3>
              <p class="text-slate-600 text-sm leading-relaxed mb-3">
                Registered project with transparent documentation and legal
                compliance
              </p>
              <div class="text-primary font-semibold">Q4 2026 Possession</div>
            </div>
          </div>

          <!-- Floor Plan Card -->
          <div
            class="bg-white border border-borderGrey rounded-2xl p-8 hover:shadow-lg transition-all flex flex-col justify-center relative overflow-hidden project-card"
          >
            <div
              class="absolute top-0 right-0 w-32 h-32 bg-primary/10 blur-xl rounded-full"
            ></div>
            <div class="relative">
              <svg
                class="w-8 h-8 text-primary mb-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                />
              </svg>
              <h3 class="text-2xl text-dark font-heading font-semibold mb-2">
                Floor Plans
              </h3>
              <p class="text-slate-600 text-sm leading-relaxed mb-4">
                Download detailed floor plans and specifications
              </p>
              <a
                href="#contact"
                class="inline-flex items-center gap-2 text-primary hover:gap-3 transition-all text-sm font-medium"
              >
                Download Brochure
                <svg
                  class="w-4 h-4"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                  />
                </svg>
              </a>
            </div>
          </div>

          <!-- Specifications Card -->
          <div
            class="md:col-span-2 bg-white border border-borderGrey rounded-2xl p-8 hover:shadow-lg transition-all relative overflow-hidden project-card"
          >
            <div
              class="absolute top-0 right-0 w-40 h-40 bg-primary/5 blur-2xl rounded-full"
            ></div>
            <div class="relative">
              <h3 class="text-2xl text-dark font-heading font-semibold mb-6">
                Premium Specifications
              </h3>
              <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-3">
                  <div class="flex items-start gap-3">
                    <svg
                      class="w-5 h-5 text-primary flex-shrink-0 mt-0.5"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"
                      />
                    </svg>
                    <div>
                      <p class="text-dark font-medium text-sm">
                        Vitrified tile flooring
                      </p>
                      <p class="text-slate-600 text-xs">
                        Premium finish throughout
                      </p>
                    </div>
                  </div>
                  <div class="flex items-start gap-3">
                    <svg
                      class="w-5 h-5 text-primary flex-shrink-0 mt-0.5"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"
                      />
                    </svg>
                    <div>
                      <p class="text-dark font-medium text-sm">
                        Branded electrical fittings
                      </p>
                      <p class="text-slate-600 text-xs">
                        Modular switches & fixtures
                      </p>
                    </div>
                  </div>
                  <div class="flex items-start gap-3">
                    <svg
                      class="w-5 h-5 text-primary flex-shrink-0 mt-0.5"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"
                      />
                    </svg>
                    <div>
                      <p class="text-dark font-medium text-sm">UPVC windows</p>
                      <p class="text-slate-600 text-xs">
                        Double-glazed for insulation
                      </p>
                    </div>
                  </div>
                </div>
                <div class="space-y-3">
                  <div class="flex items-start gap-3">
                    <svg
                      class="w-5 h-5 text-primary flex-shrink-0 mt-0.5"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"
                      />
                    </svg>
                    <div>
                      <p class="text-dark font-medium text-sm">
                        Oil-bound distemper walls
                      </p>
                      <p class="text-slate-600 text-xs">Premium paint finish</p>
                    </div>
                  </div>
                  <div class="flex items-start gap-3">
                    <svg
                      class="w-5 h-5 text-primary flex-shrink-0 mt-0.5"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"
                      />
                    </svg>
                    <div>
                      <p class="text-dark font-medium text-sm">
                        Designer bathroom fittings
                      </p>
                      <p class="text-slate-600 text-xs">
                        Premium sanitary ware
                      </p>
                    </div>
                  </div>
                  <div class="flex items-start gap-3">
                    <svg
                      class="w-5 h-5 text-primary flex-shrink-0 mt-0.5"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"
                      />
                    </svg>
                    <div>
                      <p class="text-dark font-medium text-sm">
                        Video door phone
                      </p>
                      <p class="text-slate-600 text-xs">Enhanced security</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Amenities & Lifestyle -->
    <section id="amenities" class="py-32 px-6 bg-white animate-on-scroll">
      <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16 max-w-3xl mx-auto">
          <h2
            class="text-4xl md:text-5xl font-heading font-semibold tracking-tight text-dark mb-6"
          >
            Lifestyle Beyond Compare
          </h2>
          <p class="text-slate-700 font-light">
            World-class Amenities Designed for Modern Living, Featuring Eco Friendly Amenities crafted for your Comfort and Convenience.
          </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-12">
          <!-- Amenity Cards -->
          <div class="amenity-card-light group">
            <div class="amenity-icon">
              <svg
                class="w-8 h-8"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"
                />
              </svg>
            </div>
            <h3 class="text-dark font-semibold mb-1">Clubhouse</h3>
            <p class="text-slate-600 text-sm">
              50,000 sq.ft multipurpose space
            </p>
          </div>

          <div class="amenity-card-light group">
            <div class="amenity-icon">
              <svg
                class="w-8 h-8"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"
                />
              </svg>
            </div>
            <h3 class="text-dark font-semibold mb-1">Swimming Pool</h3>
            <p class="text-slate-600 text-sm">Olympic-size with kids' pool</p>
          </div>

          <div class="amenity-card-light group">
            <div class="amenity-icon">
              <svg
                class="w-8 h-8"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M13 10V3L4 14h7v7l9-11h-7z"
                />
              </svg>
            </div>
            <h3 class="text-dark font-semibold mb-1">Fitness Center</h3>
            <p class="text-slate-600 text-sm">State-of-the-art equipment</p>
          </div>

          <div class="amenity-card-light group">
            <div class="amenity-icon">
              <svg
                class="w-8 h-8"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                />
              </svg>
            </div>
            <h3 class="text-dark font-semibold mb-1">Kids' Play Area</h3>
            <p class="text-slate-600 text-sm">Safe & supervised zone</p>
          </div>

          <div class="amenity-card-light group">
            <div class="amenity-icon">
              <svg
                class="w-8 h-8"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 11a4 4 0 01-4 4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"
                />
              </svg>
            </div>
            <h3 class="text-dark font-semibold mb-1">Jogging Track</h3>
            <p class="text-slate-600 text-sm">Landscaped walking paths</p>
          </div>

          <div class="amenity-card-light group">
            <div class="amenity-icon">
              <svg
                class="w-8 h-8"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 11H5m14 0a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"
                />
              </svg>
            </div>
            <h3 class="text-dark font-semibold mb-1">Pet Park</h3>
            <p class="text-slate-600 text-sm">Dedicated space for pets</p>
          </div>

          <div class="amenity-card-light group">
            <div class="amenity-icon">
              <svg
                class="w-8 h-8"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M13 10V3L4 14h7v7l9-11h-7z"
                />
              </svg>
            </div>
            <h3 class="text-dark font-semibold mb-1">Power Backup</h3>
            <p class="text-slate-600 text-sm">100% DG backup</p>
          </div>

          <div class="amenity-card-light group">
            <div class="amenity-icon">
              <svg
                class="w-8 h-8"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 11H5m14 0a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"
                />
              </svg>
            </div>
            <h3 class="text-dark font-semibold mb-1">Senior Citizen Zone</h3>
            <p class="text-slate-600 text-sm">Peaceful relaxation area</p>
          </div>

          <div class="amenity-card-light group">
            <div class="amenity-icon">
              <svg
                class="w-8 h-8"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 3v2m6-2v2M9 19v2m12-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 7h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"
                />
              </svg>
            </div>
            <h3 class="text-dark font-semibold mb-1">Rainwater Harvesting</h3>
            <p class="text-slate-600 text-sm">Eco-friendly initiative</p>
          </div>

          <div class="amenity-card-light group">
            <div class="amenity-icon">
              <svg
                class="w-8 h-8"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M13 10V3L4 14h7v7l9-11h-7z"
                />
              </svg>
            </div>
            <h3 class="text-dark font-semibold mb-1">EV Charging</h3>
            <p class="text-slate-600 text-sm">Electric vehicle stations</p>
          </div>

          <div class="amenity-card-light group">
            <div class="amenity-icon">
              <svg
                class="w-8 h-8"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                />
              </svg>
            </div>
            <h3 class="text-dark font-semibold mb-1">Landscaped Gardens</h3>
            <p class="text-slate-600 text-sm">Green open spaces</p>
          </div>
        </div>

        <div class="text-center">
          <a href="tel:+919354902932" class="cta-button-large inline-flex group">
            Schedule Site Visit
            <svg
              class="w-5 h-5 group-hover:translate-x-1 transition-transform"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M17 8l4 4m0 0l-4 4m4-4H3"
              />
            </svg>
          </a>
        </div>
      </div>
    </section>
    <section
      class="py-32 bg-lightGrey border-t border-borderGrey animate-on-scroll"
    >
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-12 gap-12 items-center">
          <!-- Stats Column -->
          <div class="lg:col-span-5 space-y-8">
            <div>
              <h2
                class="text-4xl md:text-5xl font-heading font-semibold text-dark mb-4 tracking-tight"
              >
                Built on Trust
              </h2>
              <p class="text-slate-700 font-light">
                A legacy of excellence in NCR real estate development
              </p>
            </div>

            <div class="space-y-6">
              <div class="developer-stat-light">
                <div class="text-5xl font-heading font-light text-dark mb-2">
                  25+
                </div>
                <div class="text-slate-700 font-medium">
                  Years of Experience
                </div>
                <div class="text-slate-500 text-sm">
                  In NCR real estate market
                </div>
              </div>

              <div class="developer-stat-light">
                <div class="text-5xl font-heading font-light text-dark mb-2">
                  15,000+
                </div>
                <div class="text-slate-700 font-medium">Happy Families</div>
                <div class="text-slate-500 text-sm">
                  Across 40 completed projects
                </div>
              </div>

              <div class="developer-stat-light">
                <div class="text-5xl font-heading font-light text-dark mb-2">
                  98%
                </div>
                <div class="text-slate-700 font-medium">On-Time Delivery</div>
                <div class="text-slate-500 text-sm">
                  Industry-leading track record
                </div>
              </div>
            </div>
          </div>

          <!-- Content Column -->
          <div class="lg:col-span-7 space-y-6">
            <p class="text-slate-700 leading-relaxed">
              With over two decades shaping NCR's skyline, we deliver RERA approved projects from Award winning property developers. Our RERA certified commitment ensures transparency and trust for thousands of families.
            </p>

            <div class="grid md:grid-cols-2 gap-6">
              <div
                class="p-6 rounded-xl border border-borderGrey bg-white hover:shadow-md transition-all"
              >
                <svg
                  class="w-8 h-8 text-primary mb-3"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                  />
                </svg>
                <h3 class="text-dark font-semibold mb-2">ISO Certified</h3>
                <p class="text-slate-600 text-sm">
                  International quality standards maintained
                </p>
              </div>

              <div
                class="p-6 rounded-xl border border-borderGrey bg-white hover:shadow-md transition-all"
              >
                <svg
                  class="w-8 h-8 text-primary mb-3"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                  />
                </svg>
                <h3 class="text-dark font-semibold mb-2">RERA Compliant</h3>
                <p class="text-slate-600 text-sm">
                  All projects registered and transparent
                </p>
              </div>
            </div>

            <div class="p-6 rounded-xl border border-primary/20 bg-primary/5">
              <h4 class="text-dark font-semibold mb-3">
                Notable Past Projects
              </h4>
              <ul class="space-y-2 text-slate-700 text-sm">
                <li class="flex items-center gap-2">
                  <svg
                    class="w-4 h-4 text-primary flex-shrink-0"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"
                    />
                  </svg>
                  <span
                    >Green Valley Residency, Gurugram (2022) - 500 units</span
                  >
                </li>
                <li class="flex items-center gap-2">
                  <svg
                    class="w-4 h-4 text-primary flex-shrink-0"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"
                    />
                  </svg>
                  <span>Sky Heights Apartments, Noida (2021) - 350 units</span>
                </li>
                <li class="flex items-center gap-2">
                  <svg
                    class="w-4 h-4 text-primary flex-shrink-0"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"
                    />
                  </svg>
                  <span>Harmony Villas, Greater Noida (2020) - 200 units</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
  <section class="py-20 bg-gray-50">
  <div class="container mx-auto px-6">
    <h2 class="text-3xl md:text-4xl font-semibold text-center mb-16 text-[var(--dark)]">
      Frequently Asked Questions 
      <span class="">(FAQs)</span>
    </h2>

    <div class="max-w-3xl mx-auto space-y-6">

      <details class="group bg-white rounded-lg shadow-md overflow-hidden transition-all duration-500">
        <summary class="flex justify-between items-center px-6 py-4 cursor-pointer text-lg font-semibold text-[var(--dark)]">
          1. What is Dwarka Expressway?
          <span class="transition-transform duration-300 group-open:rotate-45 text-sm">
            <i class="fa-solid fa-plus"></i>
          </span>
        </summary>
        <div class="grid grid-rows-[0fr] transition-all duration-500 ease-in-out group-open:grid-rows-[1fr]">
          <div class="overflow-hidden">
            <div class="px-6 pb-4 text-gray-700 leading-relaxed">
              Dwarka Expressway is a 27.6 km, 16-lane operational highway linking Delhi's IGI Airport area to Gurgaon.
            </div>
          </div>
        </div>
      </details>

      <details class="group bg-white rounded-lg shadow-md overflow-hidden transition-all duration-500">
        <summary class="flex justify-between items-center px-6 py-4 cursor-pointer text-lg font-semibold text-[var(--dark)]">
          2. Is it worth investing in Dwarka Expressway ?
          <span class="transition-transform duration-300 group-open:rotate-45 text-sm">
            <i class="fa-solid fa-plus"></i>
          </span>
        </summary>
        <div class="grid grid-rows-[0fr] transition-all duration-500 ease-in-out group-open:grid-rows-[1fr]">
          <div class="overflow-hidden">
            <div class="px-6 pb-4 text-gray-700 leading-relaxed">
             Yes, worth investing due to 8-12% annual appreciation and rising rentals in 2026.
            </div>
          </div>
        </div>
      </details>
      <details class="group bg-white rounded-lg shadow-md overflow-hidden transition-all duration-500">
        <summary class="flex justify-between items-center px-6 py-4 cursor-pointer text-lg font-semibold text-[var(--dark)]">
          3. Is Dwarka Expressway a Good Investment ?

          <span class="transition-transform duration-300 group-open:rotate-45 text-sm">
            <i class="fa-solid fa-plus"></i>
          </span>
        </summary>
        <div class="grid grid-rows-[0fr] transition-all duration-500 ease-in-out group-open:grid-rows-[1fr]">
          <div class="overflow-hidden">
            <div class="px-6 pb-4 text-gray-700 leading-relaxed">
             Yes, strong returns from infrastructure completion and commercial growth.
            </div>
          </div>
        </div>
      </details>
      <details class="group bg-white rounded-lg shadow-md overflow-hidden transition-all duration-500">
        <summary class="flex justify-between items-center px-6 py-4 cursor-pointer text-lg font-semibold text-[var(--dark)]">
         4. What is the construction status of Dwarka Expressway ?
          <span class="transition-transform duration-300 group-open:rotate-45 text-sm">
            <i class="fa-solid fa-plus"></i>
          </span>
        </summary>
        <div class="grid grid-rows-[0fr] transition-all duration-500 ease-in-out group-open:grid-rows-[1fr]">
          <div class="overflow-hidden">
            <div class="px-6 pb-4 text-gray-700 leading-relaxed">
             Fully operational since June 2025, with metro extension planned.
            </div>
          </div>
        </div>
      </details>
      <details class="group bg-white rounded-lg shadow-md overflow-hidden transition-all duration-500">
        <summary class="flex justify-between items-center px-6 py-4 cursor-pointer text-lg font-semibold text-[var(--dark)]">
          5. Is Dwarka Expressway good to Live in ?
          <span class="transition-transform duration-300 group-open:rotate-45 text-sm">
            <i class="fa-solid fa-plus"></i>
          </span>
        </summary>
        <div class="grid grid-rows-[0fr] transition-all duration-500 ease-in-out group-open:grid-rows-[1fr]">
          <div class="overflow-hidden">
            <div class="px-6 pb-4 text-gray-700 leading-relaxed">
             Dwarka Expressway projects offer signal-free connectivity to IGI Airport (15-20 mins), Cyber City, and Delhi via an 8-lane elevated corridor and the upcoming Metro extension.
            </div>
          </div>
        </div>
      </details>
      <details class="group bg-white rounded-lg shadow-md overflow-hidden transition-all duration-500">
        <summary class="flex justify-between items-center px-6 py-4 cursor-pointer text-lg font-semibold text-[var(--dark)]">
         6. Which Projects are Best on Dwarka Expressway ?
          <span class="transition-transform duration-300 group-open:rotate-45 text-sm">
            <i class="fa-solid fa-plus"></i>
          </span>
        </summary>
        <div class="grid grid-rows-[0fr] transition-all duration-500 ease-in-out group-open:grid-rows-[1fr]">
          <div class="overflow-hidden">
            <div class="px-6 pb-4 text-gray-700 leading-relaxed">
             Sobha City, M3M Capital, Godrej Summit, Experion Windchants.
            </div>
          </div>
        </div>
      </details>
      <details class="group bg-white rounded-lg shadow-md overflow-hidden transition-all duration-500">
        <summary class="flex justify-between items-center px-6 py-4 cursor-pointer text-lg font-semibold text-[var(--dark)]">
          7. What are the best sectors to live on Dwarka Expressway ?
          <span class="transition-transform duration-300 group-open:rotate-45 text-sm">
            <i class="fa-solid fa-plus"></i>
          </span>
        </summary>
        <div class="grid grid-rows-[0fr] transition-all duration-500 ease-in-out group-open:grid-rows-[1fr]">
          <div class="overflow-hidden">
            <div class="px-6 pb-4 text-gray-700 leading-relaxed">
             Sectors 113, 112, 111, 106, 99 for luxury and connectivity.
            </div>
          </div>
        </div>
      </details>
      <details class="group bg-white rounded-lg shadow-md overflow-hidden transition-all duration-500">
        <summary class="flex justify-between items-center px-6 py-4 cursor-pointer text-lg font-semibold text-[var(--dark)]">
          8. How many projects in Dwarka Expressway ?
          <span class="transition-transform duration-300 group-open:rotate-45 text-sm">
            <i class="fa-solid fa-plus"></i>
          </span>
        </summary>
        <div class="grid grid-rows-[0fr] transition-all duration-500 ease-in-out group-open:grid-rows-[1fr]">
          <div class="overflow-hidden">
            <div class="px-6 pb-4 text-gray-700 leading-relaxed">
             Dozens across sectors, with ~25,000 units ready by 2027.
            </div>
          </div>
        </div>
      </details>
      <details class="group bg-white rounded-lg shadow-md overflow-hidden transition-all duration-500">
        <summary class="flex justify-between items-center px-6 py-4 cursor-pointer text-lg font-semibold text-[var(--dark)]">
          9. Benefits of Dwarka Expressway project ?
          <span class="transition-transform duration-300 group-open:rotate-45 text-sm">
            <i class="fa-solid fa-plus"></i>
          </span>
        </summary>
        <div class="grid grid-rows-[0fr] transition-all duration-500 ease-in-out group-open:grid-rows-[1fr]">
          <div class="overflow-hidden">
            <div class="px-6 pb-4 text-gray-700 leading-relaxed">
             Sobha City (sports lifestyle), M3M Mansion (ultra-luxury), Godrej Meridien (amenities), and Smart World One DXP for its strategic location at the Delhi-Gurgaon border.
            </div>
          </div>
        </div>
      </details>
      <details class="group bg-white rounded-lg shadow-md overflow-hidden transition-all duration-500">
        <summary class="flex justify-between items-center px-6 py-4 cursor-pointer text-lg font-semibold text-[var(--dark)]">
          10. Dwarka Expressway is located from Where to Where ?
          <span class="transition-transform duration-300 group-open:rotate-45 text-sm">
            <i class="fa-solid fa-plus"></i>
          </span>
        </summary>
        <div class="grid grid-rows-[0fr] transition-all duration-500 ease-in-out group-open:grid-rows-[1fr]">
          <div class="overflow-hidden">
            <div class="px-6 pb-4 text-gray-700 leading-relaxed">
            Shiv Murti (Mahipalpur, Delhi) to Kherki Daula Toll Plaza (Gurgaon).
            </div>
          </div>
        </div>
      </details>
  
    </div>
  </div>
</section>

    <!-- Contact Form -->
    <section
      id="contact"
      class="relative py-32 px-6 overflow-hidden animate-on-scroll"
    >
      <!-- Background with Real Estate Imagery -->
      <div class="absolute inset-0 z-0">
        <div
          class="absolute inset-0 bg-gradient-to-br from-primary/90 via-primary/80 to-dark/90"
        ></div>
        <div
          class="absolute inset-0 bg-gradient-to-t from-dark/50 via-transparent to-transparent"
        ></div>
      </div>

      <div class="relative z-10 max-w-5xl mx-auto">
        <div
          class="bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl p-8 md:p-12 border border-white/20"
        >
          <div class="text-center mb-10">
            <h2
              class="text-3xl md:text-4xl font-heading font-bold text-dark mb-3 tracking-tight"
            >
              REQUEST A SITE VISIT TODAY
            </h2>
            <p class="text-slate-600">
              Contact us for Dwarka expressway project details
            </p>
          </div>

<form id="contactForm" action="email.php" method="POST" class="max-w-2xl mx-auto space-y-6" novalidate>
            <input type="hidden" name="form_token" value="<?php echo htmlspecialchars($formToken, ENT_QUOTES, 'UTF-8'); ?>">
            
            <!-- Full Name -->
            <div>
              <label class="block text-sm font-semibold text-dark mb-2"
                >Full Name *</label
              >
              <input
                type="text"
                class="w-full px-4 py-3 border border-borderGrey rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all bg-white"
                placeholder="Enter your full name"
                required
                name="name"
                id="nameInput"
                minlength="2"
                maxlength="50"
                pattern="[a-zA-Z\s]*"
                title="Name should contain only letters and spaces"
              />
              <span class="text-red-500 text-xs hidden" id="nameError"></span>
            </div>

            <!-- Email -->
            <div>
              <label class="block text-sm font-semibold text-dark mb-2"
                >Email Address</label
              >
              <input
                type="email"
                class="w-full px-4 py-3 border border-borderGrey rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all bg-white"
                placeholder="Enter your email address"
                name="email"
                id="emailInput"
                maxlength="100"
              />
              <span class="text-red-500 text-xs hidden" id="emailError"></span>
            </div>

            <!-- Phone -->
            <div>
              <label class="block text-sm font-semibold text-dark mb-2"
                >Phone Number *</label
              >
              <input
                type="tel"
                name="phone"
                id="phoneInput"
                class="w-full px-4 py-3 border border-borderGrey rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all bg-white"
                placeholder="+91 98765 43210"
                pattern="[\d\s\-\+\(\)]{10,}"
                minlength="10"
                maxlength="20"
                required
                title="Phone should be at least 10 digits"
              />
              <span class="text-red-500 text-xs hidden" id="phoneError"></span>
            </div>

            <!-- reCAPTCHA v2 Checkbox -->
            <?php if (!empty($recaptchaSiteKey)): ?>
            <div id="captchaContainer" class="hidden">
              <div class="g-recaptcha" data-sitekey="<?php echo htmlspecialchars($recaptchaSiteKey, ENT_QUOTES, 'UTF-8'); ?>"></div>
              <p class="text-xs text-slate-500 mt-2">Captcha is required after multiple submissions from the same IP.</p>
            </div>
            <?php endif; ?>

            <!-- Submit Button -->
            <div class="pt-4">
              <button
                type="submit"
                id="submitBtn"
                class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 px-8 rounded-lg transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98] shadow-lg hover:shadow-xl flex items-center justify-center gap-3 group"
              >
                <svg
                  class="w-5 h-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                  />
                </svg>
                <span id="submitText">Reserve Now !</span>
                
              </button>
            </div>

            <!-- Response Message -->
            <div id="formMessage" class="hidden p-4 rounded-lg text-center text-sm font-medium"></div>

            <p class="text-center text-slate-500 text-xs pt-2">
              * Required fields. We respect your privacy and will never share
              your information.
            </p>
          </form>
        </div>
      </div>
    </section>
</main>

<!-- reCAPTCHA v2 Script -->
<?php if (!empty($recaptchaSiteKey)): ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php endif; ?>

<!-- Form Handler Script -->
<script>
  // ===== LEVEL 1: FRONTEND VALIDATION =====
  const form = document.getElementById('contactForm');
  const nameInput = document.getElementById('nameInput');
  const emailInput = document.getElementById('emailInput');
  const phoneInput = document.getElementById('phoneInput');
  const submitBtn = document.getElementById('submitBtn');
  const submitText = document.getElementById('submitText');
  const formMessage = document.getElementById('formMessage');
  const captchaContainer = document.getElementById('captchaContainer');
  const originalText = submitText.textContent;
  let captchaRequiredClient = localStorage.getItem('captcha_required') === '1';

  function updateCaptchaVisibility() {
    if (!captchaContainer) return;
    captchaContainer.classList.toggle('hidden', !captchaRequiredClient);
  }
  updateCaptchaVisibility();
  
  // Spam keywords and patterns to detect
  const SPAM_KEYWORDS = [
    'viagra', 'cialis', 'casino', 'lottery', 'winner', 'congratulations',
    'click here', 'buy now', 'limited offer', 'act now', 'bitcoin',
    'crypto', 'forex', 'nigerian prince', 'inheritance', 'millionaire',
    'free money', 'make money fast', 'work from home', 'earn now',
    'xxx', 'sex', 'adult', 'dating', 'loans', 'mortgage'
  ];
  
  // LEVEL 1: Frontend validation functions
  function validateName(name) {
    if (!name || name.length < 2) return 'Name must be at least 2 characters';
    if (name.length > 50) return 'Name must not exceed 50 characters';
    if (!/^[a-zA-Z\s]*$/.test(name)) return 'Name should contain only letters and spaces';
    if (/\d+/.test(name)) return 'Name should not contain numbers';
    return null;
  }
  
  function validateEmail(email) {
    if (!email) return null; // Optional field
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) return 'Invalid email format';
    if (email.length > 100) return 'Email is too long';
    return null;
  }
  
  function validatePhone(phone) {
    if (!phone) return 'Phone is required';
    const cleaned = phone.replace(/[\s\-\(\)]/g, '');
    
    //  phone numbers: 10 digits, optionally starting with +91
    if (cleaned.startsWith('+91')) {
      if (cleaned.length !== 13) return 'Invalid phone number';
    } else {
      if (cleaned.length !== 10) return 'Phone must be 10 digits';
      if (!/^[6-9]/.test(cleaned)) return 'please type valid number';
    }
    
    if (!/^[\d+]*$/.test(cleaned)) return 'Phone should contain only numbers';
    return null;
  }
  
  // LEVEL 2: Pattern Restriction - Detect spam patterns
  function detectSpamPatterns(text, fieldType = 'text') {
    if (!text) return null;
    
    const lowerText = text.toLowerCase();
    
    // Check for spam keywords
    for (let keyword of SPAM_KEYWORDS) {
      if (lowerText.includes(keyword)) {
        return `Suspicious content detected: "${keyword}"`;
      }
    }
    
    // Check for too many URLs
    const urlCount = (text.match(/https?:\/\//gi) || []).length;
    if (urlCount > 2) return 'Too many URLs detected';
    
    // Check for excessive special characters
    const specialChars = text.replace(/[a-zA-Z0-9\s]/g, '').length;
    if (specialChars > text.length * 0.3) return 'Too many special characters';
    
    // Check for excessive numbers (skip for phone fields)
    if (fieldType !== 'phone') {
      const numberCount = (text.match(/\d/g) || []).length;
      if (numberCount > text.length * 0.5) return 'Too many numbers in text';
    }
    
    // Check for repeated characters
    if (/(.)(\1{4,})/.test(text)) return 'Repeated characters detected';
    
    return null;
  }
  
  // Real-time validation on input
  nameInput.addEventListener('blur', function() {
    const error = validateName(this.value);
    const errorEl = document.getElementById('nameError');
    if (error) {
      errorEl.textContent = error;
      errorEl.classList.remove('hidden');
      this.classList.add('border-red-500');
    } else {
      errorEl.classList.add('hidden');
      this.classList.remove('border-red-500');
    }
  });
  
  emailInput.addEventListener('blur', function() {
    const error = validateEmail(this.value);
    const errorEl = document.getElementById('emailError');
    if (error) {
      errorEl.textContent = error;
      errorEl.classList.remove('hidden');
      this.classList.add('border-red-500');
    } else {
      errorEl.classList.add('hidden');
      this.classList.remove('border-red-500');
    }
  });
  
  phoneInput.addEventListener('blur', function() {
    const error = validatePhone(this.value);
    const errorEl = document.getElementById('phoneError');
    if (error) {
      errorEl.textContent = error;
      errorEl.classList.remove('hidden');
      this.classList.add('border-red-500');
    } else {
      errorEl.classList.add('hidden');
      this.classList.remove('border-red-500');
    }
  });
  
  // Form submission with LEVEL 1 & 2 checking
  form.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // LEVEL 1: Validate all fields
    const nameError = validateName(nameInput.value);
    const emailError = validateEmail(emailInput.value);
    const phoneError = validatePhone(phoneInput.value);
    
    if (nameError || emailError || phoneError) {
      showMessage(nameError || emailError || phoneError, false);
      return;
    }
    
    // LEVEL 2: Check for spam patterns
    const nameSpam = detectSpamPatterns(nameInput.value, 'name');
    const emailSpam = detectSpamPatterns(emailInput.value, 'email');
    const phoneSpam = detectSpamPatterns(phoneInput.value, 'phone');
    
    if (nameSpam || emailSpam || phoneSpam) {
      showMessage(nameSpam || emailSpam || phoneSpam, false);
      return;
    }
    
    // All frontend validations passed, proceed to backend
    submitBtn.disabled = true;
    submitText.textContent = 'Sending...';
    
    try {
      // Validate reCAPTCHA v2
      if (!window.grecaptcha || !<?php echo json_encode(!empty($recaptchaSiteKey)); ?>) {
        showMessage('reCAPTCHA is not configured. Please try again later.', false);
        return;
      }

      if (captchaRequiredClient) {
        const token = grecaptcha.getResponse();
        if (!token) {
          showMessage('Please complete the reCAPTCHA.', false);
          return;
        }
      }
      
      // Submit form via AJAX
      const formData = new FormData(form);
      const response = await fetch('email.php', {
        method: 'POST',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
      });
      
      const result = await response.json();
      
      // Show message
      if (result.success) {
        localStorage.removeItem('captcha_required');
        if (result.redirect) {
          window.location.href = result.redirect;
          return;
        }

        showMessage(result.message, true);
        form.reset();
        
        // Hide message after 5 seconds
        setTimeout(() => {
          formMessage.textContent = '';
          formMessage.classList.add('hidden');
        }, 5000);
      } else {
        if (result.require_captcha) {
          captchaRequiredClient = true;
          localStorage.setItem('captcha_required', '1');
          updateCaptchaVisibility();
        }
        showMessage(result.message, false);
        if (window.grecaptcha) {
          grecaptcha.reset();
        }
      }
      
    } catch (error) {
      showMessage('An error occurred. Please try again.', false);
      console.error('Error:', error);
    } finally {
      // Restore button state
      submitBtn.disabled = false;
      submitText.textContent = originalText;
    }
  });
  
  // Helper function to show messages
  function showMessage(message, success) {
    formMessage.classList.remove('hidden', 'bg-red-100', 'text-red-700', 'bg-green-100', 'text-green-700');
    if (success) {
      formMessage.classList.add('bg-green-100', 'text-green-700');
      formMessage.textContent = '✓ ' + message;
    } else {
      formMessage.classList.add('bg-red-100', 'text-red-700');
      formMessage.textContent = '✗ ' + message;
    }
  }
</script>

<?php include 'inc/footer.php'; ?>
