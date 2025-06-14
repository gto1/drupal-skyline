(function ($, Drupal) {
  'use strict';

  Drupal.behaviors.skyline2Navigation = {
    attach: function (context, settings) {
      console.log('Navigation behavior attaching...');
      
      // Only attach once
      once('skyline2-navigation', '.main-nav', context).forEach(function (element) {
        console.log('Found navigation element:', element);
        
        const $nav = $(element);
        const $mobileToggle = $nav.find('.main-nav__mobile-toggle');
        const $menu = $nav.find('.main-nav__menu');
        const $body = $('body');

        console.log('Mobile toggle found:', $mobileToggle.length);
        console.log('Menu found:', $menu.length);

        // Toggle mobile menu
        $mobileToggle.on('click', function (e) {
          console.log('Mobile toggle clicked');
          e.preventDefault();
          e.stopPropagation();
          $menu.toggleClass('is-active');
          $(this).toggleClass('is-active');
          $(this).attr('aria-expanded', $menu.hasClass('is-active'));
        });

        // Close mobile menu when clicking outside
        $body.on('click', function (e) {
          if (!$(e.target).closest('.main-nav').length) {
            $menu.removeClass('is-active');
            $mobileToggle.removeClass('is-active');
            $mobileToggle.attr('aria-expanded', 'false');
          }
        });

        // Close mobile menu when window is resized to desktop size
        $(window).on('resize', function () {
          if (window.innerWidth > 1024) {
            $menu.removeClass('is-active');
            $mobileToggle.removeClass('is-active');
            $mobileToggle.attr('aria-expanded', 'false');
          }
        });
      });
    }
  };
})(jQuery, Drupal); 