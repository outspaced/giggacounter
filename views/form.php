<?= $header ?>
<form action="/giggacounter" method="post" class="form-horizontal" role="form" id="giggacounter-form">

	<div class="form-group">
		<label for="username" class="col-sm-2 control-label">Username</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="username" name="username" placeholder="Enter your username">
		</div>
	</div>
	
	<div class="form-group">
	 	<label for="year" class="col-sm-2 control-label">Provider</label>
		<div class="col-sm-10">
			<? foreach ($apis as $key => $api_name): ?>
				<label class="btn btn-default">
					<input type="radio" name="api" id="api_<?= $key ?>" value="<?= $key ?>">
					<?= $api_name ?>
				</label>
			<? endforeach ?>
		</div>
	</div>				

	<div class="form-group">
	 	<label for="year" class="col-sm-2 control-label">Show counts for</label>
		<div class="col-sm-10">
			<? foreach ($counters as $key => $name): ?>
				<label class="btn btn-default">
					<input type="radio" name="counter" id="count_<?= $key ?>" value="<?= $key ?>">
					<?= $name ?>
				</label>
			<? endforeach ?>
		</div>
	</div>

	<? foreach ($sub_counters as $counter => $sub_counter): ?>
		<div class="form-group" id="form-group-<?= $counter ?>">
		 	<label class="col-sm-2 control-label"><?= arr::get($counters, $counter) ?></label>
			<div class="col-sm-10">
				<? foreach ($sub_counter as $key => $name): ?>
					<label class="btn btn-default">
						<input type="radio" name="sub_counter" id="<?= $counter ?>_<?= $key ?>" value="<?= $key ?>">
						<?= $name ?>
					</label>
				<? endforeach ?>
			</div>
		</div>
	<? endforeach ?>	
	
	<input type="submit" class="btn btn-default" name="Submit"/>
</form>
<?= $footer ?>