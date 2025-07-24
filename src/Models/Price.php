<?php

namespace App\Models;

class Price
{
    public int $id;
    public int $commodity_id;
    public float $price;
    public int $season;
}
