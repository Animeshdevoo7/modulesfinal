<?php
namespace Drupal\rating_form\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'DefaultBlock' block.
 * @Block(
 *  id = "default_block",
 *  admin_label = @Translation("My Block"),
 *  )
 */



class CustomBlock extends BlockBase{

/**
 * { @inheritdoc}
 */

 public function build(){
    return \Drupal::formBuilder()->getForm('Drupal\rating_form\Form\RatingForm');
 }
}









?>
