<h2><?php __('Login'); ?></h2>

<?php echo $this->Form->create() ?>
<?php 
	echo $this->Form->input('username');
	echo $this->Form->input('password');
	echo $this->Form->end(__('Enter the site', true));
?>