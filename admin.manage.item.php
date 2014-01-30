<div id="itemManage">
	<div id="items">
		<input name="nameOfItem" type="text" placeholder="Item Name">
		<input name="description" type="text" placeholder="Item description">
		<input name="serial" type="text" placeholder="serial number">
		<button onclick="createItem();">Create Item</button>
		<select name="itemsList">
			<?php
				$itemInfo = listOptions("Select name,id from items");
				foreach($itemInfo as $item) {
					echo "<option data-id='" . $item[1] . "' value='" . $item[0] .  "'>" . $item[0] . "</option>";
				}
			?>
		</select>
		<button onclick="deleteItem();">Delete Item</button>
		<div id="currentItem">
			<span id="currentItemName"></span>
			<span id="currentItemDescription"></span>
			<input type="number">
		</div>
	</div>
	<div id="locations">
		<select name="rooms">
			<?php 
				$rooms = listOptions("Select id,number from rooms");
				foreach($rooms as $room) {
					echo "<option value='" . $room[0] .  "'>" . $room[1] . "</option>";
				}
			 ?>
		</select>
		<select name="section">

		</select>
		<select name="containers">

		</select>
		<div id="currentContainer">

		</div>
		<div id="deleteBin">

		</div>
	</div>
	<div>
		<form action="" method="post" enctype="multipart/form-data" id="uploadImage">
			<input type="file" name="csv" id="image">
			<input type="submit" name="upload" id="upload" value="Upload">
		</form>
	</div>
</div>
