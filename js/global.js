(function ($, Drupal) {
  'use strict';

  Drupal.behaviors.skyline2Global = {
    attach: function (context, settings) {
      // Add smooth scrolling to all links
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
          e.preventDefault();
          const target = document.querySelector(this.getAttribute('href'));
          if (target) {
            target.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });
          }
        });
      });

      // Add active class to current page in navigation
      const currentPath = window.location.pathname;
      document.querySelectorAll('.main-nav__link').forEach(link => {
        if (link.getAttribute('href') === currentPath) {
          link.classList.add('is-active');
        }
      });

      // Add back to top button
      const backToTop = document.createElement('button');
      backToTop.className = 'back-to-top';
      backToTop.innerHTML = '↑';
      backToTop.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: var(--color-primary);
        color: white;
        border: none;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        transition: background-color 0.2s ease;
      `;

      document.body.appendChild(backToTop);

      window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
          backToTop.style.display = 'flex';
        } else {
          backToTop.style.display = 'none';
        }
      });

      backToTop.addEventListener('click', function() {
        window.scrollTo({
          top: 0,
          behavior: 'smooth'
        });
      });

      // Add loading indicator
      window.addEventListener('load', function() {
        document.body.classList.add('loaded');
      });
    }
  };
})(jQuery, Drupal); 