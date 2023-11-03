<?php

namespace Drupal\node_json_data\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
class Configform extends ConfigFormBase {

    /**
     * Settings Variable.
     */
    Const CONFIGNAME = "node_json_data.settings";

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return "node_json_data_settings";
    }

    /**
     * {@inheritdoc}
     */

    protected function getEditableConfigNames() {
        return [
            static::CONFIGNAME,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $config= \Drupal::config('node_json_data.settings');
        // $publishnode=$config->get('checked');
        $config = $this->config(static::CONFIGNAME);
        $form['api_key'] = [
            '#type' => 'textfield',
            '#title' => 'Api key',
            '#element_validate' => ['::validateApiKeyLength'],
        ];
        // $form['checked']['#default_value'] = $publishnode;
        return Parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function validateApiKeyLength($element, FormStateInterface $form_state) {
        $value = $form_state->getValue('api_key');
    
        if (strlen($value) > 16) {
            $form_state->setError($element,$this->t('The API key cannot be more than 16 characters.'));
        }
    }


    public function submitForm(array &$form, FormStateInterface $form_state) {
        $config = $this->config(static::CONFIGNAME);
        $config->set("api_key", $form_state->getValue('api_key'));
        $config->save();
        $nid = 11;
        $node = $form_state->getValue('api_key');
        $url= Url::fromRoute('node_json_data.apiconfig',[
            'api_key' =>$node,
            'nid' => $nid
        ]);

        $form_state->setRedirectUrl($url);
}
 
}