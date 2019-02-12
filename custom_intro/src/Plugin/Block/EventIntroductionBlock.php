<?php

namespace Drupal\custom_intro\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\file\Entity\File;

/**
 * Provides a 'EventIntroductionBlock' block.
 *
 * @Block(
 *  id = "event_introduction_block",
 *  admin_label = @Translation("Event introduction block"),
 * )
 */
class EventIntroductionBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = \Drupal::config('custom_intro.settings');

    $introTitle = $config->get('intro_title');
    $introBackgroundImage = $config->get('intro_background_image');

    $file = $introBackgroundImage[0] ? File::load($introBackgroundImage[0]) : NULL;
    $fileUrl = $file ? $file->get('uri')->url : '';

    return [
      '#theme' => 'EventIntroduction',
      '#title' => $introTitle,
      '#backgroundImage' => $fileUrl,
    ];
  }
}
