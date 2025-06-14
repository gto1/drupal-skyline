<?php

/**
 * @file
 * Contains theme settings for the Skyline2 theme.
 */

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\File\FileSystemInterface;

/**
 * Implements hook_form_FORM_ID_alter() for system_theme_settings.
 */
function skyline2_form_system_theme_settings_alter(&$form, FormStateInterface $form_state) {
  // Create a new section for Skyline2 theme settings.
  $form['skyline2_settings'] = [
    '#type' => 'details',
    '#title' => t('Skyline2 Theme Settings'),
    '#open' => TRUE,
  ];

  // Hero section settings.
  $form['skyline2_settings']['hero'] = [
    '#type' => 'details',
    '#title' => t('Hero Section Settings'),
    '#open' => TRUE,
  ];

  $form['skyline2_settings']['hero']['hero_height'] = [
    '#type' => 'select',
    '#title' => t('Hero Section Height'),
    '#default_value' => theme_get_setting('hero_height'),
    '#options' => [
      'small' => t('Small (40vh)'),
      'medium' => t('Medium (50vh)'),
      'large' => t('Large (60vh)'),
    ],
    '#description' => t('Select the height of the hero section.'),
  ];

  $form['skyline2_settings']['hero']['hero_overlay'] = [
    '#type' => 'select',
    '#title' => t('Hero Overlay Style'),
    '#default_value' => theme_get_setting('hero_overlay'),
    '#options' => [
      'light' => t('Light'),
      'dark' => t('Dark'),
      'gradient' => t('Gradient'),
    ],
    '#description' => t('Select the overlay style for the hero section.'),
  ];

  // Article grid settings.
  $form['skyline2_settings']['article_grid'] = [
    '#type' => 'details',
    '#title' => t('Article Grid Settings'),
    '#open' => TRUE,
  ];

  $form['skyline2_settings']['article_grid']['grid_columns'] = [
    '#type' => 'select',
    '#title' => t('Grid Columns'),
    '#default_value' => theme_get_setting('grid_columns'),
    '#options' => [
      '2' => t('2 Columns'),
      '3' => t('3 Columns'),
      '4' => t('4 Columns'),
    ],
    '#description' => t('Select the number of columns in the article grid.'),
  ];

  $form['skyline2_settings']['article_grid']['card_style'] = [
    '#type' => 'select',
    '#title' => t('Card Style'),
    '#default_value' => theme_get_setting('card_style'),
    '#options' => [
      'minimal' => t('Minimal'),
      'elevated' => t('Elevated'),
      'bordered' => t('Bordered'),
    ],
    '#description' => t('Select the style for article cards.'),
  ];

  // Color settings.
  $form['skyline2_settings']['colors'] = [
    '#type' => 'details',
    '#title' => t('Color Settings'),
    '#open' => TRUE,
  ];

  $form['skyline2_settings']['colors']['primary_color'] = [
    '#type' => 'color',
    '#title' => t('Primary Color (Dark Blue)'),
    '#default_value' => theme_get_setting('primary_color') ?: '#2D374F',
    '#description' => t('Select the primary color for the theme.'),
  ];

  $form['skyline2_settings']['colors']['secondary_color'] = [
    '#type' => 'color',
    '#title' => t('Secondary Color (Light Blue)'),
    '#default_value' => theme_get_setting('secondary_color') ?: '#B0CEEA',
    '#description' => t('Select the secondary color for the theme.'),
  ];

  $form['skyline2_settings']['colors']['accent_light'] = [
    '#type' => 'color',
    '#title' => t('Light Accent Color (Light Yellow)'),
    '#default_value' => theme_get_setting('accent_light') ?: '#FBECB4',
    '#description' => t('Select the light accent color for the theme.'),
  ];

  $form['skyline2_settings']['colors']['accent_dark'] = [
    '#type' => 'color',
    '#title' => t('Dark Accent Color (Dark Yellow)'),
    '#default_value' => theme_get_setting('accent_dark') ?: '#FAC739',
    '#description' => t('Select the dark accent color for the theme.'),
  ];

  // Typography settings.
  $form['skyline2_settings']['typography'] = [
    '#type' => 'details',
    '#title' => t('Typography Settings'),
    '#open' => TRUE,
  ];

  $form['skyline2_settings']['typography']['base_font_size'] = [
    '#type' => 'select',
    '#title' => t('Base Font Size'),
    '#default_value' => theme_get_setting('base_font_size'),
    '#options' => [
      '14' => t('Small (14px)'),
      '16' => t('Medium (16px)'),
      '18' => t('Large (18px)'),
    ],
    '#description' => t('Select the base font size for the theme.'),
  ];

  // Add submit handler.
  $form['#submit'][] = 'skyline2_theme_settings_submit';
}

/**
 * Implements hook_form_FORM_ID_submit() for system_theme_settings.
 */
function skyline2_theme_settings_submit($form, FormStateInterface $form_state) {
  // Generate CSS file with theme settings.
  $css = [];
  
  // Add color variables.
  $css[] = ':root {';
  $css[] = '  --color-primary: ' . $form_state->getValue('primary_color') . ';';
  $css[] = '  --color-secondary: ' . $form_state->getValue('secondary_color') . ';';
  $css[] = '  --color-accent-light: ' . $form_state->getValue('accent_light') . ';';
  $css[] = '  --color-accent-dark: ' . $form_state->getValue('accent_dark') . ';';
  $css[] = '}';
  
  // Add hero height.
  $hero_heights = [
    'small' => '40vh',
    'medium' => '50vh',
    'large' => '60vh',
  ];
  $css[] = '.hero {';
  $css[] = '  height: ' . $hero_heights[$form_state->getValue('hero_height')] . ';';
  $css[] = '}';
  
  // Add base font size.
  $css[] = 'html {';
  $css[] = '  font-size: ' . $form_state->getValue('base_font_size') . 'px;';
  $css[] = '}';
  
  // Write CSS to file.
  $file_path = \Drupal::service('file_system')->saveData(
    implode("\n", $css),
    'public://skyline2-theme-settings.css',
    FileSystemInterface::EXISTS_REPLACE
  );
  
  // Attach CSS file to theme.
  if ($file_path) {
    \Drupal::configFactory()
      ->getEditable('skyline2.settings')
      ->set('theme_settings_css', $file_path)
      ->save();
  }
} 