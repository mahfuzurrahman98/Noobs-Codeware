<?php if (!defined('noob')) {
    exit('<h1>Invalid page request</h1>');
} ?>

<form class="row p-2">
	<div class="mx-auto mb-3 h5 text-muted"><u><b>Advance Filter</b></u></div>
	<div class="col-12 form-group">
		<label><b><i class="fas fa-search"></i> Problem Title:</b></label>
		<input type="text" id="tt" class="form-control" id="X1" placeholder="Enter problem title" onkeyup="filterData()">
	</div>
	<div class="col-12 form-group">
		<label><b><i class="fas fa-search"></i> Problem Difficulty:</b></label>
		<select id="df" class="form-control" onchange="filterData()">
			<option value="%">All</option>
			<option value="Simple">Simple</option>
            <option value="Easy">Easy</option>
            <option value="Medium">Medium</option>
            <option value="Moderate">Moderate</option>
            <option value="Hard">Hard</option>
		</select>
	</div>
	<div class="col-12 form-group">
		<label><b><i class="fas fa-search"></i> Submission Status:</b></label>
		<select id="st" class="form-control" onchange="filterData()">
			<option selected value="All">All</option>
			<option value="Attempted">Attempted</option>
			<option value="Unattempted">Unattempted</option>
			<option value="Solved">Solved</option>
		</select>
	</div>
	<div class="col-12 form-group">
		<label><b><i class="fas fa-search"></i> Search by tags:</b></label>
		<select id="tg" class="form-control mul-select" multiple="true" style="width:100%;" onchange="filterData()">
            <?php include '../tags.php'; ?>
        </select>
	</div>
	<div class="col-12 form-group">
		<label><b><i class="fas fa-sort"></i> Sort by:</b></label>
		<select id="srt" class="form-control" onchange="filterData()">
			<option selected value="unsorted">Unsorted</option>
			<optgroup class="text-muted" label="Acceptance ratio">
				<option class="text-dark" value="acc_asc"><span class="ml-2 text-danger">ascending</span></option>
				<option class="text-dark" value="acc_desc">descending</option>
			</optgroup>
			<optgroup class="text-muted" label="No. of submission">
				<option class="text-dark" value="sub_asc">ascending</option>
				<option class="text-dark" value="sub_desc">descending</option>
			</optgroup>
		</select>
	</div>
</form>