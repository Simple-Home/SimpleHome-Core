$headers = @{}
$headers.Add("Content-Type", "application/json")
$headers.Add("Accept", "application/json")
$baseUrl = 'http://localhost/api/depricated'

while ($True) {
    $duration = (Measure-Command -Expression { 
            $response = Invoke-WebRequest -Uri "$baseUrl/endpoint" -Method POST -Headers $headers -ProgressPreference 'SilentlyContinue' -ContentType 'application/json' -Body '{"token": ""}'
        })
    
    $response.Content
    $duration.Milliseconds

    Start-Sleep -Seconds 5
}

