<?php
	session_start();
	//Code to handle session_start
	
	include('./inc/dbconnect.php');


	$queryStatement = "select name,id from items";
	$query = $conn->prepare($queryStatement);
	$query->execute();

?>
<!Doctype html>
<html>
	<head>
		<title>
			Equipments Page
		</title>	
		<style type="text/css">
@import url(http://fonts.googleapis.com/css?family=Lora);
#container{
    width:960px;
    border:1px solid black;
    font:28px Lora;
    margin:auto;
    text-align:center;
}

.equipment{
    border:1px solid red;
    width:350px;
}
.item_info{
		    border:1px solid black;
		    display:inline-block;
		    margin-left:2px;
		    width:500px;
		    left:375px;
		    position:relative;
}

		.closeBtn{
		    position:absolute;
		    top:0px;
		    right:0px;
		    color:lightgrey;
		    font-size:18px;
		    z-index: 2;
		}
		.closeBtn:hover{
		    color:grey;
		}

		.description{
		    display:block;
		}

		.locationsTop{
		    display:block;
		    text-align:center;
		    width:350px;
		    margin:auto;
		}

		.locationInfo{
		    display:block;
		}
		</style>
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.js"></script>
		<script type="text/javascript">
			function makeElement(element,innerHTML,className,id){
				theElement = document.createElement(element);
				theElement.innerHTML = innerHTML;
				if(className){
					theElement.setAttribute("class",className);
				}
				if(id){
					theElement.setAttribute("id",id);
				}
				return theElement;
			}

			function toggleInfo(itemId,element){
				if($(element).find(".item_info").length === 0 ){
					var url = "ajax.php?function=itemDetails&itemId=" + itemId;
					$.get(url).done(function(data){

						itemData = JSON.parse(data);
						//Makes container for information
						var container = makeElement('div',"",'item_info');
						
						//makes button to toggle close
						var closeBtn = makeElement('span','X','closeBtn');
						closeBtn.setAttribute('onclick','close(' + itemId + ');');
						container.appendChild(closeBtn);

						//Description of the item
						var description = makeElement("span","Description:",'description');
						description.innerHTML += itemData[0];
						if(itemData[0] == ""){
							description.innerHTML += "No Description Avaliable";
						}
						container.appendChild(description);
						

						var locations = makeElement('span','Quantity x Location','locationsTop');
						for(var i = 0; i < itemData[1].length; i++){
							var currData = itemData[1][i];
							var str = currData['quantity'] + ' X ' + currData['room']['room_number']  + ' in section ' + currData['room']['section_name'] + ' in ' + currData['section']['container_type']  + ' with label ' + currData['section']['container_label'];
							locations.appendChild(makeElement('span',str,'locationInfo'));
						}
						container.appendChild(locations);
						element.appendChild(container);
					});
				}
			}
			
			/*function close(parentNumber){
				$($(".equipment")[parentNumber - 1]).hide();
			}*/
		</script>
	</head>
	<body>
		<div id="container">
		<?php 
			while($item = $query->fetch(PDO::FETCH_ASSOC)) {
				echo "<div class='equipment' onclick='toggleInfo(".$item['id'] .",this)'>" . $item['name'] . "</div>";
			}
		?>
		</div>
	</body>
</html>