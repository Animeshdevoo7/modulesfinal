<?php

namespace Drupal\rating_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class RatingForm extends FormBase {

  public function getFormId() {
    return 'rating_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#required' => true,
    );

    $form['rating'] = array(
      '#type' => 'radios',
      '#title' => $this->t('Feedback'),
      '#options' => array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'),
      '#default_value' => '1',
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    );

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
   $postdata =[
    'name' => $form_state->getValue('name'),
    'rating' => $form_state->getValue('rating')
   ];
//    dd($postdata);
 
    $query = \Drupal::database();
        $query->insert('feedback_data')->fields($postdata)->execute();
    
    $this->messenger()->addMessage($this->t('Data Saved Successfully'), 'status',TRUE);
  }
}
