<?php

	$needDB = true;
	include('inc/header.php');


	$queryStatement = "select name, id from items";
	$query = $conn->prepare($queryStatement);
	$query->execute();

?>
		<style type="text/css">
			.item_details{
				margin-left:10px;
			}
			.section{
				margin-left:10px;
			}
			.container{
				margin-left:20px;
			}
		</style>
		<script type="text/javascript">
			globalData = 0;
			$(document).ready(function(){
				$(".item").on("click", function(){
					var t = $(this);
					$.get("ajax.php?function=itemDetails&itemId=" + t.data("id"), function(data){
						data = JSON.parse(data);
						globalData = data;
						t.siblings(".item_details").children(".description").html(("<div class='description'>Description: " + data[0] +"</div>"));
						var html = "";
						for(var i = 0; i < data[1].length; i++)
						{
							html += "<div class='room'>Room: " + data[1][i].room.name + "</div>";
							html += "<div class='section'>Section: " + data[1][i].section.name + "</div>"
							html += "<div class='section'>Container: "+ data[1][i].container.type + " " + data[1][i].container.label + "</div>"
						}
						t.siblings(".item_details").children(".rooms").html(html);
					});
				});
			});
		</script>
	</head>
	<body>
		<?php 
			while($item = $query->fetch(PDO::FETCH_NUM)) {
				echo "<div>";
				echo "<div class='item' data-id='" . $item[1] . "'>" . $item[0] . "</div>";
				echo "<div class='item_details'>
					<div class='description'></div> 
					<div class='rooms'></div>
				</div>";
				echo "</div>";
			}
		?>
	</body>
</html>