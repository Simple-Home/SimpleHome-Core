$tags = @(
    "TODO", 
    "FIX", 
    "ASK"
);
$excludeDirs = [string[]] @(
    "storage",
    "vendor",
    "Todo.txt"
);

$files = Get-ChildItem -Path "./" -Exclude $excludeDirs | Get-ChildItem -Recurse -File
$items = @();

foreach ($file in $files) {
    $foundItems = $file | Get-Content -Encoding UTF8 | select-string -Pattern $tags -CaseSensitive | Select-Object Line, LineNumber, Pattern
    foreach ($foundItem in $foundItems) {  
        $foundItemPattern = $foundItem.Pattern.ToString();
        if ($null -ne $foundItem) {
            $tagPosition = $foundItem.Line.ToString().Trim().IndexOf($foundItemPattern);
            if ($tagPosition -ge 0) {
                $items += [PSCustomObject]@{
                    text    = $foundItem.Line.ToString().Trim().Substring($tagPosition)
                    line    = $foundItem.LineNumber
                    file    = $file | Resolve-Path -Relative
                    pattern = $foundItemPattern
                }
            }
        }
    }
}

$items | Export-Clixml -Path ".\previousRun.xml"
$items | Format-Table -AutoSize | Out-File ".\Todo.txt" -Encoding UTF8 -Force
$items | Group-Object -Property pattern | Select-Object -Property Name, Count