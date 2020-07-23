<div class="jumbotron jumbotron-fluid text-center">
	<div class="container">
		<h1 class="display-3"><?php echo $data['title']; ?></h1>
		<p class="lead"><?php echo $data['description']; ?></p>
	</div>
</div>
<div class="to-do-list">
	<h4>General</h4>
	<ul>
		<li class="task-pr-h task-done">Update SQL fields if = 0 (not NULL)</li>
		<li class="task-pr-l">404 Page</li>
	</ul>
	<hr>
	<h4>Character</h4>
	<ul>
		<li class="task-done">Enc add up all items</li>
		<li class="task-done">Enc to ignore containers not "worn"</li>
		<li class="task-done">Conatiner's "enc" adds to character's enc value</li>
		<li class="task-done">Only "worn" containers add to enc</li>
		<li class="task-pr-m">Add defence</li>
		<li class="task-pr-m">Calculate Defence</li>
	</ul>
	<hr>
	<h4>Inventory</h4>
	<ul>
		<li class="task-pr-m">Inventory & Item buttons open in modal and/or Ajax</li>
		<li class="task-pr-l">Add money</li>
		<ul class="task-pr-l">
			<li>Customisable?</li>
			<li>tables needed</li>
			<ul>
				<li>Money System (Terrinoth / SWRGP / Custom)</li>
				<li>Money types (cp, sp, gp, credits, dollars, etc. | detail_id)</li>
				<li>Money details (system_id | char_id)</li>
			</ul>
		</ul>
		<li class="task-pr-l">Re-order containers (arrows)</li>
		<li class="task-pr-l">Container count field</li>
	</ul>
	<hr>
	<h4>Container</h4>
	<ul>
		<li class="task-pr-h task-done">Edit Container</li>
		<li class="task-pr-h task-done">Delete Container</li>
		<li class="task-pr-m">"Capacity" limits item entries in conatiner</li>
		<li class="task-pr-m">"Capacity" takes item__qty into account</li>
		<li class="task-pr-m task-done">"Worn" attribute</li>
		<li class="task-pr-l">Custom "locations"</li>
		<li class="task-pr-h">All fields on creation form</li>
		<li class="task-pr-h">List order</li>
		<ul>
			<li class="task-pr-h task-done">Buttons</li>
			<li class="task-pr-h task-done">update functionality</li>
			<li class="task-pr-h task-done">List containers by Order</li>
			<li class="task-pr-h task-active">Update all containers on Delete</li>
			<li class="task-pr-h">Ajax update order</li>
		</ul>
	</ul>
	<hr>
	<h4>Items</h4>
	<ul>
		<li class="task-pr-h task-done">Add Item Damage field</li>
		<li class="task-pr-h task-done">Add all fields to View</li>
		<li class="task-pr-h task-done">Add edit button to view page</li>
		<li class="task-pr-h task-done">Ajax attributes on Type change</li>
		<li class="task-pr-h task-stuck">Make dropdowns populate on edit page</li>
		<li class="task-pr-h task-done">Hard Point</li>
		<li  class="task-pr-h task-done">All fields on creation page</li>
		<li class="task-pr-h task-done">'Incidental' items attr</li>
		<ul class="task-pr-h task-done">
			<li class="task-done">Incidental field</li>
			<li class="task-done">packed field</li>
			<li class="task-done">Checkboxes on item create/edit forms</li>
			<li class="task-done">'Organised?' checkbox live appear/dissapear (JS)</li>
			<li class="task-done">Well stored => 1 item == 0.1 enc</li>
			<li class="task-done">Loose items => 1 item == 0.2 enc</li>
			<li class="task-done">Add to Item view</li>
		</ul>
		<li class="task-pr-l">"Location" dropdown field based off container's "locations"</li>
		<li class="task-pr-l">Item image</li>
		<li class="task-pr-m">Ad 'Defence' to weapons</li>
		<li class="task-pr-m">List order on Items</li>
	</ul>
</div>
<div id="footer" style="height: 200px;">

</div>
