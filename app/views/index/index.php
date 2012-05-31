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

			<br/>
			<?php echo Form::button('Submit','submit',array('class'=>'btn','id'=>'submit-record')); ?>

			<?php echo Form::close(); ?>
		</div>
	</div>
	<div class="span4">
		<h3>Recent Entries</h3>
		<span style="font-size:10px">Click on a name to load the record</span><br/>
		<br/>
		<?php foreach($records as $record): ?>

			<a href="#"><?php echo $record['full_name']; ?></a><br/>

		<?php endforeach; ?>
	</div>
</div>