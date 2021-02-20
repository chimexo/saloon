<?php include 'db_connect.php'; ?>

<?php
    if (isset($_SESSION["role"]) && $_SESSION["role"] == "staff" || isset($_SESSION["role"]) && $_SESSION["role"] == "manager") {
        header("location: staff/dashboard.php");
    }
?>

<?php 
if (!isset($_SESSION["id"]) && empty($_SESSION["id"])) 
    {
        header('location: login.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Appointment Booking</title>
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
  <script src="script.js"></script>
</head>
<body id="appointment-page">

    <!-- Include navigation bar -->
    <?php include "navigationBar.php" ?>
    
      <h1 class="display-4 text-center">Appointment</h1>
  <div class="ui segment" id="appointment-loader">
    <p></p>
    <div class="ui active dimmer">
      <div class="ui text large loader">Confirming appointment ...</div>
    </div>
  </div>
  <div class="container">
    <div class="purchase-flow-other">
      <div class="ui steps">
        <div id="date-step" class="active step"> <i class="calendar alternate icon"></i>
          <div class="content">
            <div class="title">Date & Time</div>
            <div class="description">Personalize your time</div>
          </div>
        </div>
        <div id="service-step" class="step"> <i class="shopping cart icon"></i>
          <div class="content">
            <div class="title">Services</div>
            <div class="description">Choose your service</div>
          </div>
        </div>
        <div id="request-step" class="step"> <i class="bullhorn icon"></i>
          <div class="content">
            <div class="title">Special Request</div>
            <div class="description">We hear you</div>
          </div>
        </div>
        <div id="summary-step" class="disabled step"> <i class="info icon"></i>
          <div class="content">
            <div class="title">Confirm Appointment</div>
          </div>
        </div>
      </div>
    </div>
    <!-- date and time form -->
    <form class="ui form" id="date-form">
      <h3 class="ui dividing header">Date & Time</h3>
      <div class="field">
        <label>Date</label>
        <div class="field">
          <input type="date" name="date" id="appointment-date">
        </div>
      </div>
      <div class="field">
        <p>
          <label>Timeslot</label>
          <select name="appointment-time" class="ui fluid dropdown" id="appointment-time">
            <option value="none">Pick your time</option>
            <option value="09:00 - 10:00">09:00 - 10:00 am</option>
            <option value="10:00 - 11:00">10:00 - 11:00 am</option>
            <option value="11:00 - 12:00">11:00am - 12:00 pm</option>
            <option value="02:00 - 03:00">02:00 - 03:00 pm</option>
            <option value="04:00 - 05:00">04:00 - 05:00 pm</option>
            <option value="06:00 - 07:00">06:00 - 07:00 pm</option>
            <option value="08:00 - 09:00">08:00 - 09:00 pm</option>
            <option value="10:00 - 11:00">10:00 - 11:00 pm</option>
          </select>
        </p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
      </div>
      <button type="button" class="btn btn-primary next-button" onMouseOver="onHoverNext(this)" onmouseleave="onLeaveNext(this)" onClick="onCompleteDateInfo()">Next <i class="arrow right icon arrow-next"></i></button>
    </form>
    <!-- services details form -->
    <form class="ui form" id="service-form">
      <h3 class="ui dividing header">Services</h3>
      <div class="field">
        <label>Type of services</label>
        <select class="ui fluid search dropdown" name="service" id="service">
          <option value="none">Choose your service</option>
          <option value="Hair-cutting">Hair-cutting</option>
          <option value="Hair-dyeing">Hair-dyeing</option>
          <option value="Hair consultation">Hair consultation</option>
        </select>
      </div>
      <div class="field">
        <label>Hairdresser</label>
        <select class="ui fluid search dropdown" name="hairdresser" id="hairdresser">
          <option value="none">Choose your service</option>
          <option value="David Cheam">David Cheam</option>
          <option value="Steven Lau">Steven Lau</option>
          <option value="Joanne Cheong">Joanne Cheong</option>
          <option value="Any">Any</option>
        </select>
      </div>
      <button type="button" class="btn btn-primary next-button" onMouseOver="onHoverNext(this)" onmouseleave="onLeaveNext(this)" onClick="onCompleteServicesInfo()">Next <i class="arrow right icon arrow-next"></i></button>
      <button type="button" class="btn btn-primary next-button" onMouseOver="onhoverPrevious(this)" onmouseleave="onLeavePrevious(this)" onClick="onBackToDate()"><i class="arrow left icon"></i> Back to previous</button>
    </form>
    <!-- request form -->
    <form class="ui form" id="request-form">
      <h3 class="ui dividing header">Special Request</h3>
      <div class="field">
        <textarea name="request-box" id="request-box" placeholder="Enter you request"></textarea>
      </div>
      <div>
        <div class="ui checkbox">
          <input type="checkbox" name="example" id="hasRequest" onChange="onSwitchRequest()">
          <label for="hasRequest">I do not have any special requests</label>
        </div>
      </div>
      <button type="button" class="btn btn-primary next-button" onMouseOver="onHoverNext(this)" onmouseleave="onLeaveNext(this)" onClick="onCompleteRequestInfo()">Next <i class="arrow right icon arrow-next"></i></button>
      <button type="button" class="btn btn-primary next-button" onMouseOver="onhoverPrevious(this)" onmouseleave="onLeavePrevious(this)" onClick="onBackToService()"><i class="arrow left icon"></i> Back to previous</button>
    </form>
    <!-- summary form -->
    <form class="ui form" id="summary-form">
      <h3 class="ui dividing header">Appointment Summary</h3>
      <p class="summary-title" id="summary-date">Date: </p>
      <p class="summary-title" id="summary-time">Time: </p>
      <p class="summary-title" id="summary-service">Service: </p>
      <p class="summary-title" id="summary-hairdresser">Hairdresser: </p>
      <p class="summary-title" id="summary-request">Special Request: </p>
      <button type="button" class="btn btn-primary next-button" onClick="onConfirmSummary()"><i class="check icon"></i> Confirm</button>
      <button type="button" class="btn btn-primary next-button" onClick="onEditSummary()"><i class="edit icon"></i> Edit</button>
    </form>
    <!-- Pop out confirmation -->
    <div class="ui basic modal modal-container" id="success-booking-modal">
      <div class="ui icon header"> <i class="calendar check icon"></i> Appointment confirmed </div>
      <div class="content">
        <p class="modal-message">An appointment summary has been sent to your email.</p>
      </div>
      <div class="actions">
        <div class="ui orange ok inverted button okay-button-modal"> <i class="checkmark icon"></i> Great </div>
      </div>
    </div>
    <div class="ui basic modal modal-container" id="fail-booking-modal">
      <div class="ui icon header"> <i class="calendar minus icon"></i> Oops something went wrong! </div>
      <div class="content">
        <p class="modal-message">Please try again later :(</p>
      </div>
      <div class="actions">
        <div class="ui red ok inverted button okay-button-modal"> <i class="checkmark icon"></i> Okay </div>
      </div>
    </div>
    <div class="ui basic modal modal-container" id="over-booking-modal">
      <div class="ui icon header"> <i class="hand paper outline icon"></i> Slow Down </div>
      <div class="content">
        <p class="modal-message">You still have 2 unfulfilled appointments!</p>
      </div>
      <div class="actions">
        <div class="ui red ok inverted button okay-button-modal"> <i class="checkmark icon"></i> Okay </div>
      </div>
    </div>
    <div class="ui basic modal modal-container" id="duplicate-booking-modal">
      <div class="ui icon header"> <i class="calendar minus icon"></i> Timeslot taken </div>
      <div class="content">
        <p class="modal-message">This timeslot has already been taken!</p>
      </div>
      <div class="actions">
        <div class="ui red ok inverted button okay-button-modal"> <i class="checkmark icon"></i> Okay </div>
      </div>
    </div>
  </div>
  <?php include "footer.php"; ?>
</body>
</html>

