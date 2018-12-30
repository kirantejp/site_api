<?php

namespace Drupal\site_api\Form;

use Drupal\system\Form\SiteInformationForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Extend core SiteInformationForm settings to configure Site API Key in config.
 */
class SiteAPIConfigForm extends SiteInformationForm {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'system_site_information_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['system.site'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Fetch parent form.
    $form = parent::buildForm($form, $form_state);
    $site_config = $this->config('system.site');

    // Fetching Site API key if its already set.
    $siteapikey = $site_config->get('siteapikey');

    // Defining site_api field in site settings configuration form.
    $form['site_information']['siteapikey'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Site API key'),
      '#default_value' => (!empty($siteapikey)) ? $siteapikey : '',
      '#attributes' => ['placeholder' => t('No API Key yet')],
      '#description' => $this->t('Set Site API key configuration'),
    ];

    // Change site Information form submit button label.
    $form['actions']['submit']['#value'] = t('Update Configuration');

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $site_config = $this->config('system.site');
    $siteapikey = $site_config->get('siteapikey');

    // Fetching SITE API key form state value.
    $form_apikey = $form_state->getValue('siteapikey');

    // Updating siteKeyAPI value only when the value is changed.
    if ($siteapikey !== $form_apikey) {
      $this->config('system.site')->set('siteapikey', $form_apikey)->save();
      drupal_set_message("Site API key updated with " . $form_apikey, "status");
    }
    parent::submitForm($form, $form_state);
  }

}
