<?php
// connect to the database
$conn = mysqli_connect("localhost", "username", "password", "HotelDB");

// get the values from the form
$hotel_id = $_POST['hotel_id'];
$room_type = $_POST['room_type'];
$check_in_date = $_POST['check_in_date'];
$check_out_date = $_POST['check_out_date'];
$guest_name = $_POST['guest_name'];
$guest_email = $_POST['guest_email'];

// find an available room at the selected hotel
$sql = "SELECT * FROM Rooms WHERE HotelID='$hotel_id' AND Type='$room_type' AND Occupied=0";
$result = mysqli_query($conn, $sql);

// if an available room was found, create a reservation
if (mysqli_num_rows($result) > 0) {
	$row = mysqli_fetch_assoc($result);
	$room_id = $row['RoomID'];
	$sql = "INSERT INTO Reservations (RoomID, CheckIn, CheckOut, GuestName, GuestEmail) VALUES ('$room_id', '$check_in_date', '$check_out_date', '$guest_name', '$guest_email')";
	mysqli_query($conn, $sql);

	// update the room's status to occupied
	$sql = "UPDATE Rooms SET Occupied=1 WHERE RoomID='$room_id'";
	mysqli_query($conn, $sql);

	echo "Room booked successfully!";
} else {
	echo "Sorry, there are no available rooms of that type at the selected hotel.";
}
?>
