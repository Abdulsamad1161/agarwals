<?php  
//echo "<pre>";print_r($ticket_id);echo "</pre>";
$seatsWithV = array();
$seatsWithoutV = array();

foreach ($ticket_id as $seat) 
{
    if (strpos($seat['seat_number'], 'V') === 0 || strpos($seat['seat_number'], 'G') === 0 || strpos($seat['seat_number'], 'S') === 0) 
	{
        $seatsWithV[] = $seat['seat_number'];
    }
}

foreach ($ticket_id as $seat) 
{
    if ($seat['seat_booking_numbers'] != '' && $seat['seat_booking_numbers'] != NULL) 
	{
        $seatsWithoutV[] = $seat['seat_booking_numbers'];
    }
}

$seatNumbers = array();
foreach ($ticket_id as $item) 
{
    $seatArray = json_decode($item['seat_number'], true);
    if (is_array($seatArray)) 
	{
        foreach ($seatArray as $seat) 
		{
            $seatNumbers[] = $seat;
        }
    }
}
//$ticket_id = $seatNumbers;

//echo "<pre>";print_r($jsArray);echo"</pre>";die;
?>

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-12 top_body_ticket">
			<div class="right">
                    <a href="<?= adminUrl('ticket-manager'); ?>" class="btn btn-danger btn-add-new">
                        <i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;<?= trans('back'); ?>
                    </a>
                </div>
			<form action="<?= base_url('TicketController/updateHoldTickets'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
				<p class="top_body_p"><?= $tickets->event_name?>,&nbsp;&nbsp;<?= $tickets->event_date?></p>
				<div class="col-md-8">
					<label><?= trans('selected_tickets'); ?>:</label>
					<input type="text" name="seats[]" class="form-control" value="" id="seat-data" placeholder="Select Tickets">
					<input type="hidden" name="eventID" class="form-control" value="<?= $tickets->id?>" placeholder="Select Tickets">
				</div>
				
				<div class="col-md-2">
					<label><?= trans('visible'); ?>:</label>
					<?php 
						$visible = ($tickets->visible == 1) ? 1 : 0;
					?>
					<input type="checkbox" name="visibility"  value="1" <?php echo ($visible == 1) ? 'checked' : ''; ?>>
				</div>
				
				<div class="col-md-2">
					<label>Update Hold Ticket:</label>
					<input type="checkbox" id="updateHoldTicket" name="updateHoldTicket" value="1" class="any_one_check">
					<label>Release Hold Ticket:</label>
					<input type="checkbox" id="releaseHoldTicket" name="releaseHoldTicket" value="1">
				</div>
				<button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?> </button>
			</form>
		</div>
	</div>
</div>
<br>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12 top_body_ticket">
		<label><?= trans('gold_tickets'); ?>:</label>&nbsp;&nbsp;<input type="checkbox" id="gold"  class="any_one_check">&nbsp;&nbsp;
		<label><?= trans('silver_tickets'); ?>:</label>&nbsp;&nbsp;<input type="checkbox" id="silver"  class="any_one_check">
		<div class="sections-container movie-seat-container" id="seating-container" style="text-align : center;">
			<ul class="showcase">
				<li>
				  <div class="seats sponsors">H</div>
				  <small><?= trans('hold_ticket'); ?></small>
				</li>
				
				<li>
				  <div class="seats gold">G</div>
				  <small><?= trans('gold_tickets'); ?></small>
				</li>
				
				<li>
				  <div class="seats silver">S</div>
				  <small><?= trans('silver_tickets'); ?></small>
				</li>
				
				<li>
				  <div class="seats occupied"></div>
				  <small><?= trans('occupied_ticket'); ?></small>
				</li>    
			</ul>
		<div class="screen"></div>
		<div id="update-message-container">
			<div id="update-message"></div>
		</div>


                    <!-- Sections will be added dynamically here -->
         </div>
    </div>

  </div>
</div>
<style>
.success-message {
    background-color: #66bb6a; 
    color: #fff; 
    padding: 10px; 
    border-radius: 5px; 
}

.error-message {
    background-color: #ef5350; 
    color: #fff; 
    padding: 10px; 
    border-radius: 5px; 
}

.success-message, .error-message {
    display: inline-block; 
    padding: 10px; 
    border-radius: 5px; 
    margin-right: 10px; 
}

#update-message-container {
    margin-top: 10px; 
    white-space: nowrap; 
    overflow: hidden; 
}


.top_body_ticket
{
	background: white;
	border: 2px solid #d1274b;
	border-radius: 10px;
	padding: 8px;
	color: black;
}

.top_body_p
{
	text-align: center;
	color: black !important;
	font-weight : bold;
}
.title_head
  {
	text-align: center;
	font-weight: bold;
	color: #d1274b;
  }
.line-seperator
{
	height: 1px;
	width: 100%;
	background-color: #999;
	margin: 1.5rem 0;
}
		  
@media (min-width: 1200px)
.containers {
  max-width: 1500px;
}

        .seating-map {
            font-family: monospace;
            white-space: pre-wrap;
        }

        .seat {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 1px solid #555;
            margin: 2px;
            background-color: #ccc;
            text-align: center;
            line-height: 20px;
        }

        /* Additional CSS for displaying sections in a row */
        .sections-container {
            overflow-x: auto;
            overflow-y: auto;
            white-space: nowrap;
        }

        .section-column {
            display: inline-block;
            vertical-align: top;
            //width: calc(33.33% - 20px); /* Adjust the width as needed */
            margin-right: 20px;
        }
    </style>

<?php $jsArray = json_encode($seats, JSON_NUMERIC_CHECK);
//echo "<pre>";print_r($jsArray);echo"</pre>";die;
?>

<style>

.screen
{ 
	height: 25px;
	margin: 15px 0;
	transform: rotateX(-65deg);
	box-shadow: 0 3px 10px rgba(255,255,255,0.7);
	border-top: 100px solid #d7d7d8;
	border-left: 27px solid transparent;
	border-right: 27px solid transparent;
}

.seat {
  width: 22px; /* Set the width to 20px */
  height: 22px; /* Set the height to 20px */
  background-color: white;
  cursor: pointer;
  border-radius : 10px 10px 0px 0px;
}

.seats {
  width: 22px; /* Set the width to 20px */
  height: 22px; /* Set the height to 20px */
  background-color: white;
  border : 1px solid black;
  cursor: pointer;
  border-radius : 10px 10px 0px 0px;
  cursor: default;
}

.selected, .selected_showcase 
{
  background-color: #43ff43;
  border : 1px solid #43ff43;
  cursor: default;
}

.occupied {
  background-color: #ff436b;
  border : 1px solid #ff436b;
}

.seats .occupied {
  background-color: #ff436b;
  cursor: default;
  border: 1px solid #ff436b !important;
}

.showcase {
  display: flex;
  justify-content: center;
  list-style-type: none;
}

.showcase li {
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 10px;
}

.showcase li small {
  margin-left: 2px;
}

.booking-card {
  border: 2px solid #d1274b;
  padding: 10px;
  margin: 20px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  
}

.btn-book
{
	border-radius: 20px;
	color: white;
	font-size: 20px;
	border: 1px solid #d1274b;
}

.booking-card h4
{
	font-weight: bold;
	text-align: center;
}

.total_ticket_price
{
	font-weight: bold;
	font-size: 18px;
	color: #00af00;
}

.ticket_bold_text
{
	font-weight: bold;
	font-size: 16px;
}

.make_red_color
{
	font-weight: bold;
	font-size: 18px;
	color : #d1274b;
}

.text_center_btn
{
	text-align : center;
}

.card-text i
{
	color : #d1274b;
}

.seat.occupied 
{
  background-color: red;
  color: white; 
  border : 1px solid red;
}

.seat.sponsors {
  /* Add your custom styles for VIP seats here */
	background-color: #c46eff;
	color: black;
	font-weight: bold;
	border : 1px solid #c46eff;
}

.seats.sponsors 
{
	background-color: #c46eff;
	color: black;
	font-weight: bold;
	border: 1px solid #c46eff;
	cursor: default;
	text-align: center;
}

.text-align-below-section
{
	text-align: center;
	color: #3c49ff;
	font-weight: bold;
}

.gold
{
	background: gold;
	font-weight: bold;
	border: 1px solid gold !important;
}

.seats.gold
{
	background: gold;
	color: black;
	font-weight: bold;
	border: 1px solid gold !important;
	cursor: default;
	text-align: center;
}

.silver
{
	background: silver;
	font-weight: bold;
	text-align : center;
	border: 1px solid silver;
}

.seats .silver
{
	background: silver;
	color: black;
	font-weight: bold;
	border: 1px solid silver !important;
	cursor: default;
	text-align: center;
}
</style>


<script src="<?= base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>
<script>
$(document).ready(function() 
{
    $("#book-now-btn").click(function() 
	{
     // bookSeats();
    });
});
</script>

<script>
function generateSeatingMap(sectionsConfig, occupiedSeats) 
{
  let seatingContainer = $("#seating-container");
  let totalTables = 0; // Variable to keep track of the total number of tables

  sectionsConfig.forEach((section, sectionIndex) => {
    let sectionDiv = $("<div>").addClass("section-column");
    sectionDiv.append($(`<div class="seating-map" id="section${sectionIndex + 1}"><h3>${section.sectionName}</h3></div>`));
    seatingContainer.append(sectionDiv);
	
    let seatingMap = "";
    let totalSeatsInSection = 0; // Variable to count total seats in the section
    for (let table = 1; table <= section.numTables; table++) {
      let tableNumber = (totalTables + table).toString().padStart(2, '0'); // Use totalTables to continue table numbering
	  let section_no = section.sectionNo;
	  let event_id_table = section.eventID;
	  let prefix_section = 'S';
	  let tableNameFindValue = prefix_section + section_no + event_id_table+ tableNumber;

	  getTableNamefromdefine(tableNameFindValue);
	  
	  let tableNameWithSpan = `<span class="table-name edit-icon" id= "${tableNameFindValue}"></span>&nbsp;`;
	   
      let seats = "";
      for (let seat = 1; seat <= section.numSeatsPerTable; seat++) {
        let seatId = `s${sectionIndex + 1}t${tableNumber}${seat}`;
        let seatClass = occupiedSeats.includes(seatId) ? "seat occupied" : "seat";
        if (!occupiedSeats.includes(seatId)) 
		{
          if (isVipSeat(sectionIndex, tableNumber, seat)) {
            seatClass += " sponsors";
            let seatId = `Vs${sectionIndex + 1}t${tableNumber}${seat}`;
            seats += `<div class="${seatClass}" data-id="${seatId}">H</div>`;
          }
		  else if(isGoldSeat(sectionIndex, tableNumber, seat))
		  {
			if(isGoldSeatOccupied(sectionIndex, tableNumber, seat))
			{
				seatClass += " occupied";
				let seatId = `Gs${sectionIndex + 1}t${tableNumber}${seat}`;
				seats += `<div class="${seatClass}" data-id="${seatId}">${seat}</div>`;
			}
			else
			{
				seatClass += " gold";
				let seatId = `Gs${sectionIndex + 1}t${tableNumber}${seat}`;
				seats += `<div class="${seatClass}" data-id="${seatId}">${seat}</div>`;
				totalSeatsInSection++; // Increment the totalSeats count
			}
		  }
		  else if(isSilverSeat(sectionIndex, tableNumber, seat))
		  {
			if(isSilverSeatOccupied(sectionIndex, tableNumber, seat))
			{
				seatClass += " occupied";
				let seatId = `Ss${sectionIndex + 1}t${tableNumber}${seat}`;
				seats += `<div class="${seatClass}" data-id="${seatId}">${seat}</div>`;
			}
			else
			{
				seatClass += " silver";
				let seatId = `Ss${sectionIndex + 1}t${tableNumber}${seat}`;
				seats += `<div class="${seatClass}" data-id="${seatId}">${seat}</div>`; 
				totalSeatsInSection++; // Increment the totalSeats count
			}
		  }
		  else {
            seats += `<div class="${seatClass}" data-id="${seatId}">${seat}</div>`;
            totalSeatsInSection++; // Increment the totalSeats count
          }
        }
		else
		{
			seats += `<div class="${seatClass}" data-id="${seatId}">${seat}</div>`;
		}
      }
      seatingMap += tableNameWithSpan + seats + "<br>";
    }
    $(`#section${sectionIndex + 1}`).append(seatingMap);

    // Display the total number of seats below the section
    $(`#section${sectionIndex + 1}`).append(`<p class="text-align-below-section">Total Seats Available: ${totalSeatsInSection}</p>`);

    totalTables += section.numTables; // Increment totalTables for the next section
  });
}
  
const vipSeatNumbers = <?= json_encode($seatsWithV); ?>;

const occupiedSeatNumbers = <?= json_encode($seatsWithoutV); ?>;

  // Function to check if a seat is a VIP seat
function isVipSeat(sectionIndex, tableNumber, seat) 
{
    // Create the seatId using the sectionIndex, tableNumber, and seat
	const seatId = `Vs${sectionIndex + 1}t${tableNumber}${seat}`;

	// Check if the seatId is present in the array of VIP seat numbers
	return vipSeatNumbers.includes(seatId);
}

  // Function to check if a seat is a Gold seat
function isGoldSeat(sectionIndex, tableNumber, seat) 
{
    // Create the seatId using the sectionIndex, tableNumber, and seat
	const seatId = `Gs${sectionIndex + 1}t${tableNumber}${seat}`;

	// Check if the seatId is present in the array of VIP seat numbers
	return vipSeatNumbers.includes(seatId);
} 

// Function to check if a seat is a occupied
function isGoldSeatOccupied(sectionIndex, tableNumber, seat) 
{
    // Create the seatId using the sectionIndex, tableNumber, and seat
	const seatId = `Gs${sectionIndex + 1}t${tableNumber}${seat}`;

	// Check if the seatId is present in the array of VIP seat numbers
	return occupiedSeatNumbers.includes(seatId);
} 

 // Function to check if a seat is a Silver seat
function isSilverSeat(sectionIndex, tableNumber, seat) 
{
    // Create the seatId using the sectionIndex, tableNumber, and seat
	const seatId = `Ss${sectionIndex + 1}t${tableNumber}${seat}`;

	// Check if the seatId is present in the array of VIP seat numbers
	return vipSeatNumbers.includes(seatId);
}

 // Function to check if a seat is a occupied
function isSilverSeatOccupied(sectionIndex, tableNumber, seat) 
{
    //Create the seatId using the sectionIndex, tableNumber, and seat
	const seatId = `Ss${sectionIndex + 1}t${tableNumber}${seat}`;

	// Check if the seatId is present in the array of VIP seat numbers
	return occupiedSeatNumbers.includes(seatId);
}

const seatingData = 
{
	selectedSeats: []
};

function toggleSeatColor(seat)  // on click of seat this function will be called
{
	// Check if the seat is already occupied
	if ($(seat).hasClass("occupied")) 
	{
		return; // Don't do anything if the seat is already occupied
	}

	const seatId = $(seat).attr("data-id");

	const isSeatVIP = vipSeatNumbers.includes(seatId);
	
	const goldTicket = document.getElementById("gold");
	const silverTicket = document.getElementById("silver");
	const updateHoldTicket = document.getElementById("updateHoldTicket");
	const releaseHoldTicket = document.getElementById("releaseHoldTicket");
	
	if (goldTicket.checked) 
	{
		if ($(seat).hasClass("occupied") || $(seat).hasClass("sponsors") || $(seat).hasClass("silver")) 
		{
			return; // Don't do anything if the seat is already occupied
		}
		
		// Check if the seat already has the "sponsors" class
		if ($(seat).hasClass("gold")) 
		{
			if (isSeatVIP) 
			{
			  return;  //if it is a vip seat then return 
			} 
			else 
			{ 
				// if it is  not vip seat then you can modify
				const index = seatingData.selectedSeats.indexOf(seat);
				if (index !== -1) 
				{
					seatingData.selectedSeats.splice(index, 1);
					$(seat).removeClass("gold");
					
					var dataId = seat.getAttribute("data-id");
					const lastNumber = parseInt(dataId.slice(-1));
					$(seat).text(lastNumber);
					
					if (dataId.includes("V") || dataId.includes("S")) 
					{
						return;
					}
					
					if (dataId.includes("G")) 
					{
						if (dataId.startsWith("G")) 
						{
						  dataId = dataId.substring(1);
						}
						seat.setAttribute("data-id", `${dataId}`);
					}
				}
			}
		}
		else 
		{
			// If the seat doesn't have the "sponsors" class, add it to the selectedSeats array
			seatingData.selectedSeats.push(seat);
			
			// Toggle the "sponsors" class and update the content of each selected seat div
			$(seat).toggleClass("gold");
			$(seat).text("G");

			seatingData.selectedSeats.forEach((selectedSeat) => 
			{
				const dataId = selectedSeat.getAttribute("data-id");
				
				if (dataId.includes("S") || dataId.includes("V")) 
				{
					return;
				}
				
				// Check if the seat is already marked as VIP (contains "V") before adding it
				if (!dataId.includes("G")) 
				{
				  selectedSeat.setAttribute("data-id", `G${dataId}`);
				  selectedSeat.textContent = `${selectedSeat.textContent}`;
				}
			});
		}		
	}
	else if(silverTicket.checked)
	{
		if ($(seat).hasClass("occupied") || $(seat).hasClass("sponsors") || $(seat).hasClass("gold")) 
		{
			return; // Don't do anything if the seat is already occupied
		}
		
		// Check if the seat already has the "sponsors" class
		if ($(seat).hasClass("silver")) 
		{
			if (isSeatVIP) 
			{
			  return;  //if it is a vip seat then return 
			} 
			else 
			{ 
				// if it is  not vip seat then you can modify
				const index = seatingData.selectedSeats.indexOf(seat);
				if (index !== -1) 
				{
					seatingData.selectedSeats.splice(index, 1);
					$(seat).removeClass("silver");
					
					var dataId = seat.getAttribute("data-id");
					const lastNumber = parseInt(dataId.slice(-1));
					$(seat).text(lastNumber);
					
					if (dataId.includes("G") || dataId.includes("V")) 
					{
						return;
					}
					
					if (dataId.includes("S")) 
					{
						if (dataId.startsWith("S")) 
						{
						  dataId = dataId.substring(1);
						}
						seat.setAttribute("data-id", `${dataId}`);
					}
				}
			}
		}
		else 
		{
			// If the seat doesn't have the "sponsors" class, add it to the selectedSeats array
			seatingData.selectedSeats.push(seat);
			// Toggle the "sponsors" class and update the content of each selected seat div
			$(seat).toggleClass("silver");
			$(seat).text("S");

			seatingData.selectedSeats.forEach((selectedSeat) => 
			{
				const dataId = selectedSeat.getAttribute("data-id");
				
				// Check if the seat is already marked as VIP (contains "V") before adding it
				if (dataId.includes("G") || dataId.includes("V")) 
				{
					return;
				}
				
				if (!dataId.includes("S")) 
				{
				  selectedSeat.setAttribute("data-id", `S${dataId}`);
				  selectedSeat.textContent = `${selectedSeat.textContent}`;
				}
			});
		}
	}
	else
	{
		if (updateHoldTicket.checked) 
		{
			if ($(seat).hasClass("occupied")) 
			{
				return; // Don't do anything if the seat is already occupied
			}
		}
		else
		{
			if ($(seat).hasClass("occupied") || $(seat).hasClass("gold") || $(seat).hasClass("silver")) 
			{
				return; // Don't do anything if the seat is already occupied
			}
		}
		// Check if the seat already has the "sponsors" class
		if ($(seat).hasClass("sponsors")) 
		{
			if (releaseHoldTicket.checked) 
			{
					
				$(seat).removeClass("sponsors");
				
				var dataId = seat.getAttribute("data-id");
				const lastNumber = parseInt(dataId.slice(-1));
				$(seat).text(lastNumber);
				
				if (dataId.includes("G") || dataId.includes("S")) 
				{
					return;
				}
				
				if (dataId.includes("V")) 
				{
					if (dataId.startsWith("V")) 
					{
					  dataId = dataId.substring(1);
					}
					seat.setAttribute("data-id", `${dataId}`);
				}		
			}
			else
			{
				
					// if it is  not vip seat then you can modify
					const index = seatingData.selectedSeats.indexOf(seat);
					if (index !== -1) 
					{
						seatingData.selectedSeats.splice(index, 1);
						$(seat).removeClass("sponsors");
						
						var dataId = seat.getAttribute("data-id");
						const lastNumber = parseInt(dataId.slice(-1));
						$(seat).text(lastNumber);
						
						if (dataId.includes("G") || dataId.includes("S")) 
						{
							return;
						}
						
						if (dataId.includes("V")) 
						{
							if (dataId.startsWith("V")) 
							{
							  dataId = dataId.substring(1);
							}
							seat.setAttribute("data-id", `${dataId}`);
						}					
					}
			}
		}
		else 
		{
			
			if (updateHoldTicket.checked) 
			{
				let dataId = seat.getAttribute("data-id");
				if (dataId.startsWith("G")) 
				{
					dataId = dataId.substring(1);
				}
				else if (dataId.startsWith("S")) 
				{
					dataId = dataId.substring(1);
				}
				
				seatingData.selectedSeats.push(seat);
				
				// Toggle the "sponsors" class and update the content of each selected seat div
				$(seat).toggleClass("sponsors");
				$(seat).text("H");

				// Check if the seat is already marked as VIP (contains "V") before adding it
					if (!dataId.includes("V")) 
					{
					  seat.setAttribute("data-id", `V${dataId}`);
					}
			}
			else
			{
				// If the seat doesn't have the "sponsors" class, add it to the selectedSeats array
				seatingData.selectedSeats.push(seat);
				
				// Toggle the "sponsors" class and update the content of each selected seat div
				$(seat).toggleClass("sponsors");
				$(seat).text("H");

				seatingData.selectedSeats.forEach((selectedSeat) => 
				{
					const dataId = selectedSeat.getAttribute("data-id");
					if (dataId.includes("G") || dataId.includes("S")) 
					{
						return;
					}
					
					// Check if the seat is already marked as VIP (contains "V") before adding it
					if (!dataId.includes("V")) 
					{
					  selectedSeat.setAttribute("data-id", `V${dataId}`);
					  selectedSeat.textContent = `${selectedSeat.textContent}`;
					}
				});
			}
		}		
	}
	const seatData = seatingData.selectedSeats.map((seat) => seat.getAttribute("data-id"));

	const seatDataInput = document.getElementById("seat-data");
	seatDataInput.value = JSON.stringify(seatData); 
}

  const arrayData = <?php echo $jsArray; ?>;

  const sectionsConfig = arrayData.map((section) => {
    return {
	  sectionNo: section.sections,
	  eventID: section.event_id,
	  sectionName: section.section_name,
      numTables: section.tables,
      numSeatsPerTable: section.seats,
    };
  });

  const occupiedSeats  = <?= json_encode($seatsWithoutV); ?>; 

  // Generate seating map for dynamic sections and pass the selected seats array
  generateSeatingMap(sectionsConfig, occupiedSeats );
  
  $(document).on("click", ".seat", function() {
    toggleSeatColor(this);
  });
  
  $(document).ready(function(){

         $('.any_one_check').click(function() {
              $('.any_one_check').not(this).prop('checked', false);
         });

    });


function getTableNamefromdefine(val) {
	var data = {
        'row_value': val
    };
    $.ajax({
        type: 'POST',
        url: MdsConfig.baseURL + '/TicketController/getTableNameDefine',	
        data: setAjaxData(data),
		 dataType: 'json', // Set the dataType to 'json'
        success: function (response) {
            if (response) {
                let tableName_response = response.table_name;
				let rowValue_response = response.row_value;
				
				$(`#${rowValue_response}`).html(`<i class="fa fa-pencil edit-icon"></i> ${tableName_response}`);
            }
        }
    });
}

function setAjaxData(object = null) {
    var data = {
        'sysLangId': MdsConfig.sysLangId,
    };
    data[MdsConfig.csrfTokenName] = $('meta[name="X-CSRF-TOKEN"]').attr('content');
    if (object != null) {
        Object.assign(data, object);
    }
    return data;
}

$(document).ready(function() {
    $(".edit-icon").on("click", function() {
        let rowValue = $(this).attr("id");

        let $span = $(this);

        let currentText = $span.text();

        let $input = $("<input>").val(currentText);

        function saveChanges(newText) 
		{	
			var data = {
				'row_value': rowValue,
				'table_name_value': newText
			};
			$.ajax({
				type: 'POST',
				url: MdsConfig.baseURL + '/TicketController/updateTableNameDefine',    
				data: setAjaxData(data),
				dataType: 'json',
				success: function (response) {
						if (response == 'updated') {
							
							let $newSpan = $("<span>")
								.addClass("table-name edit-icon")
								.attr("id", rowValue)
								.append('<i class="fa fa-pencil"></i>' ) // Append the icon first
								.append(newText); // Append the text after the icon

							$input.replaceWith($newSpan);

							$("#update-message-container").html('<div class="success-message"><i class="fa fa-check-circle"></i> Update successful!</div>');
							setTimeout(function() {
								$("#update-message-container").empty();
							}, 5000); 
						} else {
							$("#update-message-container").html('<div class="error-message"><i class="fa fa-times-circle"></i> Update failed. Please try again</div>');
						}
					}
				});
        }

        $span.replaceWith($input);

        $input.focus();

        $input.on("keydown", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                let newText = $(this).val();
                saveChanges(newText);
            }
        });
		
        $input.on("blur", function() {
            let newText = $(this).val();
            saveChanges(newText);
        });
    });
});

</script>


