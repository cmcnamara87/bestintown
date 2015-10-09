<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address');
            $table->double('latitude');
            $table->double('longitude');
            $table->string('rating');
            $table->integer('city_id');
            $table->timestamps();
        });
        /*
        is_claimed: true,
rating: 4.5,
mobile_url: "http://m.yelp.com.au/biz/pizza-caffe-st-lucia",
rating_img_url: "http://s3-media2.fl.yelpcdn.com/assets/2/www/img/99493c12711e/ico/stars/v1/stars_4_half.png",
review_count: 17,
name: "Pizza Caffe",
snippet_image_url: "http://s3-media1.fl.yelpcdn.com/photo/uawWv26Vxhc3u6-dCbMAVA/ms.jpg",
rating_img_url_small: "http://s3-media2.fl.yelpcdn.com/assets/2/www/img/a5221e66bc70/ico/stars/v1/stars_small_4_half.png",
url: "http://www.yelp.com.au/biz/pizza-caffe-st-lucia",
phone: "+61733772239",
snippet_text: "I remember loving the pizzas here here many many moons ago when I was a young, poverty stricken teenager, content surviving on Mi Goreng noodles. Now that...",
image_url: "http://s3-media2.fl.yelpcdn.com/bphoto/FVJ90xtiNcwWyMi_p35uvQ/ms.jpg",
categories: [
        [
            "Pizza",
            "pizza"
        ],
        [
            "Italian",
            "italian"
        ]
    ],
display_phone: "+61 7 3377 2239",
rating_img_url_large: "http://s3-media4.fl.yelpcdn.com/assets/2/www/img/9f83790ff7f6/ico/stars/v1/stars_large_4_half.png",
id: "pizza-caffe-st-lucia",
is_closed: false,
location: {
        city: "St Lucia",
display_address: [
            "University of Queensland",
            "Union Rd",
            "St Lucia",
            "St Lucia Queensland 4067",
            "Australia"
        ],
geo_accuracy: 9.5,
neighborhoods: [
            "St Lucia"
        ],
postal_code: "4067",
country_code: "AU",
address: [
            "University of Queensland",
            "Union Rd"
        ],
coordinate: {
            latitude: -27.4971190190203,
longitude: 153.01596578372
},
state_code: "QLD"
}
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('places');
    }
}
