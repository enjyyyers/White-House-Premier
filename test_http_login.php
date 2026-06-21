<?php
// Simulate HTTP login via curl
$baseUrl = 'http://localhost/WhiteHouse/public';

echo "=== Testing GET login page ===\n";
$ch = curl_init("$baseUrl/login");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, 'test_cookies.txt');
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo "HTTP Code: $httpCode\n";

// Extract CSRF token from response
preg_match('/<input type="hidden" name="_token" value="([^"]+)"/', $response, $matches);
$csrfToken = $matches[1] ?? 'not found';
echo "CSRF Token: $csrfToken\n";

// Extract session cookie
preg_match('/Set-Cookie: ([^=]+)=([^;]+)/', $response, $cookieMatches);
$cookieName = $cookieMatches[1] ?? 'unknown';
$cookieValue = $cookieMatches[2] ?? 'unknown';
echo "Cookie: $cookieName=$cookieValue\n";

curl_close($ch);

echo "\n=== Testing POST login ===\n";
$ch = curl_init("$baseUrl/login");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    '_token' => $csrfToken,
    'email' => 'admin@gmail.com',
    'password' => 'admin123',
    'remember' => 'on',
]));
curl_setopt($ch, CURLOPT_COOKIE, "$cookieName=$cookieValue");
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo "HTTP Code: $httpCode\n";

// Check if we got a redirect
$redirectUrl = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
echo "Redirect URL: " . ($redirectUrl ?: 'none') . "\n";

// Check response body for any errors
$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$body = substr($response, $headerSize);
if (strpos($body, 'error') !== false || strpos($body, 'salah') !== false) {
    echo "ERROR in response!\n";
    echo substr($body, 0, 500) . "\n";
}

// Check response headers for Set-Cookie
preg_match_all('/Set-Cookie: ([^=]+)=([^;]+)/', $response, $setCookieMatches);
echo "Response Cookies:\n";
foreach ($setCookieMatches[0] as $i => $cookie) {
    echo "  $cookie\n";
}

curl_close($ch);

// Clean up
@unlink('test_cookies.txt');
echo "\n=== Done ===\n";
