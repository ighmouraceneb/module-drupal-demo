<?php

namespace Drupal\demo\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;



/**
 * Message de commentaire.
 *
 * @Block(
 *  id = "block_demo",
 *  admin_label = @Translation("Another Hello World!")
 * )
 */

class DemoBlock extends BlockBase {

	public function build(){
		return  array(
			'#markup' => 'Hello '.$this->configuration['block_firstname'].' !',
	    );
	}

	public function blockForm($form, FormStateInterface $form_state) {
		$form['block_configuration'] =  array(
			'#type' => 'textfield',
			'#title' => $this->t('Firstname'),
			'#description' => $this->t('Enter your Firstname'),
			'#default_value' => $this->configuration['block_firstname'],
			 );

		return $form;
	}

	public function defaultConfiguration() {
		return array(
			'block_firstname' => 'world' , 
		);
	}

	public function blockSubmit($form, FormStateInterface $form_state) {
		$this->configuration['block_firstname'] = $form_state->getValue('block_configuration');
	}
}