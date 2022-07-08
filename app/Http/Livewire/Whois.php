<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Iodev\Whois\Factory;
use Iodev\Whois\Exceptions\ConnectionException;
use Iodev\Whois\Exceptions\ServerMismatchException;
use Iodev\Whois\Exceptions\WhoisException;
use Mockery\Exception;

class Whois extends Component
{
    public $search;
    //public $domains = [];

    public function render(){
        //sleep(1);
        $domain = $this->checkDomain($this->search);
        return view('livewire.whois', ['domain' => $domain]);
    }

    protected function checkDomain($domain){
        try {
            // CONNECT WHOIS SERVICE
            $whois = Factory::get()->createWhois();
            // CHECK DOMAIN ISSET

            if(!empty($domain)){
                $info = $whois->loadDomainInfo($domain);
                if (!$info) {
                    return $this->makeResponse(0, "Null if domain available");
                }
                $message = $info->domainName . " expires at: " . date("d.m.Y H:i:s", $info->expirationDate);
                return $this->makeResponse(1, $message, $info);
            }else {
                return $this->makeResponse(0, "Domain not found");
            }
        } catch (ConnectionException $e) {
            return $this->makeResponse(0, "Disconnect or connection timeout");
        } catch (ServerMismatchException $e) {
            return $this->makeResponse(0, "TLD server (.com for google.com) not found in current server hosts");
        } catch (WhoisException $e) {
            return $this->makeResponse(0, "Whois server responded with error '{$e->getMessage()}'");
        }
    }

    protected function makeResponse($status = 0, $message = "Empty", $data = []){
        return (object)[
            'status' => (bool) $status,
            'message' => (string) $message,
            'data' => (object) $data
        ];
    }
}
