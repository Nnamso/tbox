<div class="form-group">
	<div class="row">
		<label class="col-sm-3 control-label">Cart number</label>
		<div class="col-sm-8">
			<input class="form-control input-sm validate <?php if(isset($checked) && $checked != '') echo 'required'; ?>" type="text" name="card_num" placeholder="Cart number">
		</div>
	</div>
</div>

<div class="form-group">
	<div class="row">
		<label class="col-sm-3 control-label">Exp date</label>
		<div class="col-sm-4">
			<input class="form-control input-sm <?php if(isset($checked) && $checked != '') echo 'required'; ?>" type="text" name="exp_date" placeholder="Exp date">
			<div class="help-block">Eg: 0815</div>
		</div>
	</div>
</div>