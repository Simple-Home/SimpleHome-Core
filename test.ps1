$headers = @{}
$headers.Add("Content-Type", "application/json")
$headers.Add("Authorization", "Bearer 4f285s8mam")
$baseUrl = 'https://dev.steelants.cz/vasek/simple-home-v4/public/api'
$response = Invoke-WebRequest -Uri "$baseUrl/setup" -Method POST -Headers $headers -ContentType 'application/json' -Body '{
		"properties": ["humi","wifi","temp"]
}
 '


$response = Invoke-WebRequest -Uri "$baseUrl/data" -Method POST -Headers $headers -ContentType 'application/json' -Body '{
		"humi": 20,
		"wifi": 20,
		"temp": 20
}
 '
