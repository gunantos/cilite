<?php
namespace appkita\cilite\models;

class InfoServerModel extends Models {
    public string $ip_address;
    public string $ram;
    public string $hdd;
    public int $bandwidth = 0;
    public string $username;
    public string $password;
}