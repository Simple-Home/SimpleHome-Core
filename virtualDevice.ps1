$headers = @{}
$headers.Add("Content-Type", "application/json")
$headers.Add("Authorization", "Bearer token")
$headers.Add("Accept", "application/json")
$baseUrl = 'http://localhost/smarthome/api/v1'
$mute = 0

$registrationOk = $false;
while ($True) {

    $response = Invoke-WebRequest -Uri "$baseUrl/setup" -Method POST -Headers $headers -ContentType 'application/json' -Body '{
        "properties": ["humi","wifi","temp","mute","ligth","batt"]
    }'

    if ($response.StatusCode -ne 200) {
        Write-Host $response.Content -ForegroundColor Red
    }
    else {
        Write-Host $response.Content -ForegroundColor Green
        $registrationOk = $true;
    }
    $configuration = $response.Content | ConvertFrom-Json

    while ($registrationOk) {
        $body =     '{';
        $body +=    '"humi": '+ (Get-Random -Minimum 0 -Maximum 100) + ',';
        $body +=    '"wifi": '+ (Get-Random -Minimum -100 -Maximum 0) + ',';
        $body +=    '"light": '+ (Get-Random -Minimum -100 -Maximum 0) + ',';
        $body +=    '"co2": '+ (Get-Random -Minimum -100 -Maximum 0) + ',';
        $body +=    '"temp": '+ (Get-Random -Minimum -5 -Maximum 70) + ',';
        $body +=    '"batt": '+ (Get-Random -Minimum -1 -Maximum 4.7);
        $body +=    '}';

        $timeTaken = Measure-Command -Expression {
            $response = Invoke-WebRequest -Uri "$baseUrl/data" -Method POST -Headers $headers -ContentType 'application/json' -Body ($body)
        }
        Write-Host "->" ($body) -ForegroundColor Blue

        if ($response.StatusCode -ne 200) {
            Write-Host ("<- "+$response.Content+" - $([Math]::Round($timeTaken.TotalMilliseconds, 1)) ms") -ForegroundColor Red
        }
        else {
            Write-Host ("<- "+$response.Content+" - $([Math]::Round($timeTaken.TotalMilliseconds, 1)) ms") -ForegroundColor Green
        }

        if (($response.Content | ConvertFrom-Json).commands) {
            switch (($response.Content | ConvertFrom-Json).commands) {
                'reboot' {
                    break
                }
            }
        }

        if (($response.Content | ConvertFrom-Json).mute -eq 1 -and $mute -ne ($response.Content | ConvertFrom-Json).mute) {
            $obj = new-object -com wscript.shell
            $obj.SendKeys([char]173)
            $mute = ($response.Content | ConvertFrom-Json).mute
        }

        Start-Sleep -Milliseconds ($configuration.sleep)
    }

    Start-Sleep -Seconds 30
}
