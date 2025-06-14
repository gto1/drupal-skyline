(function ($, Drupal) {
  'use strict';

  Drupal.behaviors.skyline2ArticleGrid = {
    attach: function (context, settings) {
      const articleCards = document.querySelectorAll('.article-card');
      
      if (articleCards.length) {
        // Lazy load article card images
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

        articleCards.forEach(card => {
          const img = card.querySelector('.article-card__image');
          if (img) {
            imageObserver.observe(img);
          }
        });

        // Add hover effect for article cards
        articleCards.forEach(card => {
          card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
            this.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)';
          });

          card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)';
          });
        });
      }
    }
  };
})(jQuery, Drupal); 