<?php

namespace Drupal\node_generator\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\node\Entity\NodeType;
class NodeGeneratorForm extends FormBase{
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
        $options = [];
        foreach ($node_types as $node_type) {
          $options[$node_type->id()] = $node_type->label();
        }

        $form['contype'] = array(
            '#type' => 'select',
            '#title' => 'Content Type',
            '#options' => $options,
            '#required' => true,
            '#attributes' => array(
                'placeholder' => 'Enter Content Type'
            )
            
        );

        $form['nodes'] = array(
            '#type' => 'number',
            '#title' => ('Number of Nodes'),
            '#default_value' => '',
            '#required' => true,
            '#attributes' => array(
                'placeholder' => 'You can enter upto 10 only'
            ),
            '#element_validate' => array([$this, 'validateNumberOfNodes'])
        );



        $form['save'] = array(
            '#type' => 'submit',
            '#value' => 'Create Nodes',
            '#button_type' => 'primary'
        );
    
        return $form;
    }


    public function validateNumberOfNodes($element, FormStateInterface $form_state, $form) {
        $value = $form_state->getValue('nodes');
        if (!is_numeric($value) || $value < 2 || $value > 10) {
            $form_state->setError($element, $this->t('Number of Nodes must be a numeric value between 2 and 10.'));
        }
    }
    public function submitForm(array &$form, FormStateInterface $form_state)
    {

        $nodes = intval($form_state->getValue('nodes'));
        $contype = $form_state->getValue('contype');

        for($i=0;$i<$nodes;$i++){
            $node1 = Node::create([
                'type'  => $contype,
                'title' => 'hello'
                ]); 
               $node1->save();
            
            $this->messenger()->addMessage($this->t('Nodes Created Successfully'), 'status',TRUE);
    }


}
}
?>