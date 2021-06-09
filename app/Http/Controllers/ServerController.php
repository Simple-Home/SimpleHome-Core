<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Devices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use DateTime;

class ServerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $chartDisk = app()->chartjs
            ->name('chartDisk')
            ->type('doughnut')
            ->size(['width' => 300, 'height' => 300])
            ->labels([__('Free'), __('Used')])
            ->datasets([
                [
                    'backgroundColor' => ['rgb(234, 84, 85)', 'rgb(255, 255, 255)'],
                    'data' => [$this->disk_stat()["used"], ($this->disk_stat()["total"] - $this->disk_stat()["used"])]
                ]
            ])
            ->optionsRaw("{
                legend: {
                    display: false
                },
                tooltips: {
                    callbacks: {
                        label: function(t, d) {
                            console.log(d);
                            t.yLabel = d.datasets[0].data[t.index];
                            var yLabel = t.yLabel >= 1000 ?
                            t.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ') : t.yLabel;
                            return d.labels[t.index] + ' ' + yLabel + 'GB';
                        }
                    },
                }
            }");

        $chartRam = app()->chartjs
            ->name('chartRam')
            ->type('doughnut')
            ->size(['width' => 300, 'height' => 300])
            ->labels([__('Free'), __('Used')])
            ->datasets([
                [
                    'backgroundColor' => ['rgb(234, 84, 85)', 'rgb(255, 255, 255)'],
                    'data' => [$this->ram_stat()["used"], ($this->ram_stat()["total"] - $this->ram_stat()["used"])]
                ]
            ])
            ->optionsRaw("{
                legend: {
                    display: false
                },
                tooltips: {
                    callbacks: {
                        label: function(t, d) {
                            console.log(d);
                            t.yLabel = d.datasets[0].data[t.index];
                            var yLabel = t.yLabel >= 1000 ?
                            t.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ') : t.yLabel;
                            return d.labels[t.index] + ' ' + yLabel + 'GB';
                        }
                    },
                }
            }");


        $chartCpu = app()->chartjs
            ->name('chartCpu')
            ->type('doughnut')
            ->size(['width' => 300, 'height' => 300])
            ->labels([__('Free'), __('Used')])
            ->datasets([
                [
                    'backgroundColor' => ['rgb(234, 84, 85)', 'rgb(255, 255, 255)'],
                    'data' => [$this->cpu_stat(), (1 - $this->cpu_stat())]
                ]
            ])
            ->optionsRaw("{
                legend: {
                    display: false
                },
                tooltips: {
                    callbacks: {
                        label: function(t, d) {
                            console.log(d);
                            t.yLabel = d.datasets[0].data[t.index];
                            var yLabel = t.yLabel >= 1000 ?
                            t.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ') : t.yLabel;
                            return d.labels[t.index] + ' ' + yLabel;
                        }
                    },
                }
            }");
        $services['apache2'] = $this->service_status('apache2');
        $services['mysql'] = $this->service_status('mysql');
        $services['public_ip'] = $this->public_ip();
        $services['internal_ip'] = $_SERVER['SERVER_ADDR'];
        $services['hostname'] = gethostname();
        $valuesPerMinute = $this->values_per_minute();
        $uptime = $this->last_boot_time();
        $ssl = $this->get_https();

        return view('server', compact('chartDisk', 'chartRam', 'chartCpu', 'services', 'valuesPerMinute', 'uptime', 'ssl'));
    }

    private function ram_stat()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return [
                "used" => 0,
                "total" => 0,
            ];
        }

        //RAM usage
        $free = shell_exec('free');
        $free = (string) trim($free);
        $free_arr = explode("\n", $free);
        $mem = explode(" ", $free_arr[1]);
        $mem = array_filter($mem);
        $mem = array_merge($mem);
        $usedmem = $mem[2];
        $usedmemInGB = number_format($usedmem / 1048576, 2);
        $memory1 = $mem[2] / $mem[1] * 100;
        $memory = round($memory1) . '%';
        $fh = fopen('/proc/meminfo', 'r');
        $mem = 0;
        while ($line = fgets($fh)) {
            $pieces = array();
            if (preg_match('/^MemTotal:\s+(\d+)\skB$/', $line, $pieces)) {
                $mem = $pieces[1];
                break;
            }
        }
        fclose($fh);
        $totalram = number_format($mem / 1048576, 2);
        return [
            "used" => $usedmemInGB,
            "total" => $totalram,
        ];
    }

    private function cpu_stat()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return 0;
        }

        //cpu usage
        $cpu_load = sys_getloadavg();
        $load = $cpu_load[0];
        return $load;
    }

    private function service_status($service_name)
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return false;
        }

        //service
        $serviceStatus = shell_exec('service ' . $service_name . ' status');
        $serviceStatus = (string) trim($serviceStatus);
        $service_arr = explode("\n", $serviceStatus);
        $status = explode(" ", $service_arr[2]);

        return (array_key_exists(6, $status) ? ($status[6] == "active" ? true : false) : false);
    }

    private function disk_stat()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return [
                "used" => 0,
                "total" => 0,
            ];
        }
        
        $dt = round(disk_total_space("/var/www") / 1024 / 1024 / 1024);
        $df = round(disk_free_space("/var/www") / 1024 / 1024 / 1024);
        return [
            "used" => ($dt - $df),
            "total" => $dt,
        ];
    }

    private function public_ip()
    {
        $cURLConnection = curl_init();
        curl_setopt($cURLConnection, CURLOPT_URL, 'https://api.ipify.org/?format=json');
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        $phoneList = curl_exec($cURLConnection);
        $httpcode = curl_getinfo($cURLConnection, CURLINFO_HTTP_CODE);
        curl_close($cURLConnection);
        $jsonArrayResponse = json_decode($phoneList);
        if ($httpcode != 200) {
            return false;
        }
        return $jsonArrayResponse->ip;
    }

    private function values_per_minute()
    {
        return (DB::table('records')
            ->where(
                'created_at',
                '>',
                Carbon::now()->subMinutes(1)->toDateTimeString()
            ))->count();
    }

    private function last_boot_time(){
        $info = exec('systeminfo | find /i "Boot Time"');
        return Carbon::parse(trim(str_replace("System Boot Time:", "", $info)))->diffForHumans();;
    }

    private function get_https(){
        if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') {
            return false;
        }
        return true;
    }
}
