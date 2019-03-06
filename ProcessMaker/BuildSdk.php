<?php
namespace ProcessMaker;

use \Exception;
use \ZipArchive;

class BuildSdk {
    private $rebuild = false;
    private $debug = false;
    private $image = "openapitools/openapi-generator-online:v4.0.0-beta2";
    private $lang = null;
    private $supportedLangs = ['php', 'lua'];
    private $basePath = null;

    public function __construct($basePath, $debug = false, $rebuild = false) {
        $this->basePath = $basePath;
        $this->debug = $debug;
        $this->rebuild = $rebuild;
    }

    public function run()
    {
        $this->runChecks();

        $existing = $this->existingContainers();
        if (!empty($existing) && $this->rebuild) {
            $existing = str_replace("\n", " ", $existing);
            $this->runCmd("docker container stop $existing");
            $this->runCmd("docker container rm $existing");
            $existing = [];
        }

        if (empty($existing) || $this->rebuild) {
            $this->runCmd('docker pull ' . $this->image);
            $cid = $this->runCmd('docker run -d --name generator -e GENERATOR_HOST=http://127.0.0.1:8080 ' . $this->image);
            $this->docker('apk add --update curl && rm -rf /var/cache/apk/*');
        }

        $this->waitForBoot();

        $response = $this->docker($this->curlPost());

        $json = json_decode($response, true);
        $link = $json['link'];

        $zip = $this->getZip($link);
        $folder = $this->unzip($zip);

        $this->runCmd("mv -f $folder {$this->outputBaseDir()}/");
        $this->log("DONE. Api is at {$this->outputDir()}");
    }

    public function setLang($value) {
        if (!in_array($value, $this->supportedLangs)) {
            throw new Exception("$value language is not supported");
        }
        $this->lang = $value;
    }

    private function runChecks()
    {
        if (!$this->lang) {
            throw new Exception("Language must be specified using setLang()");
        }

        if (!is_dir($this->basePath)) {
            throw new Exception("$basePath is not a valid directory");
        }

        if (is_dir($this->outputDir())) {
            throw new Exception("Folder exists: {$this->outputDir()}. You must manually remove the destination folder before running this script.");
        }

        if (!is_writable($this->outputBaseDir())) {
            throw new Exception("Folder is not writeable: " . $this->outputDir());
        }
    }

    private function outputBaseDir()
    {
        return "{$this->basePath}/storage/api";
    }
    
    private function outputDir()
    {
        return "{$this->outputBaseDir()}/{$this->lang}-client";
    }

    private function waitForBoot()
    {
        $i = 0;
        while(true) {
            try {
                $this->docker("curl -s -S http://127.0.0.1:8080/api/gen/clients/{$this->lang}");
                break;
            } catch(Exception $e) {
                if (strpos($e->getMessage(), 'Connection refused') !== false) {
                    $this->log("Not ready, trying again in 2 seconds. " . $e->getMessage());
                } else {
                    throw $e;
                }
            }
            if ($i > 20) { 
                throw new Exception("Took too long to start up.");
            }
            sleep(2);
            $i++;
        }
    }

    private function getZip($url)
    {
        $filename = "{$this->basePath}/api.zip";
        $this->docker("curl -s -S $url > $filename");
        return $filename;
    }

    private function unzip($file)
    {
        $zip = new ZipArchive;
        $res = $zip->open($file);
        $folder = explode('/', $zip->statIndex(0)['name'])[0];
        $zip->extractTo($this->basePath);
        $zip->close();
        unlink($file);
        return "{$this->basePath}/$folder";
    }

    private function existingContainers()
    {
        return $this->runCmd("docker container ls -aq --filter='name=generator'");
    }

    private function curlPost()
    {
        return 'curl -s -S '
            . '-H "Accept: application/json" '
            . '-H "Content-Type: application/json" '
            . '-X POST -d ' . $this->cliBody() . ' '
            . 'http://127.0.0.1:8080/api/gen/clients/'.$this->lang;
    }

    private function docker($cmd)
    {
        return $this->runCmd('docker exec generator ' . $cmd);
    }

    private function cliBody()
    {
        return escapeshellarg(
            str_replace('"API-DOCS-JSON"', $this->apiJsonRaw(), $this->requestBody())
        );
    }
    
    private function requestBody()
    {
        # get all available options with curl http://127.0.0.1:8080/api/gen/clients/php
        return json_encode([
            "options" => [
                "gitUserId" => "ProcessMaker",
                "gitRepoId" => "bpm-".$this->lang."-sdk",
            ],
            "spec" => "API-DOCS-JSON",
        ]);
    }

    private function apiJsonRaw()
    {
        return file_get_contents($this->basePath . "/storage/api-docs/api-docs.json");
    }

    private function runCmd($cmd)
    {
        $this->log("Running: $cmd");
        exec($cmd . " 2>&1", $output, $returnVal);
        $output = implode("\n", $output);
        if ($returnVal) {
            throw new Exception("Cmd returned: $returnVal " . $output);
        }
        $this->log("Got: '$output'");
        return $output;
    }

    private function log($message)
    {
        if ($this->debug) {
            echo "$message\n";
        }
    }
}
