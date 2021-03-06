<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<?php
	$min = '';
	
	if (Configure::read('debug') == 0) {
		$min = '.min';
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    
	<title><?php echo __('Admin panel');?>: <?php echo __($title_for_layout); ?></title>
    
	<?php
		echo $this->Html->meta('icon');
		
		$css = array(
			#bootstrap
			'/plugins/bootstrap/css/bootstrap' . $min,
			
			#font-awesome
			'/plugins/font-awesome/css/font-awesome' . $min
		);
		
		$js = array(
			#jQuery
			'/plugins/jQuery/js/jquery' . $min,
			
			#bootstrap
			'/plugins/bootstrap/js/bootstrap' . $min,
			
			#underscore
			'/plugins/underscore/underscore' . $min,
			
			#custom
			'objects' . $min,
			'application' . $min
		);
		
		echo $this->Html->css($css, false);
		echo $this->Html->script($js, false);
        
		if (Configure::read('debug') > 0) {
			echo $this->Html->less('app');
			echo $this->Html->script('less-1.3.0.min');
		} else {
			echo $this->Html->css('expenses.min', false);	
		}
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
	?>
</head>
<body>
	<?=$this->element('topnavbar' . DS . $var['Group']['name'], array(), array('plugin' => 'users'))?>
	
	<header id="header">
		<div class="container">
			<div class="row-fluid">
				<div class="span12">
				</div>
			</div>
		</div>
	</header>
	
	<section id="page">
		<div class="container">
			<div class="row-fluid">
				<div class="span12">
					<?php echo $this->Session->flash(); ?>
					<?php echo $this->fetch('content'); ?>
				</div>
			</div>
		</div>
	</section>
	
	<footer id="footer">
		<div class="container">
			<div class="row-fluid">
				<div class="span12">
					footer
				</div>
			</div>
		</div>
	</footer>
	
	<?php		
		echo $this->fetch('script');
		echo $this->fetch('customScript');
		
		echo $this->Js->writeBuffer();
		echo $this->element('google' . DS . 'analytics');
		
		echo $this->element('sql_dump');
	?>
</body>
</html>
