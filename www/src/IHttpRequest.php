<?php
namespace App;
interface IHttpRequest
{
    /**
     * send get request
     * @param url - string type of url
     * @param data - array type of params
     * @param contentType - string type of content type
     */
    public function send($url, $data, $contentType);
    public function getJson();
    public function getString();
    public function getRaw();
    public function getHeader(string $name);
}