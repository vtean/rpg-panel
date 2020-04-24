<?php

class SearchController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function viewmap($x = 0, $y = 0)
    {
        if ($x === 0 || $y === 0) {
            $this->error('404', 'Page Not Found!');
        } else {
            $imgPath = ROOT_PATH . '/public/resources/img/map.jpg';
            $img = imagecreatefromjpeg($imgPath);
            $checkpoint = imagecolorallocate($img, 255, 0, 0);

            $x = $x/7.5;
            $y = $y/7.5;

            $x = $x + 400;
            $y = -($y - 400);

            imagefilledrectangle($img, $x, $y, $x+10, $y + 10, $checkpoint);

            header('Content-Type: image/png');
            imagepng($img);
            imagedestroy($img);
        }
    }

    public function map($x = 0, $y = 0) {
        if ($x === 0 || $y === 0) {
            $this->error('404', 'Page Not Found!');
        } else {
            $imgUrl = BASE_URL . '/search/viewmap/' . $x . '/' . $y;

            $data = [
                'pageTitle' => 'Map',
                'imgUrl' => $imgUrl
            ];

            // load view
            $this->loadView('map', $data);
        }
    }
}