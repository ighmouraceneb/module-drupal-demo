<?php

namespace Drupal\demo\Controller;

use Drupal\Core\Controller\ControllerBase;

class DemoController extends ControllerBase {

	public function description () {
		$build = array(
			'#type' =>'markup', 
			'#markup' =>t('Hello Word, this is my first routing !'), 

		);

		return $build;
	}
}