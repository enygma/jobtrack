<div class="row">
	<div class="span8">
		<div id="record-form">
			<?php echo Form::open(array('action'=>'/','class'=>'well')); ?>

			<label for="name">Full Name</label>
			<?php echo Form::input('full_name'); ?>

			<label for="location">Location</label>
			<?php echo Form::input('location'); ?>

			<label for="tags">Tags</label>
			<?php echo Form::input('tags'); ?>
			<span class="help-block">Tags are comma-seperated</span>

			<?php echo Form::hidden('record_id'); ?>

			<br/>
			<?php echo Form::button('Submit','submit',array('class'=>'btn','id'=>'submit-record')); ?>

			<?php echo Form::close(); ?>
		</div>
	</div>
	<div class="span4">
		<h3>Recent Entries</h3>
		<span style="font-size:10px">Click on a name to load the record</span><br/>
		<br/>
		<div id="latest-records"></div>
	</div>
</div>