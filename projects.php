<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/config.php';
$recaptchaSiteKey = getenv('RECAPTCHA_SITE_KEY') ?: '';
if (empty($_SESSION['form_token']) || !is_string($_SESSION['form_token'])) {
    $_SESSION['form_token'] = bin2hex(random_bytes(32));
}
$formToken = $_SESSION['form_token'];

if (!empty($_SERVER['REQUEST_URI']) && preg_match('#^/home/[^/]+/public_html/(.*)#i', $_SERVER['REQUEST_URI'], $m)) {
    $normalized = '/' . ltrim($m[1], '/');
    header('Location: ' . $normalized, true, 301);
    exit;
}

if (empty($_GET['slug']) && !empty($_SERVER['REQUEST_URI'])) {
    // Extract the path from the URL (e.g., /whiteland-westin-residences)
    $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    
    if (preg_match('#^projects/([A-Za-z0-9\-]+)#i', $path, $m)) {
        $_GET['slug'] = $m[1];
    } 

    elseif (!empty($path) && !preg_match('/\.(php|html|css|js|png|jpg|webp)$/i', $path)) {
        $_GET['slug'] = $path;
    }
}

if (empty($_GET['slug'])) {
    http_response_code(400);
    die("Slug missing or invalid");
}
$slugRaw = trim((string)$_GET['slug']);

if (!preg_match('/^[A-Za-z0-9\-]+$/', $slugRaw)) {
    http_response_code(400);
    die("Invalid slug format");
}
$slug = strtolower($slugRaw);

$url = "https://dwarkaexpresswayncr-backend.onrender.com/api/projects/" . urlencode($slug);

require_once __DIR__ . '/vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;

$client = new Client([
    'timeout' => 15,
    'connect_timeout' => 10,
    'allow_redirects' => true,
]);

$caCandidates = [
    ini_get('curl.cainfo') ?: null,
    ini_get('openssl.cafile') ?: null,
    __DIR__ . '/cacert.pem',
    __DIR__ . '/extras/ssl/cacert.pem',
    'C:\\xampp\\php\\extras\\ssl\\cacert.pem',
];
$caSet = false;
$defaultVerify = true;
foreach ($caCandidates as $c) {
    if ($c && file_exists($c)) {
        $defaultVerify = $c;
        $caSet = true;
        break;
    }
}

$options = [
    'headers' => ['Accept' => 'application/json'],
    'verify' => $defaultVerify,
    'http_errors' => false, // return response for non-2xx so we can check status
];

$response = null;
$lastExceptionMessage = null;
$attempts = 0;

// Try up to a few strategies: default verify, try discovered CA, finally disable verify (dev last-resort)
while ($attempts < 3) {
    $attempts++;
    try {
        $res = $client->get($url, $options);
        $response = (string) $res->getBody();
        $httpCode = $res->getStatusCode();
        break;
    } catch (ConnectException $e) {
        // network/connectivity issues
        $lastExceptionMessage = $e->getMessage();
        break;
    } catch (RequestException $e) {
        $handlerCtx = $e->getHandlerContext() ?: [];
        // try common places for cURL error code
        $errno = $handlerCtx['errno'] ?? $handlerCtx['curl_errno'] ?? null;
        $lastExceptionMessage = $e->getMessage();

        // detect SSL related failure even if errno isn't present
        $msgLower = strtolower($lastExceptionMessage);
        $sslError = in_array($errno, [60, 51], true)
            || str_contains($msgLower, 'curl error 60')
            || str_contains($msgLower, 'ssl certificate')
            || str_contains($msgLower, 'unable to get local issuer certificate');

        if ($sslError) {
            // If we haven't found a CA bundle yet, scan candidates now and use first found
            if (!$caSet) {
                foreach ($caCandidates as $c) {
                    if ($c && file_exists($c)) {
                        $options['verify'] = $c;
                        $caSet = true;
                        // try again with this CA bundle
                        continue 2;
                    }
                }
            }

            // Last-resort (development only): disable verification so local dev can proceed
            if ($options['verify'] !== false) {
                $options['verify'] = false;
                $lastExceptionMessage .= " (SSL verification disabled as a last-resort for local development - insecure)";
                // retry with verification disabled
                continue;
            }
        }

        // Not an SSL error or fallback exhausted — give up and report
        break;
    }
}

if ($response === null) {
    $help = "HTTP REQUEST ERROR: " . ($lastExceptionMessage ?? 'Unknown error') . ".";
    $help .= "\nSuggested fixes: install guzzle (composer require guzzlehttp/guzzle), set curl.cainfo / openssl.cafile in php.ini or download cacert.pem from https://curl.se/ca/cacert.pem and point to it.";
    die(nl2br(htmlspecialchars($help)));
}

if ($httpCode < 200 || $httpCode >= 300) {
    http_response_code(404);
    header('Location: /redirect-404.html', true, 302);
    exit;
}
        
        $project = json_decode($response, true);
        
        if (!$project || !isset($project['name'])) {
            http_response_code(404);
            header('Location: /redirect-404.html', true, 302);
            exit;
            }
            
        // Auto-populate gallery if empty
        if (empty($project['gallery']) && !empty($project['slug'])) {
            $slug = $project['slug'];
            $dir = __DIR__ . '/assets/img/' . $slug;
            if (is_dir($dir)) {
                $files = glob($dir . '/gal*.jpg');
                $project['gallery'] = array_map(function($file) use ($slug) {
                    $basename = basename($file);
                    return [
                        'url' => '/assets/img/' . $slug . '/' . $basename,
                        'alt' => ucfirst(str_replace(['gal', '.jpg'], ['Gallery image ', ''], $basename))
                    ];
                }, $files);
            }
        }
            
            $title = $project['metaTitle']
            ?? ($project['name'] . " - Dwarka Expressway");
            
            $description = $project['metaDescription']
            ?? substr($project['about']['content'] ?? $project['name'], 0, 160);
?>
<!DOCTYPE html>
<html lang="en">
    
    <head>
        <title><?= htmlspecialchars($title) ?></title>
       <meta name="description" content="<?= htmlspecialchars($description) ?>">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- ensure relative links resolve from site root (fixes wrong /home/... URLs in the browser) -->
        <?php
            $baseHref = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? '') . '/';
        ?>
        <base href="<?= htmlspecialchars($baseHref) ?>">
        <link rel="icon" href="assets/img/favicon.png" sizes="32x32">
    <?php if (!empty($project['ogImage'])): ?>
        <meta property="og:image" content="<?= htmlspecialchars($project['ogImage']) ?>">
        <meta property="og:image:secure_url" content="<?= htmlspecialchars($project['ogImage']) ?>">
    <?php else: ?>
        <meta property="og:image" content="https://dwarkaexpresswayncr.com/assets/img/Og-Image.png">
        <meta property="og:image:secure_url" content="https://dwarkaexpresswayncr.com/assets/img/Og-Image.png">
    <?php endif; ?>
      <meta property="og:image:type" content="image/png">
      <meta property="og:image:alt" content="DwarkaExpressWayNCR">
      <meta property="og:image:width" content="1200">
      <meta property="og:image:height" content="630">
        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- Open Graph -->
    <meta property="og:title" content="<?= htmlspecialchars($title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($description) ?>">
    <?php if (!empty($project['ogImage'])): ?>
        <meta property="og:image" content="<?= htmlspecialchars($project['ogImage']) ?>">
    <?php endif; ?>
     <link rel="stylesheet" href="assets/style.css">
     <script src="https://kit.fontawesome.com/c1d1e2319d.js" crossorigin="anonymous"></script>
     <link
      href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap"
      rel="stylesheet"/>
    <!-- JSON-LD -->
        <?php
        
        $rawPrice = $project['price']; 
        
        $cleanPrice = preg_replace('/[^0-9.a-zA-Z]/', '', $rawPrice);
        
        $finalPrice = 0;
        if (stripos($cleanPrice, 'Cr') !== false) {
            $number = (float)str_ireplace('Cr', '', $cleanPrice);
            $finalPrice = $number * 10000000;
        } elseif (stripos($cleanPrice, 'L') !== false) {
            $number = (float)str_ireplace('L', '', $cleanPrice);
            $finalPrice = $number * 100000;
        } else {
            $finalPrice = (float)preg_replace('/[^0-9.]/', '', $cleanPrice);
        }
        
        $schemaData = [
            "@context" => "https://schema.org",
            "@type" => "ApartmentComplex", 
            "name" => $project['name'],
            "description" => strip_tags($description),
            "image" => $project['ogImage'] ?? "https://yourwebsite.com/default-image.jpg",
            "url" => "https://dwarkaexpresswayncr.com/" . ($project['slug'] ?? ""),
            
            // Detailed Address Block for Google recognition
            "address" => [
                "@type" => "PostalAddress",
                "streetAddress" => $project['location'] ?? "Sector Name/Area",
                "addressLocality" => $project['city'] ?? "City Name",          
                "addressRegion" => $project['state'] ?? "State Name",          
                "postalCode" => $project['pincode'] ?? "000000",               
                "addressCountry" => "IN"
            ],

        ];
        
        echo '<script type="application/ld+json">' . PHP_EOL;
        echo json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        echo PHP_EOL . '</script>';
        ?>
     <style>
        :root {
            --primary: #f14201;
            --dark: #111111;
            --dark-secondary: #0a0a0a;
            --light-grey: #f4f4f4;
            --border-grey: #e5e7eb;
        }

        /* Use DM Sans site-wide (fallback to sans-serif) */
        body {
            font-family: 'DM Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            filter: brightness(0.9);
        }

        .text-primary {
            color: var(--primary);
        }

        .border-primary {
            border-color: var(--primary);
        }

        .bg-primary {
            background-color: var(--primary);
        }

        .bg-dark {
            background-color: var(--dark);
        }

        .text-dark {
            color: var(--dark);
        }

        .bg-light-grey {
            background-color: var(--light-grey);
        }

        .hero-gradient {
            background: linear-gradient(135deg, rgba(241, 66, 1, 0.05) 0%, rgba(241, 66, 1, 0.1) 100%);
        }

        .section-title {
            color: var(--dark);
            font-weight: 600;
            font-size: 1.5rem;
        }
        
          @keyframes slowZoom {
        0% { transform: scale(1); }
        100% { transform: scale(1.1); }
    }
    .animate-slow-zoom {
        animation: slowZoom 20s infinite alternate linear;
    }

        @media (max-width: 768px) {
            .section-title {
                font-size: 1rem;
            }
            .custom-mob-font-size{
                font-size: 1rem;
            }
        }
        
    </style>
</head>

<body class="min-h-screen font-sans"
      style="background-color: rgba(var(--primary-rgb),0.05);">
    
    <?php include 'inc/header.php'; ?>
    <!-- HERO SECTION WITH IMAGE -->
  <section class="relative w-full h-[750px] md:h-[650px] sd:h-[860] overflow-hidden bg-black pt-12">
    <?php if (!empty($project['hero']['image'])): ?>
        <img 
            src="<?= htmlspecialchars($project['hero']['image']) ?>" 
            alt="<?= htmlspecialchars($project['name']) ?>" 
            class="absolute inset-0 w-full h-full object-cover opacity-80 scale-105 animate-slow-zoom"
        >
    <?php else: ?>
        <div class="absolute inset-0" style="background: linear-gradient(135deg, var(--dark) 0%, var(--dark-secondary) 100%);"></div>
    <?php endif; ?>

    <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/20 to-black/90"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-transparent to-black/60"></div>

    <div class="relative z-10 flex flex-col items-center justify-center text-center h-full px-6 -mt-20">
        <span class="px-4 py-1 rounded-full text-xs font-bold tracking-[0.4em] uppercase mb-4 border border-[var(--primary)] text-white bg-black/40 backdrop-blur-sm">
            Premium Real Estate
        </span>
        <span class="px-4 py-1 rounded-full text-xs font-bold tracking-[0.4em] uppercase mb-4 border border-[var(--primary)] text-white bg-black/40 backdrop-blur-sm">
            Rera Approved
        </span>
        
        <h1 class="text-5xl md:text-7xl font-black text-white mb-4 tracking-tight">
            <?= htmlspecialchars($project['hero']['heading'] ?? $project['name']) ?>
        </h1>
        
        <div class="w-24 h-1 mb-6" style="background-color: var(--primary);"></div>
        
        <p class="text-lg md:text-2xl max-w-2xl font-light leading-relaxed" style="color: var(--light-grey);">
            <?= htmlspecialchars($project['hero']['subText'] ?? 'Experience the pinnacle of luxury living.') ?>
        </p>

        <div class="flex flex-col md:flex-row gap-4 my-2">
            <button onclick="document.getElementById('project-contact').scrollIntoView({behavior: 'smooth'})" 
                class="px-10 py-4 font-bold uppercase tracking-widest text-sm transition-all hover:scale-105 active:scale-95 shadow-lg"
                style="background-color: var(--primary); color: white; border-radius: 4px;">
                Schedule a Site Visit
            </button>
            <button onclick="openEmiPopup()" 
                class="px-10 py-4 font-bold uppercase tracking-widest text-sm transition-all hover:bg-white hover:text-black border border-white text-white"
                style="background-color: transparent; border-radius: 4px;">
                Emi Calculator
            </button>
        </div>
    </div>
    
    <div class="absolute md:bottom-8 bottom-5 left-0 right-0 z-20">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-0 border overflow-hidden shadow-2xl" 
                 style="background-color: var(--dark-secondary); border-color: rgba(255,255,255,0.1);">
                
                <div class="py-6 border-r border-b md:border-b-0 border-[rgba(255,255,255,0.1)] text-center group hover:bg-black/40 transition-colors">
                    <p class="text-[10px] uppercase tracking-[0.2em] mb-1" style="color: var(--primary);">Land Area</p>
                    <p class="text-xl font-bold text-white uppercase"><?= htmlspecialchars($project['landSize'] ?? '4.5 Acres') ?></p>
                </div>
                
                <div class="py-6 border-r border-b md:border-b-0 border-[rgba(255,255,255,0.1)] text-center group hover:bg-black/40 transition-colors">
                    <p class="text-[10px] uppercase tracking-[0.2em] mb-1" style="color: var(--primary);">Possession</p>
                    <p class="text-xl font-bold text-white uppercase"><?= htmlspecialchars($project['hero']['possession'] ?? 'Oct 2031') ?></p>
                </div>
                
                <div class="py-6 border-r border-[rgba(255,255,255,0.1)] text-center group hover:bg-black/40 transition-colors">
                    <p class="text-[10px] uppercase tracking-[0.2em] mb-1" style="color: var(--primary);">Starting Price</p>
                    <p class="text-xl font-bold text-white uppercase"><?= htmlspecialchars($project['price'] ?? '5.25 Cr*') ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- MAIN CONTENT -->
    <main class="max-w-6xl mx-auto px-4 py-12">

        <!-- ABOUT SECTION WITH IMAGE -->
   <?php if (!empty($project['about']['content'])): ?>
    <section class="rounded-2xl overflow-hidden my-12 shadow-2xl border" 
             style="background-color: var(--dark); border-color: var(--border-grey);">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
            
            <div class="p-8 md:p-16 flex flex-col justify-center relative">
                <span class="text-xs uppercase tracking-[0.3em] font-bold mb-4 block" style="color: var(--primary);">
                    Discover More
                </span>
                
                <h2 class="text-3xl md:text-5xl font-black text-white mb-6 leading-tight">
                    <?= htmlspecialchars($project['about']['title'] ?? 'About Project') ?>
                </h2>

                <div class="pl-6 border-l-2" style="border-color: var(--primary);">
                    <p class="text-base leading-relaxed mb-6" style="color: var(--light-grey);">
                        <?= (htmlspecialchars($project['about']['content'])) ?>
                    </p>
                </div>
            
                
                <div class="mt-4">
                    <a onclick="document.getElementById('project-contact').scrollIntoView({behavior: 'smooth'})" class="inline-block px-8 py-3 rounded-full font-bold uppercase text-xs tracking-widest transition-all hover:opacity-90"
                       style="background-color: var(--primary); color: white;">
                        Get More Details
                    </a>
                </div>
            </div>

            <div class="relative overflow-hidden min-h-[400px]">
                <?php if (!empty($project['about']['image'])): ?>
                    <div class="absolute inset-0 z-10 hidden md:block bg-gradient-to-r from-[var(--dark)] to-transparent w-1/4"></div>
                    
                    <img src="<?= htmlspecialchars($project['about']['image']) ?>" 
                         alt="<?= htmlspecialchars($project['name'] . ' — About image') ?>" 
                         class="w-full h-full object-cover transition duration-700 hover:scale-110">
                <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center" style="background-color: var(--dark-secondary);">
                        <p class="text-white text-lg font-semibold opacity-30 uppercase tracking-widest">No image available</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
        <!-- AMENITIES SECTION -->
    <section class="max-w-6xl mx-auto px-4 mb-16 py-12 rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.5)] border"
         style="background-color: var(--dark-secondary); border-color: rgba(229, 231, 235, 0.1);">
    
    <h2 class="text-3xl md:text-4xl font-bold mb-12 text-center uppercase tracking-tight"
        style="color: var(--primary)">
        <span class="text-white">Amenities</span>
    </h2>

    <?php
    // helper: map amenity label to a free Font Awesome icon class
    function amenity_icon($label) {
        $a = strtolower((string)$label);
        $map = [
            [['gym','fitness'], 'fa-solid fa-dumbbell'],
            [['swim','pool','swimming'], 'fa-solid fa-person-swimming'],
            [['park','garden','landscap','green'], 'fa-solid fa-tree'],
            [['parking','car','vehicle'], 'fa-solid fa-car'],
            [['security','guard','cctv','gated'], 'fa-solid fa-shield'],
            [['lift','elevator'], 'fa-solid fa-building'],
            [['club','clubhouse','community'], 'fa-solid fa-users'],
            [['tennis'], 'fa-solid fa-table-tennis-paddle-ball'],
            [['basketball'], 'fa-solid fa-basketball'],
            [['shopping','shop','supermarket','store'], 'fa-solid fa-shop'],
            [['hospital','clinic','medical'], 'fa-solid fa-hospital'],
            [['school','college','education'], 'fa-solid fa-school'],
            [['wifi','internet','broadband'], 'fa-solid fa-wifi'],
            [['power','backup','generator','genset'], 'fa-solid fa-bolt'],
            [['jog','jogging','track','running'], 'fa-solid fa-walking'],
            [['restaurant','cafe','cafeteria','food'], 'fa-solid fa-utensils'],
            [['spa','sauna','steam'], 'fa-solid fa-spa'],
            [['cinema','movie','theatre','theater'], 'fa-solid fa-film'],
            [['banquet','party','events'], 'fa-solid fa-martini-glass'],
            [['play','kids','children','playground'], 'fa-solid fa-child'],
            [['lake','pond','waterbody','water'], 'fa-solid fa-water'],
            [['terrace','balcony'], 'fa-solid fa-house'],
        ];

        foreach ($map as $m) {
            foreach ($m[0] as $kw) {
                if (strpos($a, $kw) !== false) return $m[1];
            }
        }
        return 'fa-solid fa-circle-check';
    }
    ?>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <?php foreach ($project['amenities'] as $a): ?>
            <div class="group relative p-6 rounded-xl border transition-all duration-300 hover:-translate-y-2"
                 style="background-color: var(--dark); border-color: var(--border-grey);">
                
                <div class="absolute inset-0 opacity-0 group-hover:opacity-10 transition-opacity duration-300 rounded-xl"
                     style="background: radial-gradient(circle at center, var(--primary), transparent);"></div>

                <div class="relative z-10 text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full mb-4 transition-transform duration-300 group-hover:scale-110"
                         style="background-color: var(--dark-secondary); border: 1px solid rgba(241,66,1,0.3);">
                        <i class="<?= amenity_icon($a) ?> text-lg" style="color: var(--primary)"></i>
                    </div>
                    
                    <p class="font-bold tracking-wide uppercase text-xs md:text-sm" 
                       style="color: white;">
                        <?= htmlspecialchars($a) ?>
                    </p>
                    
                    <div class="mt-4 h-0.5 w-8 mx-auto transition-all duration-300 group-hover:w-16"
                         style="background-color: var(--primary);"></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

       <?php if (!empty($project['connectivityMap'])): ?>
    <section class="rounded-xl p-8 md:p-12 mb-12 shadow-[0_10px_30px_rgba(0,0,0,0.5)] border" 
             style="background-color: var(--dark-secondary); border-color: var(--border-grey);">
        
        <h2 class="text-3xl font-bold mb-10 text-center uppercase tracking-tight" style="color: white;">
            Connectivity <span style="color: var(--primary)">Map</span>
        </h2>

        <?php
        $cm = $project['connectivityMap'];

        // --- CASE 1: PLAIN URL (IMAGE) ---
        if (is_string($cm) && preg_match('/^(https?:)?\\/\\//', $cm)) {
            echo '<div class="relative overflow-hidden rounded-lg group border" style="border-color: var(--border-grey);">';
            // The Gradient Overlay
            echo '<div class="absolute inset-0 z-10 bg-gradient-to-t from-[var(--dark)] via-transparent to-transparent opacity-60"></div>';
            echo '<img src="'.htmlspecialchars($cm).'" alt="Connectivity map" class="w-full h-auto transition duration-500 group-hover:scale-105">';
            echo '</div>'; 

        // --- CASE 2: ARRAY (EMBED, IMAGE, OR POINTS) ---
        } elseif (is_array($cm)) {  
            $isAssoc = array_keys($cm) !== range(0, count($cm) - 1);

            if ($isAssoc) {
                // Google Maps Embed
                if (!empty($cm['embed'])) {
                    echo '<div class="w-full h-96 overflow-hidden rounded-lg border shadow-inner" style="border-color: var(--border-grey);">';
                    echo '<iframe src="'.htmlspecialchars($cm['embed']).'" class="w-full h-96 border-0 grayscale hover:grayscale-0 transition-all duration-700" loading="lazy"></iframe>';
                    echo '</div>';
                } 
                // Specific Image Key
                elseif (!empty($cm['image'])) {
                    echo '<div class="relative overflow-hidden rounded-lg group border" style="border-color: var(--border-grey);">';
                    echo '<div class="absolute inset-0 z-10 bg-gradient-to-tr from-[var(--dark)] via-transparent to-[var(--primary)] opacity-30"></div>';
                    echo '<img src="'.htmlspecialchars($cm['image']).'" class="w-full h-96 object-cover transition duration-500 group-hover:scale-110">';
                    echo '</div>'; 
                } 
                // Grid of Points
                elseif (!empty($cm['points']) && is_array($cm['points'])) {
                    echo '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">';
                    foreach ($cm['points'] as $pt) {
                        $label = is_array($pt) ? ($pt['label'] ?? $pt['name'] ?? '') : $pt;
                        $sub = is_array($pt) ? ($pt['distance'] ?? '') : '';
                        echo '<div style="background-color: var(--dark); border-bottom: 3px solid var(--primary);" class="p-6 rounded-lg hover:bg-[var(--dark-secondary)] transition group">';
                        echo '<p class="text-white font-semibold text-center group-hover:text-[var(--primary)] transition">'.htmlspecialchars($label).'</p>';
                        if($sub) echo '<p class="text-xs text-center mt-2 uppercase tracking-widest" style="color: var(--light-grey);">'.htmlspecialchars($sub).'</p>';
                        echo '</div>';
                    }
                    echo '</div>';
                }

            } else {
                // Numeric array - Simple List Cards
                echo '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">';
                foreach ($cm as $item) {
                    echo '<div style="background-color: var(--dark); border-left: 4px solid var(--primary);" class="p-6 rounded-lg shadow-lg">';
                    echo '<p style="color: var(--light-grey);" class="font-medium text-center">'.htmlspecialchars(is_array($item) ? json_encode($item) : $item).'</p>';
                    echo '</div>';
                }
                echo '</div>';
            }

        } else {
            // Fallback
            echo '<pre style="background: var(--dark); color: var(--light-grey);" class="p-4 rounded border border-gray-800">'.htmlspecialchars(print_r($cm, true)).'</pre>';
        }
        ?>
    </section>
<?php endif; ?>
      



        <!-- FAQs SECTION -->
       <?php if (!empty($project['faqs'])): ?>
    <section class="rounded-lg shadow-xl p-8 md:p-12 mb-12 border" 
             style="background-color: var(--dark); border-color: var(--border-grey);">
        
        <h2 class="text-3xl md:text-4xl font-bold mb-8" style="color: white;">
            Frequently Asked <span style="color: var(--primary);">Questions</span>
        </h2>
        
        <div class="space-y-2">
            <?php foreach ($project['faqs'] as $index => $faq): ?>
                <details class="group rounded-md transition-all duration-300 border-b last:border-b-0" 
                         style="border-color: rgba(229, 231, 235, 0.1);">
                    
                    <summary class="list-none py-5 px-2 cursor-pointer flex items-center justify-between text-white hover:opacity-80 transition-opacity">
                        <span class="text-lg font-semibold flex items-center gap-4">
                            <i class="fa-solid fa-plus text-sm transition-transform duration-300 group-open:rotate-45" 
                               style="color: var(--primary);"></i>
                            <?= htmlspecialchars($faq['question']) ?>
                        </span>
                    </summary>

                    <div class="pb-6 px-10">
                        <p class="leading-relaxed" style="color: var(--light-grey);">
                            <?= htmlspecialchars($faq['answer']) ?>
                        </p>
                    </div>
                </details>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>

        <!-- CONTACT / SITE VISIT SECTION -->
       <section id="project-contact" 
    class="rounded-lg md:p-12 mb-10 py-10 shadow-[0_5px_20px_rgba(241,66,1,0.25)]"
    style="background-color: var(--dark-secondary);">
    
    <h2 class="text-3xl md:text-4xl font-bold text-primary mb-6 text-center">
        Reserve Your Slot Today!
    </h2>
    
    <div class="grid md:grid-cols-2 gap-8 px-5">
        <div class="p-6 rounded-lg border" style="background-color: var(--dark); border-color: var(--border-grey);">
<form id="projectContactForm" action="email.php" method="POST" class="space-y-4" novalidate>
                <input type="hidden" name="form_token" value="<?= htmlspecialchars($formToken, ENT_QUOTES, 'UTF-8') ?>">
                <input type="hidden" name="form_load_time" value="<?= time() ?>">
                <input type="hidden" name="subject" value="<?= htmlspecialchars('Site visit request: ' . ($project['name'] ?? 'Project')) ?>">
                <input type="hidden" name="project" value="<?= htmlspecialchars($project['name']) ?>">
                
                <!-- HONEYPOT - Hidden from real users, bots will fill this -->
                <div style="position: absolute; left: -9999px; opacity: 0; height: 0; overflow: hidden;" aria-hidden="true">
                    <label for="project_website_url">Leave this field empty</label>
                    <input type="text" name="website_url" id="project_website_url" tabindex="-1" autocomplete="off">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1 text-white">Name*</label>
                    <input name="name" id="projectNameInput" type="text" required minlength="2" maxlength="50"
                        class="w-full px-4 py-2 rounded focus:outline-none focus:ring-2" 
                        style="background: var(--dark-secondary); color: white; border: 1px solid var(--border-grey); --tw-ring-color: var(--primary);" 
                        placeholder="Your name">
                    <span id="projectNameError" class="text-red-400 text-xs hidden"></span>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1 text-white">Phone*</label>
                    <input name="phone" id="projectPhoneInput" type="tel" required minlength="10" maxlength="20"
                        class="w-full px-4 py-2 rounded focus:outline-none focus:ring-2" 
                        style="background: var(--dark-secondary); color: white; border: 1px solid var(--border-grey); --tw-ring-color: var(--primary);" 
                        placeholder="WhatsApp or phone number">
                    <span id="projectPhoneError" class="text-red-400 text-xs hidden"></span>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1 text-white">Message</label>
                    <textarea name="message" id="projectMessageInput" rows="4" 
                        class="w-full px-4 py-2 rounded focus:outline-none focus:ring-2" 
                        style="background: var(--dark-secondary); color: white; border: 1px solid var(--border-grey); --tw-ring-color: var(--primary);" 
                        placeholder="Any details or questions"></textarea>
                </div>

                <?php if (!empty($recaptchaSiteKey)): ?>
                <div id="projectCaptchaContainer" class="hidden">
                    <div class="g-recaptcha" data-sitekey="<?= htmlspecialchars($recaptchaSiteKey, ENT_QUOTES, 'UTF-8') ?>"></div>
                    <p class="text-xs mt-2" style="color: var(--light-grey);">Captcha fill is required </p>
                </div>
                <?php endif; ?>

                <div id="projectFormMessage" class="hidden p-3 rounded text-sm font-medium"></div>

                <div class="w-full">
                    <button type="submit" id="projectSubmitBtn"
                        class="w-full md:w-auto px-8 py-3 rounded font-bold transition-transform hover:scale-105" 
                        style="background-color: var(--primary); color: white;">
                        <span id="projectSubmitText">Request Site Visit</span>
                    </button>
                </div>
            </form>
        </div>

        <div class="space-y-6 px-3 md-px-0">
            <div class="flex items-start space-x-4 p-6 rounded-lg border border-opacity-20" 
                 style="background-color: var(--dark); border-color: var(--primary);">
                <i class="fa-solid fa-envelope text-2xl mt-1" style="color: var(--primary);"></i>
                <div class="text-white">
                    <p class="font-semibold">Get in Touch</p>
                    <p class="text-sm mt-1">
                        Email: <a href="mailto:info@dwarkaexpresswayncr.com" class="hover:underline" style="color: var(--light-grey);">info@dwarkaexpresswayncr.com</a>
                    </p>
                    <p class="text-sm mt-1">
                        Phone: <a href="tel:+919873702365" class="hover:underline" style="color: var(--light-grey);">+91 9873702365</a>
                    </p>
                </div>
            </div>

            <div class="flex items-start space-x-4 p-6 rounded-lg" style="background-color: var(--dark);">
                <i class="fa-solid fa-clock text-2xl mt-1" style="color: var(--primary);"></i>
                <div class="text-white">
                    <h3 class="font-semibold text-lg">Office Hours</h3>
                    <p class="text-sm mt-1" style="color: var(--light-grey);">Mon - Sat: 9:00 AM - 6:00 PM</p>
                </div>
            </div>

            <div class="flex items-center space-x-3 p-4 rounded-lg" 
                 style="background-color: var(--dark-secondary); border: 1px dashed var(--border-grey);">
                <i class="fa-solid fa-shield-heart text-2xl" style="color: var(--primary);"></i>
                <div class="text-white">
                    <h2 class="font-bold">100% Secure</h2>
                    <p class="text-xs" style="color: var(--light-grey);">Your data is protected with bank-level security</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- GALLERY SECTION -->
<?php if (!empty($project['gallery'])): ?>
<section class="max-w-6xl mx-auto px-4 mb-16 py-12 rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.5)] border"
     style="background-color: var(--dark-secondary); border-color: rgba(229, 231, 235, 0.1);">

<h2 class="text-3xl md:text-4xl font-bold mb-12 text-center uppercase tracking-tight"
    style="color: var(--primary)">
    <span class="text-white">Project</span> Gallery
</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($project['gallery'] as $image): ?>
        <div class="group relative overflow-hidden rounded-xl border transition-all duration-300 hover:-translate-y-2"
             style="border-color: var(--border-grey);">
            
            <a href="<?= htmlspecialchars($image['url']) ?>" 
               class="glightbox" 
               data-gallery="project-gallery">
                <img src="<?= htmlspecialchars($image['url']) ?>" 
                     alt="<?= htmlspecialchars($image['alt'] ?? $project['name']) ?>" 
                     class="w-full h-64 object-cover transition duration-500 group-hover:scale-110">
            </a>
            
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            
            <div class="absolute bottom-0 left-0 right-0 p-4 text-white transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                <p class="font-semibold text-sm">
                    <?= htmlspecialchars($image['alt'] ?? 'Project Image') ?>
                </p>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</section>
<?php endif; ?>

    </main>
    <!-- Include GLightbox script -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        const lightbox = GLightbox({
            selector: '.glightbox'
        });
    </script>
    <?php if (!empty($recaptchaSiteKey)): ?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <?php endif; ?>
    <script>
        (function () {
            const form = document.getElementById('projectContactForm');
            if (!form) return;

            const nameInput = document.getElementById('projectNameInput');
            const phoneInput = document.getElementById('projectPhoneInput');
            const messageInput = document.getElementById('projectMessageInput');
            const nameError = document.getElementById('projectNameError');
            const phoneError = document.getElementById('projectPhoneError');
            const submitBtn = document.getElementById('projectSubmitBtn');
            const submitText = document.getElementById('projectSubmitText');
            const formMessage = document.getElementById('projectFormMessage');
            const captchaContainer = document.getElementById('projectCaptchaContainer');
            const originalText = submitText ? submitText.textContent : 'Request Site Visit';
            let captchaRequiredClient = localStorage.getItem('captcha_required') === '1';

            function updateCaptchaVisibility() {
                if (!captchaContainer) return;
                captchaContainer.classList.toggle('hidden', !captchaRequiredClient);
            }

            function showMessage(message, success) {
                if (!formMessage) return;
                formMessage.classList.remove('hidden', 'bg-red-100', 'text-red-700', 'bg-green-100', 'text-green-700');
                if (success) {
                    formMessage.classList.add('bg-green-100', 'text-green-700');
                    formMessage.textContent = '✓ ' + message;
                } else {
                    formMessage.classList.add('bg-red-100', 'text-red-700');
                    formMessage.textContent = '✗ ' + message;
                }
            }

            function validateName(name) {
                if (!name || name.length < 2) return 'Name must be at least 2 characters';
                if (name.length > 50) return 'Name must not exceed 50 characters';
                if (!/^[a-zA-Z\s]*$/.test(name)) return 'Name should contain only letters and spaces';
                if (/\d+/.test(name)) return 'Name should not contain numbers';
                return null;
            }

            function validatePhone(phone) {
                if (!phone) return 'Phone is required';
                const cleaned = phone.replace(/[\s\-\(\)]/g, '');
                if (cleaned.length < 10) return 'Phone must be at least 10 digits';
                if (!/^[\d+]*$/.test(cleaned)) return 'Phone should contain only numbers and valid characters';
                return null;
            }

            function detectSpamPatterns(text, fieldType) {
                if (!text) return null;
                const lowerText = text.toLowerCase();
                const keywords = ['viagra','casino','lottery','click here','buy now','bitcoin','crypto','forex','nigerian prince','free money'];
                for (const keyword of keywords) {
                    if (lowerText.includes(keyword)) return `Suspicious content detected: "${keyword}"`;
                }
                const urlCount = (text.match(/https?:\/\//gi) || []).length;
                if (urlCount > 2) return 'Too many URLs detected';
                if (fieldType !== 'phone') {
                    const numberCount = (text.match(/\d/g) || []).length;
                    if (numberCount > text.length * 0.5) return 'Too many numbers in text';
                }
                if (/(.)(\1{4,})/.test(text)) return 'Repeated characters detected';
                return null;
            }

            updateCaptchaVisibility();

            form.addEventListener('submit', async function (e) {
                e.preventDefault();

                const nameErr = validateName(nameInput.value);
                const phoneErr = validatePhone(phoneInput.value);
                const nameSpam = detectSpamPatterns(nameInput.value, 'name');
                const phoneSpam = detectSpamPatterns(phoneInput.value, 'phone');
                const messageSpam = detectSpamPatterns(messageInput.value || '', 'text');

                nameError.classList.add('hidden');
                phoneError.classList.add('hidden');
                if (nameErr) {
                    nameError.textContent = nameErr;
                    nameError.classList.remove('hidden');
                    return;
                }
                if (phoneErr) {
                    phoneError.textContent = phoneErr;
                    phoneError.classList.remove('hidden');
                    return;
                }
                if (nameSpam || phoneSpam || messageSpam) {
                    showMessage(nameSpam || phoneSpam || messageSpam, false);
                    return;
                }

                submitBtn.disabled = true;
                if (submitText) submitText.textContent = 'Sending...';

                try {
                    if (!window.grecaptcha || !<?= json_encode(!empty($recaptchaSiteKey)); ?>) {
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

                    const formData = new FormData(form);
                    const response = await fetch('email.php', {
                        method: 'POST',
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                        body: formData
                    });

                    const result = await response.json();
                    if (result.success) {
                        localStorage.removeItem('captcha_required');
                        if (result.redirect) {
                            window.location.href = result.redirect;
                            return;
                        }
                        showMessage(result.message, true);
                        form.reset();
                    } else {
                        if (result.require_captcha) {
                            captchaRequiredClient = true;
                            localStorage.setItem('captcha_required', '1');
                            updateCaptchaVisibility();
                        }
                        showMessage(result.message, false);
                        if (window.grecaptcha) grecaptcha.reset();
                    }
                } catch (err) {
                    showMessage('An error occurred. Please try again.', false);
                } finally {
                    submitBtn.disabled = false;
                    if (submitText) submitText.textContent = originalText;
                }
            });
        })();
    </script>

    <?php if (!empty($project['gallery'])): ?>

<?php endif; ?>
<?php include 'inc/footer.php'; ?>
