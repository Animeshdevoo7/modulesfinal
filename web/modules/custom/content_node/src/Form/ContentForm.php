<?php

namespace Drupal\content_node\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\node\Entity\NodeType;
class ContentForm extends FormBase{
    /**   
     *  { @inheritdoc }
     */
    public function getFormId()
    {
        return 'create_node';
    }
    /**    
     * { @inheritdoc } 
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $node_types = NodeType::loadMultiple();
        // If you need to display them in a drop down:
        $options = [];
        foreach ($node_types as $node_type) {
          $options[$node_type->id()] = $node_type->label();
        }


        $form['nodes'] = array(
            '#type' => 'number',
            '#title' => ('Number of Nodes'),
            '#default_value' => '',
            '#required' => true,
            '#attributes' => array(
                'placeholder' => 'You can enter upto 5 only'
            )
        );

        $form['contype'] = array(
            '#type' => 'select',
            '#title' => 'Content Type',
            '#options' => $options,
            '#required' => true,
            '#attributes' => array(
                'placeholder' => 'Enter Content Type'
            )
            
        );

        $form['title'] = array(
            '#type' => 'textfield',
            '#title' => ('Title'),
            '#default_value' => '',
            '#required' => true,
            '#attributes' => array(
                'placeholder' => 'Your Title Here'
            )
        );

        $form['body'] = array(
            '#type' => 'textarea',
            '#title' => ('Body'),
            '#default_value' => '',
            '#required' => true,
            '#attributes' => array(
                'placeholder' => 'Description'
            )
        );

        $form['save'] = array(
            '#type' => 'submit',
            '#value' => 'Create Nodes',
            '#button_type' => 'primary'
        );
    
        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {


        $nodes = intval($form_state->getValue('nodes'));
        $contype = $form_state->getValue('contype');
        $title = $form_state->getValue('title');
        $body = $form_state->getValue('body');

        // dd($nodes,$contype,$title,$body);
        if($nodes < 5){
        for($i=0;$i<$nodes;$i++){
            $node1 = Node::create([
                'type'  => $contype,
                'title' => $title,
                'body' => $body
                ]); 
               $node1->save();
            }
            $this->messenger()->addMessage($this->t('Nodes Created Successfully'), 'status',TRUE);
    }
        else {
            $this->messenger()->addMessage($this->t('You can enter upto 5 nodes only'),'error',TRUE);
        }   

}
}
?>