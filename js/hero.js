(function ($, Drupal) {
  'use strict';

  Drupal.behaviors.skyline2Hero = {
    attach: function (context, settings) {
      const heroImages = document.querySelectorAll('.hero__image');
      
      if (heroImages.length) {
        // Lazy load hero images
        const imageObserver = new IntersectionObserver((entries, observer) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              const img = entry.target;
              const src = img.getAttribute('data-src');
              
              if (src) {
                img.src = src;
                img.removeAttribute('data-src');
                observer.unobserve(img);
              }
            }
          });
        });

        heroImages.forEach(img => {
          imageObserver.observe(img);
        });

        // Parallax effect for hero images
        window.addEventListener('scroll', function() {
          heroImages.forEach(img => {
            const scrolled = window.pageYOffset;
            const rate = scrolled * 0.5;
            img.style.transform = `translate3d(0, ${rate}px, 0)`;
          });
        });
      }
    }
  };
})(jQuery, Drupal); 