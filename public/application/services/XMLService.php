<?php

class XMLService extends Service
{
    /**
     * @param $file
     * @return false|mixed
     */
    public function parseXml($file)
    {
        $imageFileType = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
        if (file_exists($file['tmp_name'])) {
            if ($imageFileType === 'xml') {
                return $this->getXMLAsArray($file['tmp_name']);
            }
        }

        return false;
    }

    /**
     * @param $path
     * @return $1|false|SimpleXMLElement
     */
    private function getXmlObject($path)
    {
        return simplexml_load_string(file_get_contents($path));
    }

    /**
     * @param $path
     * @return mixed
     */
    private function getXMLAsArray($path)
    {
        $encoded = json_encode($this->getXmlObject($path));

        return json_decode($encoded, true);
    }
}