<?php

class Mecab
{
    var $mecab_path = PATH_MECAB;

    private function buildCommand($options)
    {
        $command = $this->mecab_path;
        foreach ($options as $key => $value) {
            $command .= sprintf(' %s %s', $key, escapeshellarg($value));
        }
        return $command;
    }

    public function execute($sentence, $options)
    {
        $command = $this->buildCommand($options);
        $command = sprintf('echo \'%s\' | %s', $sentence, $command);
        $ret = exec($command, $output, $ret_code);
        return $output;
    }

    public function parseToNode($sentence, $options)
    {
        $result = $this->execute($sentence, $options);
        $ret = array();
        foreach ($result as $key => $val) {
            if (strpos($val,"\t") !== false) {
                list($surface, $feature) = explode("\t", $val);
                $ret[] = array(
                        'surface' => $surface,
                        'feature' => explode(',', $feature),
                        );
            }
        }
        return $ret;
    }
}

