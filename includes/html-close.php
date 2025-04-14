
    <!-- bootstrap file Js-->
    <script src="./bootstrap-dist/js/bootstrap.bundle.min.js"></script>
   
    <!-- fontawesome cdn -->
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"
      integrity="sha512-b+nQTCdtTBIRIbraqNEwsjB6UvL3UEMkXnhzd8awtCYh0Kcsjl9uEgwVFVbhoj3uu1DO1ZMacNvLoyJJiNfcvg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <!-- swiper js cdn -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
   <script>
    var swiper = new Swiper(".mySwiper", {
    effect: "coverflow",
    grabCursor: true,
    centeredSlides: true,
    autoplay: {
      delay: 3000, // Time in ms between slide transitions
      disableOnInteraction: false, // Continue autoplay even after user interactions
    },
    slidesPerView: "auto",
    coverflowEffect: {
      rotate: 50,
      stretch: 0,
      depth: 100,
      modifier: 1,
      slideShadows: true,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      320: {
        slidesPerView: 1, // 1 slide visible for small screens
        spaceBetween: 10,
      },
      640: {
        slidesPerView: 2, // 2 slides visible for medium screens
        spaceBetween: 20,
      },
      1024: {
        slidesPerView: 2, // 3 slides visible for large screens
        spaceBetween: 30,
      },
    },
  });


  var swiper = new Swiper(".mySwiper2", {
  effect: "cards",           // Card effect for the slides
  grabCursor: true,          // Show a grabbing cursor when interacting with the swiper
  autoplay: {
    delay: 5000,             // 5 seconds autoplay delay
    disableOnInteraction: false,  // Continue autoplay after user interaction
  },
  navigation: {
    nextEl: ".swiper-button-next",  // Next slide button
    prevEl: ".swiper-button-prev",  // Previous slide button
  },
  pagination: {
    el: ".swiper-pagination",   // Pagination (dots)
    clickable: true,            // Allow clicking on dots to navigate
  },
});

let lastScrollTop = 0;
const defaultNavbar = document.getElementById('defaultNavbar');
const scrolledNavbar = document.getElementById('scrolledNavbar');

window.addEventListener('scroll', function() {
  let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

  if (scrollTop > lastScrollTop) {
    // Scrolling down
    defaultNavbar.style.display = 'none';
    scrolledNavbar.style.display = 'block';
  } else {
    // Scrolling up
    defaultNavbar.style.display = 'block';
    scrolledNavbar.style.display = 'none';
  }
  lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; // For Mobile or negative scrolling
});


function addToFavorites(productId, productType) {
    fetch('add_to_favorites.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ product_id: productId, product_type: productType })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Product added to favorites!');
        } else {
            alert('Failed to add product to favorites.');
        }
    })
    .catch(error => console.error('Error:', error));
}
   </script>
  </body>
</html>