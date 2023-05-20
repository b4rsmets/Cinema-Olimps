<?php

namespace models;

class api
{
    function apiMovie()
    {
        $idKp = 566;
        $url = file_get_contents("https://api.kinopoisk.dev/v1/movie/$idKp?token=0QXFJ1B-0GR4ZVZ-P3A4H88-7RP9J1W");
        $content = json_decode($url, true);

        $filteredContent = array(
            'id' => $content['id'],
            'name' => $content['name'],
            'year' => $content['year'],
            'description' => $content['description'],
            'genres' => $content['genres']['0']['name'],
            'countries' => $content['countries']['0']['name'],
            'poster' => $content['poster']['url'],
            'kpRating' => substr($content['rating']['kp'], 0, 3),
            'age' => $content['ageRating']
        );
        $imagePath = 'img/'.$filteredContent['id'].'.jpg';
        if (!file_exists($imagePath)) {
            $imageContent = file_get_contents($filteredContent['poster']);
            file_put_contents($imagePath, $imageContent);
        }
        return $filteredContent;
    }

}