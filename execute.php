<?php
session_start();
header('Content-Type: application/json');

$input = trim($_POST['input'] ?? '');
$response = 'Unknown command.';
$inputLower = strtolower($input);

// History সংরক্ষণ
if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = [];
}
$_SESSION['history'][] = $input;

// Command execution
if (preg_match('/^scan (https?:\/\/[^\s]+)$/', $inputLower, $m)) {
    $url = $m[1];
    $headers = @get_headers($url, 1);
    if ($headers) {
        $response = "🔍 Headers for $url:\n";
        foreach ($headers as $key => $val) {
            if (is_array($val)) $val = implode(", ", $val);
            $response .= "$key: $val\n";
        }
    } else {
        $response = "❌ Could not fetch headers for $url.";
    }

} elseif (preg_match('/^weather (.+)$/', $inputLower, $m)) {
    $city = urlencode($m[1]);
    $apiKey = "YOUR_OPENWEATHERMAP_API_KEY";
    $weather = @file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric");
    if ($weather) {
        $data = json_decode($weather, true);
        $temp = $data['main']['temp'];
        $desc = $data['weather'][0]['description'];
        $response = "🌦 Weather in {$m[1]}: $temp°C, $desc";
    } else {
        $response = "❌ Could not fetch weather.";
    }

} elseif (preg_match('/^phishgen (.+)$/', $inputLower, $m)) {
    $site = htmlspecialchars($m[1]);
    $filename = "fake_{$site}_login.html";
    $html = "<!DOCTYPE html><html><body><h2>Fake $site Login</h2><form><input type='text' placeholder='Username'><br><input type='password' placeholder='Password'><br><button>Login</button></form></body></html>";
    file_put_contents($filename, $html);
    $response = "🎣 Fake $site login page generated: $filename";

} elseif (preg_match('/^generate (.+)$/', $inputLower, $m)) {
    $site = htmlspecialchars($m[1]);
    $filename = "fake_{$site}_login.html";
    $html = "<!DOCTYPE html><html><body><h2>Fake $site Login</h2><form><input type='text' placeholder='Username'><br><input type='password' placeholder='Password'><br><button>Login</button></form></body></html>";
    file_put_contents($filename, $html);
    $response = "⚙️ Generated fake page: $filename";

} elseif (preg_match('/^ip ([\d\.]+)$/', $inputLower, $m)) {
    $ip = $m[1];
    $lookup = @file_get_contents("http://ip-api.com/json/$ip");
    $data = json_decode($lookup, true);
    if ($data && $data['status'] === 'success') {
        $response = "🌐 IP Info for $ip:\nCountry: {$data['country']}\nRegion: {$data['regionName']}\nCity: {$data['city']}\nISP: {$data['isp']}";
    } else {
        $response = "❌ Invalid IP or lookup failed.";
    }

} elseif (preg_match('/^shorten (https?:\/\/[^\s]+)$/', $inputLower, $m)) {
    $url = urlencode($m[1]);
    $short = @file_get_contents("https://is.gd/create.php?format=simple&url=$url");
    $response = $short ? "🔗 Shortened: $short" : "❌ Failed to shorten link.";

} elseif (preg_match('/^darknet (.+)$/', $inputLower, $m)) {
    $response = "🕸 DarkNet search for '{$m[1]}' initiated. (Demo mode)";

} elseif ($inputLower === "history") {
    $response = "📜 Your command history:\n";
    foreach ($_SESSION['history'] as $i => $cmd) {
        $response .= ($i + 1) . ". " . htmlspecialchars($cmd) . "\n";
    }

} else {
    $response = "❓ Unknown command: $input";
}

echo json_encode(["response" => $response]);
