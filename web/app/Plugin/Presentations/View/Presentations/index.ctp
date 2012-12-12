<div class="span6">
	<div id="carousel" class="carousel slide well">
		<!-- Carousel items -->
		<div class="carousel-inner">
			<div class="active item">
				<?=$this->Html->image('presentations/register.jpg')?>
				
				<h5 class="no-margin-bottom"><?=__('Make an account. It&rsquo;s FREE')?></h5>
			</div>
			<div class="item">
				<?=$this->Html->image('presentations/login.jpg')?>
				
				<h5 class="no-margin-bottom"><?=__('Login and manage your expenses')?></h5>
			</div>
			<div class="item">
				<?=$this->Html->image('presentations/recover-password.jpg')?>
				
				<h5 class="no-margin-bottom"><?=__('Forgot your password? You can recover with a single click.')?></h5>
			</div>
			<div class="item">
				<?=$this->Html->image('presentations/payments.jpg')?>
				
				<h5 class="no-margin-bottom"><?=__('Group your expenses into categories for easy management.')?></h5>
			</div>
			<div class="item">
				<?=$this->Html->image('presentations/chart.jpg')?>
				
				<h5 class="no-margin-bottom"><?=__('Analyze your expenses and incomes with beautiful charts.')?></h5>
			</div>
		</div>
		
		<!-- Carousel nav -->
		<a class="carousel-control left" href="#carousel" data-slide="prev">&lsaquo;</a>
		<a class="carousel-control right" href="#carousel" data-slide="next">&rsaquo;</a>
	</div>
</div>

<div class="span6">
	<h2 align="center"><?=__('The Easiest way to keep track of your expenses')?></h2>
	<h3 align="center"><?=__('Great for Business or Personal Use')?></h3>
	
	<div class="row-fluid">
		<div class="span6 alert alert-info">
			<h5><i class="icon-tags"></i> <?=__('Organize')?></h5>
			<?=__('Organize your expenses by categories and analyze your expenses.')?>
		</div>
		
		<div class="span6 alert alert-info">
			<h5><i class="icon-print"></i> <?=__('Export and Print')?></h5>
			<?=__('Print beautiful expense reports that include expense summaries, details, and receipts.')?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6 alert">
			<h5><i class="icon-bar-chart"></i> <?=__('Analize')?></h5>
			<?=__('Analyze your expenses and income with beautiful charts.')?>
		</div>
		
		<div class="span6 alert">
			<h5><i class="icon-flag"></i> <?=__('International Support')?></h5>
			<?=__('Create an account and select the language you want.')?>
		</div>
	</div>
</div>