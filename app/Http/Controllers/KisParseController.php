<?php

namespace App\Http\Controllers;
use App\Models\BeaconRecord;
use Illuminate\Http\Request;
use App\Models\Beacon;

class KisParseController extends Controller
{
    public $curl;
    public $hosts;

    public function __construct()
    {
        $this->hosts = $this->getHosts();
    }

    public function getHosts()
    {
        $hosts = Beacon::where('active', 1)->get();
        return $hosts;
    }

    public function makeRequest($method, $host, $endpoint, $data=false)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "2501",
            CURLOPT_URL => $host . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Cache-Control: no-cache",
                "Content-Type: application/x-www-form-urlencoded",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }


    public function get_all_kismet_records($hosts)
    {
        $data = 'json={"fields":["kismet.device.base.macaddr","kismet.device.base.type","kismet.device.base.last_time","kismet.device.base.frequency","kismet.device.base.signal/kismet.common.signal.last_signal_dbm"]}';

        //json={"fields":["kismet.device.base.type","kismet.device.base.macaddr","kismet.device.base.last_time"]}
        //json=%7B%22fields%22%3A%5B%22kismet.device.base.type%22%2C%22kismet.device.base.macaddr%22%2C%22kismet.device.base.last_time%22%5D%7D

        foreach ($hosts as $host){
            $r = $this->makeRequest("POST",$host->host ,'/devices/summary/devices.json',$data);
            foreach (json_decode($r) as $row){
                BeaconRecord::create([
                    'reportedFrom' => $host->host,
                    'mac' => $row->{'kismet.device.base.macaddr'},
                    'type' => $row->{'kismet.device.base.type'},
                    'signalStrength' => $row->{'kismet.common.signal.last_signal_dbm'},
                    'timestamp' => $row->{'kismet.device.base.last_time'},
                    'frequency' => $row->{'kismet.device.base.frequency'}
                ]);
            }
        };
    }

    public function get_kismet_records_from_timestamp($hosts)
    {
        $data = 'json={"fields":["kismet.device.base.macaddr","kismet.device.base.type","kismet.device.base.last_time","kismet.device.base.frequency","kismet.device.base.signal/kismet.common.signal.last_signal_dbm"]}';

        foreach ($hosts as $host){
            $r = $this->makeRequest("POST",$host->host ,'/devices/last-time/'. $host->lastRead .'/devices.json',$data);
            $host->lastRead = $this->get_kismet_timestamp($host->host);
            $host->save();

            foreach (json_decode($r) as $row){
                BeaconRecord::create([
                    'reportedFrom' => $host->host,
                    'mac' => $row->{'kismet.device.base.macaddr'},
                    'type' => $row->{'kismet.device.base.type'},
                    'signalStrength' => $row->{'kismet.common.signal.last_signal_dbm'},
                    'timestamp' => $row->{'kismet.device.base.last_time'},
                    'frequency' => $row->{'kismet.device.base.frequency'}
                ]);
            }
        }

        //get records from last read timestamp
    }


    public function get_kismet_timestamp($host)
    {
        $timestamp = json_decode($this->makeRequest('GET', $host, "/system/timestamp.json"));
        return $timestamp->{'kismet.system.timestamp.sec'};
    }

    public function index()
    {

        $this->get_kismet_records_from_timestamp($this->hosts);
    }
}
