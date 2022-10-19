<?php

use Phalcon\Mvc\User\Component;

class GlobalVariable extends Component
{
    public $contentTypeImages;
    public $timeZoneStr;
    public $timeZone;
    public $curTime;
    public $localTime;
    public $listTableNotWriteLog;
    public $global;
    public $defaultLocation;
    public $defaultLanguage;
    public $cronToken;
    public $cronPassword;
    public $maxImageUploadSize;
    public $USD;
    public $site_id;
    public function __construct()
    {
        date_default_timezone_set('UTC');//default for Application - NOT ONLY for current script
        $this->timeZone = 5.5*3600;
        $this->curTime = time();
        $this->localTime = time() + $this->timeZone;
        $this->timeZoneStr = 'UTC+05:00';
        //accept upload file types
        $this->contentTypeImages = array(
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',
            'txt' => 'text/plain',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'pdf'  => 'application/pdf',
        );
        $this->listTableNotWriteLog = array(
            "visa_log_activity",
            "visa_activity",
            "visa_ip",
            "visa_user_agent",
        );
        $this->cronToken = "ThanhLongBinCorp0292";
        $this->cronPassword = 'k3FRQ1U0bYHUVSu6';
        $this->maxImageUploadSize = 20971520;
        $this->USD = array(
            "rate" => 1,
            "name" => "US Dollar",
            "code" => "USD",
            "sCode" => "US",
            "symbol" => "US$",
        );
        $this->global = array(
            "name" => "Global",
            "code" => "gx",
        );
        $this->defaultLocation ='gx';
        $this->defaultLanguage ='en';
        $this->site_id = 49;
    }
}