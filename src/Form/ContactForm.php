<?php


namespace Drupal\demo\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;


class ContactForm extends FormBase {
	
	public function getFormId() {
		return 'contact_form';
	}

	public function buildForm(array $form, FormStateInterface $form_state) {
		
		$form = array();

		$form['content_title'] = [
			'#type' => 'textfield', 
			'#title' => $this->t('title'), 
			'#maxlenght' => 255, 
			'#default_value' => '', 
			'#required' => TRUE, 

		];

		$form['contact_email'] = [
			'#type' => 'email', 
			'#title' => $this->t('Email'), 
			'#maxlenght' => 255, 
			'#default_value' => '', 
			'#required' => TRUE, 
			'#ajax'  => [
			        'callback' => [$this, 'ajaxValidateEmail'],
			        'event' => 'change',
			      ],
			'#prefix' => '<span id="error-message-contact_email"></span>',

		];

		$form['contact_message'] = [
			'#type' => 'textarea', 
			'#title' => $this->t('Your message'), 
			'#description' => $this->t('Please add "Drupal" in this message'), 
			'#default_value' => '', 
			'#required' => TRUE, 

		];

		$form['submit'] = [
			'#type' => 'submit', 
			'#value' => t('Submit'), 		

		];


		return $form;
	}

	public function ajaxValidateEmail(array &$form, FormStateInterface $form_state) {
		
		$response = new AjaxResponse();
		
		$field = 'contact_email';
		$email_value = $form_state->getValue('contact_email');


		if (filter_var($email_value, FILTER_VALIDATE_EMAIL)) {
		      $css = ['border' => '2px solid green'];
		      $message = $this->t('OK!');
		    } else {
		      $css = ['border' => '2px solid red'];
		      $message = $this->t('%field must be email!', ['%field' => $form[$field]['#title']]);
		    }

		    $response->AddCommand(new CssCommand("[name=$field]", $css));
		    $response->AddCommand(new HtmlCommand('#error-message-' . $field, $message));

		    return $response;
	}

	public function submitForm(array &$form, FormStateInterface $form_state) {
		$email_value = $form_state->getValue('contact_email');

		$msg = 'Votre message a bien été envoyé. Une confirmation à été envoyée à '.$email_value;

		drupal_set_message($msg);
	}


	public function validateForm(array &$form, FormStateInterface $form_state) {
		$msg_value = $form_state->getValue('contact_message');

		if (!strpos($msg_value, 'Drupal')) {
			$form_state->setErrorByName('contact_message', $this->t('Please add "Drupal" in this message'));
		}
	}
}