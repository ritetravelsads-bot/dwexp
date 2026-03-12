<footer class="bg-white border-t border-gray-200 pt-16 pb-8">
    <div class="fixed bottom-6 right-6 z-50 flex flex-col gap-4">
    <a href="https://wa.me/+919873702365" aria-label="Description"
       class="group relative flex items-center justify-center w-14 h-14 bg-green-600 rounded-full shadow-lg transition-transform hover:scale-110 active:scale-95 animate-bounce-subtle">
        <i class="fa-brands fa-whatsapp text-white text-3xl"></i>
        <span class="absolute inset-0 rounded-full bg-green-600 animate-ping opacity-20"></span>
    </a>

    <a href="tel:+919873702365" aria-label="Description" 
       class="group flex items-center justify-center w-14 h-14 bg-primary rounded-full shadow-lg transition-transform hover:scale-110 active:scale-95">
        <i class="fa-solid fa-phone text-white text-2xl"></i>
    </a>
</div>

    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
            
            <div class="space-y-6">
                <img src="assets/img/logo.png" alt="Dwarka Expressway logo" class="w-40" />
                <p class="text-gray-600 text-sm leading-relaxed">
                    Connecting Delhi and Gurgaon through world-class infrastructure, the Dwarka Expressway is the new heartbeat of luxury real estate. Explore premium living through luxury apartments and high-growth residential projects in India’s first elevated urban expressway corridor.
                </p>
                <div class="flex gap-4">
                    <a href="https://www.instagram.com/dwarkaexpresswayncr" class="w-9 h-9 flex items-center justify-center rounded-full bg-primary text-white hover:bg-primary hover:text-white transition-all">
                        <i class="fa-brands fa-instagram text-lg"></i>
                    </a>
                    <a href="https://www.facebook.com/profile.php?id=61586373907850" class="w-9 h-9 flex items-center justify-center rounded-full bg-primary text-white hover:bg-primary hover:text-white transition-all">
                        <i class="fa-brands fa-facebook-f text-lg"></i>
                    </a>
                </div>
            </div>

            <div>
                <h3 class="text-black font-bold uppercase tracking-wider text-sm mb-6 border-b-2 border-primary w-fit pb-1">Navigation</h3>
                <ul class="space-y-4">
                    <li><a href="/" class="text-gray-600 hover:text-primary transition-colors text-sm font-medium">Home</a></li>
                    <li><a href="#projects" class="text-gray-600 hover:text-primary transition-colors text-sm font-medium">Featured Projects</a></li>
                    <li><a href="#location" class="text-gray-600 hover:text-primary transition-colors text-sm font-medium">Location Map</a></li>
                    <li><a href="/blogs" class="text-gray-600 hover:text-primary transition-colors text-sm font-medium">Industry Insights (Blogs)</a></li>
                    <li><a href="/about" class="text-gray-600 hover:text-primary transition-colors text-sm font-medium">About Us</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-black font-bold uppercase tracking-wider text-sm mb-6 border-b-2 border-primary w-fit pb-1">Get in Touch</h4>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-envelope text-primary mt-1"></i>
                        <div>
                            <span class="block text-xs text-black uppercase font-bold">Email Us</span>
                            <a href="mailto:info@dwarkaexpresswayncr.com" class="text-gray-700 text-sm break-all">info@dwarkaexpresswayncr.com</a>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-phone-volume text-primary mt-1"></i>
                        <div>
                            <span class="block text-xs text-balck uppercase font-bold">Call Support</span>
                            <a href="tel:+919873702365" class="text-gray-700 text-sm">+91 9873702365</a>
                        </div>
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="text-black font-bold uppercase tracking-wider text-sm mb-6 border-b-2 border-primary w-fit pb-1">Financial Tools</h4>
                <p class="text-gray-500 text-xs mb-4">Plan your investment better with our easy-to-use calculator.</p>
                <button onclick="document.getElementById('emiPopup').classList.remove('hidden')" 
                        class="flex items-center gap-2 bg-orange-700 text-white px-5 py-3 rounded-lg text-base font-semibold transition-all shadow-md">
                    <i class="fa-solid fa-calculator"></i> EMI Calculator
                </button>
            </div>
        </div>

        <div class="border-t border-gray-100 pt-8 pb-4 text-center">
            <button onclick="toggleShow()" class="text-sm font-bold text-orange-700 flex items-center justify-center mx-auto gap-1 transition-colors uppercase tracking-widest">
                Disclaimer <i class="fa-solid fa-chevron-down text-[10px]"></i>
            </button>
            <p id="discription" class="mt-4 text-[11px] text-gray-800 leading-relaxed max-w-4xl mx-auto hidden bg-gray-50 p-4 rounded-lg">
              The content provided on this website is for information purpose only and is
              not an offer to avail of any services. This is not the official website of
              the builder or owner and it belongs to channel partner. All rights for logo
              and images reserved for the builder. The prices mentioned on the website are
              subject to change without any prior notice and availability of properties
              can not be guaranteed. The images displayed on the website are for
              representation purposes only and may not reflect the actual properties
              accurately. The specifications, dimensions, services, facilities, &
              infrastructure are illustrative & indicative and are subject to the change
              as per the approval from the respective authorities. The company has not
              verified the information and the compliances of the projects. The company
              does not make any representation in regards to the compliances done against
              these projects. Please note that the company has not checked the RERA*
              registration status. Purpose of this domain only for information, not
              claiming official website and projects.
            </p>
        </div>

        <div class="mt-4 text-center text-[11px] text-gray-800 uppercase tracking-widest">
            &copy; 2026 Dwarka Expressway NCR. Designed for Excellence.
        </div>
        
        
    </div>
</footer>

<div>
    <form
  id="formclose" action="email.php" method="POST"
  class="hidden fixed inset-0 z-50 items-center bg-primary/20 px-8">
  <input type="hidden" name="form_token" value="<?php echo htmlspecialchars($formToken ?? ((session_status() === PHP_SESSION_ACTIVE && !empty($_SESSION['form_token'])) ? $_SESSION['form_token'] : ''), ENT_QUOTES, 'UTF-8'); ?>">
  <input type="hidden" name="form_load_time" value="<?php echo time(); ?>">
  
  <!-- HONEYPOT - Hidden from real users, bots will fill this -->
  <div style="position: absolute; left: -9999px; opacity: 0; height: 0; overflow: hidden;" aria-hidden="true">
    <label for="popup_website_url">Leave this field empty</label>
    <input type="text" name="website_url" id="popup_website_url" tabindex="-1" autocomplete="off" />
  </div>

  <div
    class="relative md:left-1/3 bg-white/80 backdrop-blur-md px-4 py-6 rounded-lg shadow-md md:w-full max-w-md top-1/4 md:top-20"
  >
    <!-- Close Button -->
    <button
      type="button"
      aria-label="close"
     onclick="togglePops()"
     class="absolute top-3 right-3 cursor-pointer">
<i class="fa-solid fa-x text-primary"></i>
</button>

    <h2 class="text-center text-xl sm:text-2xl py-4">
      Speak with Our Property Expert
    </h2>

    <div class="rounded-md">
      <div class="mb-4">
        <label class="block text-black mb-1">Name*</label>
        <input
          type="text" name="name"
          id="popupNameInput"
          class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-1 focus:ring-gray-600"
          placeholder="Enter your name"
          minlength="2"
          maxlength="50"
          pattern="[a-zA-Z\s]*"
          required
        />
        <span class="text-red-500 text-xs hidden" id="popupNameError"></span>
      </div>

      <div class="mb-4">
        <label class="block text-black mb-1">Email</label>
        <input
          type="email" name="email"
          id="popupEmailInput"
          class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-1 focus:ring-gray-600"
          placeholder="Enter your email"
          maxlength="100"
        />
        <span class="text-red-500 text-xs hidden" id="popupEmailError"></span>
      </div>

      <div class="mb-4">
        <label for="phoneinput" class="block text-black mb-1">WhatsApp Number*</label>
        <input
          type="tel" id="phoneinput" name="phone"
          class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-1 focus:ring-gray-600"
          placeholder="Enter your WhatsApp number"
          minlength="10"
          maxlength="20"
          pattern="[\d\s\-\+\(\)]{10,}"
          required
        />
        <span class="text-red-500 text-xs hidden" id="popupPhoneError"></span>
      </div>

      <div class="mb-4">
        <label for="addinput" class="block text-black mb-1">Address</label>
        <input
          type="text" id="addinput"
          class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-1 focus:ring-gray-600"
          placeholder="Enter your address" name="message"
          maxlength="200"
        />
      </div>

      <!-- Response Message for Popup -->
      <div id="popupFormMessage" class="hidden p-3 rounded-lg text-center text-sm font-medium mb-4"></div>

      <button
        type="submit"
        id="popupSubmitBtn"
        class="w-full bg-black text-white py-2 rounded hover:bg-blue-700 transition"
      >
        <span id="popupSubmitText">Submit</span>
      </button>
    </div>
  </div>
</form>
</div>

<!-- Popup Form Validation Script -->
<script>
(function() {
  const popupForm = document.getElementById('formclose');
  const popupNameInput = document.getElementById('popupNameInput');
  const popupEmailInput = document.getElementById('popupEmailInput');
  const popupPhoneInput = document.getElementById('phoneinput');
  const popupSubmitBtn = document.getElementById('popupSubmitBtn');
  const popupSubmitText = document.getElementById('popupSubmitText');
  const popupFormMessage = document.getElementById('popupFormMessage');

  // Validation functions (same as main form)
  function validateName(name) {
    if (!name || name.length < 2) return 'Name must be at least 2 characters';
    if (name.length > 50) return 'Name must not exceed 50 characters';
    if (!/^[a-zA-Z\s]*$/.test(name)) return 'Name should contain only letters and spaces';
    if (/\d+/.test(name)) return 'Name should not contain numbers';
    return null;
  }

  function validateEmail(email) {
    if (!email) return null;
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) return 'Invalid email format';
    if (email.length > 100) return 'Email is too long';
    return null;
  }

  function validatePhone(phone) {
    if (!phone) return 'Phone is required';
    const cleaned = phone.replace(/[\s\-\(\)]/g, '');
    if (cleaned.startsWith('+91')) {
      if (cleaned.length !== 13) return 'Invalid phone number';
    } else {
      if (cleaned.length !== 10) return 'Phone must be 10 digits';
      if (!/^[6-9]/.test(cleaned)) return 'Please enter a valid number';
    }
    if (!/^[\d+]*$/.test(cleaned)) return 'Phone should contain only numbers';
    return null;
  }

  function showPopupMessage(message, success) {
    popupFormMessage.classList.remove('hidden', 'bg-red-100', 'text-red-700', 'bg-green-100', 'text-green-700');
    if (success) {
      popupFormMessage.classList.add('bg-green-100', 'text-green-700');
      popupFormMessage.textContent = message;
    } else {
      popupFormMessage.classList.add('bg-red-100', 'text-red-700');
      popupFormMessage.textContent = message;
    }
  }

  // Real-time validation
  if (popupNameInput) {
    popupNameInput.addEventListener('blur', function() {
      const error = validateName(this.value);
      const errorEl = document.getElementById('popupNameError');
      if (error) {
        errorEl.textContent = error;
        errorEl.classList.remove('hidden');
        this.classList.add('border-red-500');
      } else {
        errorEl.classList.add('hidden');
        this.classList.remove('border-red-500');
      }
    });
  }

  if (popupEmailInput) {
    popupEmailInput.addEventListener('blur', function() {
      const error = validateEmail(this.value);
      const errorEl = document.getElementById('popupEmailError');
      if (error) {
        errorEl.textContent = error;
        errorEl.classList.remove('hidden');
        this.classList.add('border-red-500');
      } else {
        errorEl.classList.add('hidden');
        this.classList.remove('border-red-500');
      }
    });
  }

  if (popupPhoneInput) {
    popupPhoneInput.addEventListener('blur', function() {
      const error = validatePhone(this.value);
      const errorEl = document.getElementById('popupPhoneError');
      if (error) {
        errorEl.textContent = error;
        errorEl.classList.remove('hidden');
        this.classList.add('border-red-500');
      } else {
        errorEl.classList.add('hidden');
        this.classList.remove('border-red-500');
      }
    });
  }

  // Form submission
  if (popupForm) {
    popupForm.addEventListener('submit', async function(e) {
      e.preventDefault();

      const nameError = validateName(popupNameInput?.value || '');
      const emailError = validateEmail(popupEmailInput?.value || '');
      const phoneError = validatePhone(popupPhoneInput?.value || '');

      if (nameError || emailError || phoneError) {
        showPopupMessage(nameError || emailError || phoneError, false);
        return;
      }

      popupSubmitBtn.disabled = true;
      popupSubmitText.textContent = 'Sending...';

      try {
        const formData = new FormData(popupForm);
        const response = await fetch('email.php', {
          method: 'POST',
          headers: { 'X-Requested-With': 'XMLHttpRequest' },
          body: formData
        });

        const result = await response.json();

        if (result.success) {
          if (result.redirect) {
            window.location.href = result.redirect;
            return;
          }
          showPopupMessage(result.message, true);
          popupForm.reset();
          setTimeout(() => {
            popupFormMessage.classList.add('hidden');
            togglePops();
          }, 3000);
        } else {
          showPopupMessage(result.message, false);
        }
      } catch (error) {
        showPopupMessage('An error occurred. Please try again.', false);
        console.error('Error:', error);
      } finally {
        popupSubmitBtn.disabled = false;
        popupSubmitText.textContent = 'Submit';
      }
    });
  }
})();
</script>

<div id="emiPopup" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeEmiPopup()"></div>
    <div class="relative bg-white w-full max-w-md p-8 rounded-2xl shadow-2xl border-t-8 border-primary animate-in fade-in zoom-in duration-300">
        <button onclick="closeEmiPopup()" class="absolute top-4 right-4 text-gray-400 hover:text-dark transition-transform hover:rotate-90">
            <i class="fa-solid fa-xmark text-2xl"></i>
        </button>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">EMI Calculator</h2>
        <p class="text-gray-500 text-sm mb-6">Calculate your monthly mortgage payments instantly.</p>
        
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Loan Amount (₹)</label>
                <input id="loanAmount" type="number" placeholder="5,000,000" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:bg-white outline-none transition-all" />
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Rate (%)</label>
                    <input id="interestRate" type="number" placeholder="8.5" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:bg-white outline-none transition-all" />
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Years</label>
                    <input id="loanTenure" type="number" placeholder="20" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:bg-white outline-none transition-all" />
                </div>
            </div>
            <button onclick="calculateEMI()" class="w-full bg-primary text-white py-4 rounded-xl font-bold shadow-lg shadow-primary/30 hover:shadow-primary/50 transition-all transform active:scale-95">
                Calculate Monthly EMI
            </button>
            <div id="emiResult" class="mt-2 text-center py-4 rounded-xl font-bold text-lg text-primary bg-primary/5 border border-primary/10"></div>
        </div>
    </div>
</div>

<style>
@keyframes bounce-subtle {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-5px); }
}
.animate-bounce-subtle {
  animation: bounce-subtle 3s infinite ease-in-out;
}
</style>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>

const swiper = new Swiper('.heroSwiper', {
		loop: true,
		autoplay: {
			delay: 5000
		},
		pagination: {
			el: '.swiper-pagination',
			clickable: true
		},
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev'
		},
	});

 const menuBtn = document.getElementById("menuBtn");
  const mobileMenu = document.getElementById("mobileMenu");

  // Toggle menu
  menuBtn.addEventListener("click", (e) => {
    e.stopPropagation();
    mobileMenu.classList.toggle("hidden");
  });

  // Close menu when clicking outside
  document.addEventListener("click", (e) => {
    if (!mobileMenu.contains(e.target) && !menuBtn.contains(e.target)) {
      mobileMenu.classList.add("hidden");
    }
  });

  // Close menu when clicking a link
  mobileMenu.querySelectorAll("a").forEach(link => {
    link.addEventListener("click", () => {
      mobileMenu.classList.add("hidden");
    });
  });

	 function toggleShow(){
          const discription = document.getElementById("discription");
          if(discription.style.display == "none"){
           discription.style.display = "block"
        }
          else{
            discription.style.display = "none"
          }
        };

		 const formclose = document.getElementById("formclose");
            const showform = document.getElementById("showform");


            function togglePops() {
                formclose.classList.toggle("hidden");
                showform.classList.toggle("hidden");
            }

            function showForm() {
                if (formclose.classList.contains("hidden")) {
                    formclose.classList.remove("hidden");
                    showform.classList.add("hidden");
                } else {
                    formclose.classList.add("hidden");
                    showform.classList.remove("hidden");
                }
            }

//  Project Filter and Auto-Suggestion Functionality

document.addEventListener("DOMContentLoaded", function () {
  // Get filter elements
  const projectFilter = document.getElementById("projectFilter");
  const locationFilter = document.getElementById("locationFilter");
  const budgetFilter = document.getElementById("budgetFilter");
  const projectSuggestions = document.getElementById("projectSuggestions");
  const projectCards = document.querySelectorAll(".project-card");

  // Extract unique projects and locations from the cards
  const allProjects = [];
  const allLocations = new Set();
  const allPrices = new Map();

  projectCards.forEach((card) => {
    const projectName = card.querySelector("h3")?.textContent.trim();
    const locationText = card
      .querySelector("p i")
      ?.nextSibling?.textContent?.trim();
    const priceText = card.querySelector(".text-red-700")?.textContent?.trim();

    if (projectName) {
      allProjects.push(projectName);
      if (priceText) {
        const priceValue = priceText.replace(/[₹\s*]/g, "");
        allPrices.set(projectName, priceValue);
      }
    }

    if (locationText) {
      const location = locationText.split(",")[0].trim();
      allLocations.add(location);
    }
  });

  // Project name filter with auto-suggestions
  if (projectFilter) {
    projectFilter.addEventListener("input", function () {
      const value = this.value.toLowerCase().trim();

      if (value.length === 0) {
        projectSuggestions.classList.add("hidden");
        return;
      }

      // Filter projects matching the input
      const filtered = allProjects.filter((project) =>
        project.toLowerCase().includes(value),
      );

      if (filtered.length === 0) {
        projectSuggestions.classList.add("hidden");
        return;
      }

      // Show suggestions
      projectSuggestions.innerHTML = filtered
        .map(
          (project) =>
            `<li class="px-4 py-2 hover:bg-primary/10 cursor-pointer transition" data-project="${project}">${project}</li>`,
        )
        .join("");
      projectSuggestions.classList.remove("hidden");

      // Add click listeners to suggestions
      projectSuggestions.querySelectorAll("li").forEach((li) => {
        li.addEventListener("click", function () {
          projectFilter.value = this.dataset.project;
          projectSuggestions.classList.add("hidden");
          filterProjects();
        });
      });
    });

    // Close suggestions when clicking outside
    document.addEventListener("click", function (e) {
      if (e.target !== projectFilter && e.target !== projectSuggestions) {
        projectSuggestions.classList.add("hidden");
      }
    });
  }

  // Location filter
  if (locationFilter) {
    locationFilter.addEventListener("input", filterProjects);
  }

  // Budget filter
  if (budgetFilter) {
    budgetFilter.addEventListener("change", filterProjects);
  }

  // Main filtering function
  function filterProjects() {
    const projectValue = projectFilter?.value.toLowerCase().trim() || "";
    const locationValue = locationFilter?.value.toLowerCase().trim() || "";
    const budgetValue = budgetFilter?.value || "";

    projectCards.forEach((card) => {
      const projectName =
        card.querySelector("h3")?.textContent.toLowerCase().trim() || "";
      const locationText =
        card
          .querySelector("p i")
          ?.nextSibling?.textContent?.toLowerCase()
          .trim() || "";
      const priceText =
        card.querySelector(".text-red-700")?.textContent?.trim() || "";

      // Check project name match
      const projectMatch =
        projectValue === "" || projectName.includes(projectValue);

      // Check location match
      const locationMatch =
        locationValue === "" || locationText.includes(locationValue);

      // Check budget match
      let budgetMatch = budgetValue === "";
      if (budgetValue && budgetValue !== "") {
        const priceValue = parseFloat(priceText.replace(/[₹\s,Cr]/g, ""));

        switch (budgetValue) {
          case "1-2.5":
           budgetMatch = priceValue >= 1 && priceValue <= 2.5;
            break;
          case "2.5-5":
            budgetMatch = priceValue >= 2.5 && priceValue <= 5;
            break;
          case "5-6":
            budgetMatch = priceValue > 5 && priceValue <= 6;
            break;
          case "6+":
            budgetMatch = priceValue > 6;
            break;
          default:
            budgetMatch = true;
        }
      }

      // Show or hide card based on all filters
      if (projectMatch && locationMatch && budgetMatch) {
        card.style.display = "";
        card.classList.add("animate-fadeIn");
      } else {
        card.style.display = "none";
      }
    });

    // Check if any results are shown
    const visibleCards = Array.from(projectCards).some(
      (card) => card.style.display !== "none",
    );

    // Optionally show a "no results" message
    if (!visibleCards) {
      console.log("No projects match your filters");
    }
  }

  // Toggle modal popup
  window.togglePops = function () {
    const form = document.getElementById("formclose");
    if (form) {
      form.classList.toggle("hidden");
      form.classList.toggle("flex");
    }
  };
});


function openEmiPopup() {
  document.getElementById("emiPopup").style.display = "block";
}

function closeEmiPopup() {
  document.getElementById("emiPopup").style.display = "none";
}

function calculateEMI() {
  const P = parseFloat(document.getElementById("loanAmount").value);
  const R = parseFloat(document.getElementById("interestRate").value) / 12 / 100;
  const N = parseFloat(document.getElementById("loanTenure").value) * 12;

  if (!P || !R || !N) {
    document.getElementById("emiResult").innerHTML = "Please enter all values";
    return;
  }

  const EMI = (P * R * Math.pow(1 + R, N)) / (Math.pow(1 + R, N) - 1);
  document.getElementById("emiResult").innerHTML =
    `Monthly EMI: ₹ ${EMI.toFixed(2)}`;
}

</script>
</body>

</html>
