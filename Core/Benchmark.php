<?php

namespace Core;

/**
 * Class code.
 */
class Benchmark {

    private $format;

    /**
     * Constructor.
     */
    public function AppGati($format = 'array') {
        $this->format = $format;
        //parent::__construct();
    }

    /**
     * set the format of the result to be returned
     * @param  string $format format string array,string or json
     */
    public function setFormat($format = 'array') {
        $this->format = $format;
    }

    /**
     * Return time.
     */
    public function Time() {
        return microtime(true);
    }

    /**
     * Return memory usage.
     */
    public function Memory() {
        // Not using true so to get actual memory usage.
        return memory_get_usage();
    }

    /**
     * Return average server load.
     */
    public function ServerLoad() {
        return sys_getloadavg();
    }

    /**
     * Return usage.
     * @param
     *  $format: array or string.
     * @return
     *  Result of calling getrusage() in form of an array or a string.
     */
    public function Usage($format = 'array') {
        // Return array by default.
        $data = '';
        switch ($this->format) {
            case 'array':
                $data = getrusage();
                break;
            case 'string':
                $data = str_replace('&', ', ', http_build_query(getrusage()));
                break;
            case 'json':
                $data = json_encode(getrusage());
                break;
        }
        return $data;
    }

    /**
     * Set time by label.
     */
    protected function SetTime($label = NULL) {
        $label = $label ? $label . '_time' : 'SetTime';
        $this->$label = $this->Time();
    }

    /**
     * Set usage by label.
     */
    protected function SetUsage($label = NULL, $format = NULL) {
        $label = $label ? $label . '_usage' : 'SetUsage';
        $this->$label = $this->Usage($format);
    }

    /**
     * Set memory by label.
     */
    protected function SetMemory($label = NULL) {
        $label = $label ? $label . '_memory' : 'SetMemory';
        $this->$label = $this->Memory();
    }

    /**
     * Get peak memory by label.
     */
    protected function SetPeakMemory($label = NULL) {
        $label = $label ? $label . '_peak_memory' : 'GetPeakMemory';
        $this->$label = memory_get_peak_usage();
    }

    /**
     * Set a step for benchmarking.
     */
    public function Step($label = NULL, $format = NULL) {
        $this->SetTime($label);
        $this->SetUsage($label, $format);
        $this->SetMemory($label);
        $this->SetPeakMemory($label);
    }

    /**
     * Get time difference.
     */
    protected function TimeDiff($plabel, $slabel) {
        // Get values.
        $plabel = $plabel . '_time';
        $slabel = $slabel . '_time';
        return $this->$slabel - $this->$plabel;
    }

    /**
     * Get usage difference.
     */
    protected function UsageDiff($plabel, $slabel) {
        // Get values.
        $plabel = $plabel . '_usage';
        $slabel = $slabel . '_usage';
        return $this->GetrusageDiff($this->$plabel, $this->$slabel);
    }

    /**
     * Get memory usage difference.
     */
    protected function MemoryDiff($plabel, $slabel) {
        // Get values.
        $plabel = $plabel . '_memory';
        $slabel = $slabel . '_memory';
        // Return value in MB.
        return ($this->$slabel - $this->$plabel) / 1024 / 1024;
    }

    /**
     * Get memory peak usage.
     */
    protected function GetPeakMemory($label) {
        $label = $label . '_peak_memory';
        return $this->$label / 1024 / 1024;
    }

    /**
     * Get stats.
     * @param
     *  $plabel: Primary label. Should be set prior to secondary label.
     * @param
     *  $slabel: Secondary label. Should be set after primary label.
     */
    public function CheckGati($plabel, $slabel) {
        try {
            $time = $usage = NULL;
            $time = $this->TimeDiff($plabel, $slabel);
            //$usage = $this->UsageDiff($plabel, $slabel);
            $usage = null;
            $memory = $this->MemoryDiff($plabel, $slabel);
            $peak_memory = $this->GetPeakMemory($slabel);

            return array(
                'time' => $time,
                'usage' => $usage,
                'memory' => $memory,
                'peak_memory' => $peak_memory,
            );
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Get stats.
     * @param
     *  $plabel: Primary label. Should be set prior to secondary label.
     * @param
     *  $slabel: Secondary label. Should be set after primary label.
     */
    public function Report($plabel, $slabel) {
        try {
            $array = array();
            // Get server load in last minute.
            $load = $this->ServerLoad();
            // Get results.
            $results = $this->CheckGati($plabel, $slabel);
            // Prepare array.
            $array['O tempo do relógio em segundos'] = $results['time'];
            $array['Tempo gasto no modo de usuário em segundos'] = $results['usage']['ru_utime.tv'];
            $array['Tempo gasto no modo de sistema, em segundos'] = $results['usage']['ru_stime.tv'];
            $array['Tempo total em Kernel em segundos'] = $results['usage']['ru_stime.tv'] + $results['usage']['ru_utime.tv'];
            $array['Limite de memória em MB'] = str_replace('M', '', ini_get('memory_limit'));
            $array['O uso de memória em MB'] = $results['memory'];
            $array['Uso de memória de pico em MB'] = $results['peak_memory'];
            $array['Carga do servidor média no último minuto'] = $load['0'];
            $array['Residente de tamanho máximo compartilhado em KB'] = $results['usage']['ru_maxrss'];
            return $array;
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Get difference of arrays with keys intact.
     */
    private function GetrusageDiff($arr1, $arr2) {
        $array = array();
        // Add user mode time.
        $arr1['ru_utime.tv'] = ($arr1['ru_utime.tv_usec'] / 1000000) + $arr1['ru_utime.tv_sec'];
        $arr2['ru_utime.tv'] = ($arr2['ru_utime.tv_usec'] / 1000000) + $arr2['ru_utime.tv_sec'];
        // Add system mode time.
        $arr1['ru_stime.tv'] = ($arr1['ru_stime.tv_usec'] / 1000000) + $arr1['ru_stime.tv_sec'];
        $arr2['ru_stime.tv'] = ($arr2['ru_stime.tv_usec'] / 1000000) + $arr2['ru_stime.tv_sec'];

        // Unset time splits.
        unset($arr1['ru_utime.tv_usec']);
        unset($arr1['ru_utime.tv_sec']);
        unset($arr2['ru_utime.tv_usec']);
        unset($arr2['ru_utime.tv_sec']);
        unset($arr1['ru_stime.tv_usec']);
        unset($arr1['ru_stime.tv_sec']);
        unset($arr2['ru_stime.tv_usec']);
        unset($arr2['ru_stime.tv_sec']);

        // Iterate over values.
        foreach ($arr1 as $key => $value) {
            $array[$key] = $arr2[$key] - $arr1[$key];
        }
        return $array;
    }

}
