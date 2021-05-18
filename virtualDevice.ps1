$headers = @{}
$headers.Add("Content-Type", "application/json")
$headers.Add("Authorization", "Bearer 4f285s8mam89")
$baseUrl = 'https://dev.steelants.cz/vasek/simple-home-v4/public/api/v1'
$mute = 0

while ($True) {

    $response = Invoke-WebRequest -Uri "$baseUrl/setup" -Method POST -Headers $headers -ContentType 'application/json' -Body '{
        "properties": ["humi","wifi","temp","mute","ligth"]
    }'

    if ($response.StatusCode -ne 200) {
        Write-Host $response.Content -ForegroundColor Red
    }
    else {
        Write-Host $response.Content -ForegroundColor Green
    }
    $configuration = $response.Content | ConvertFrom-Json

    while ($True) {
        $response = Invoke-WebRequest -Uri "$baseUrl/data" -Method POST -Headers $headers -ContentType 'application/json' -Body ('{
            "humi": '+ (Get-Random -Minimum 0 -Maximum 100) + ',
			"wifi": '+ (Get-Random -Minimum -100 -Maximum 0) + ',
			"light": '+ (Get-Random -Minimum -100 -Maximum 0) + ',
			"co2": '+ (Get-Random -Minimum -100 -Maximum 0) + ',
			"temp": '+ (Get-Random -Minimum -5 -Maximum 70) + '
        }')

        if ($response.StatusCode -ne 200) {
            Write-Host $response.Content -ForegroundColor Red
        }
        else {
            Write-Host $response.Content -ForegroundColor Green
        }


        if (($response.Content | ConvertFrom-Json).commands) {
            switch (($response.Content | ConvertFrom-Json).commands) {
                'reboot' {
                    break
                }
            }
        }

        if (($response.Content | ConvertFrom-Json).mute -and ($response.Content | ConvertFrom-Json).mute -ne $mute) {
            $obj = new-object -com wscript.shell
            $obj.SendKeys([char]173)
            $mute = ($response.Content | ConvertFrom-Json).mute
        }

        Start-Sleep -Seconds $configuration.sleep
    }
}
