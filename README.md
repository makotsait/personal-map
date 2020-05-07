# PersonalMap
Personal Map is a web application which lets you to make notes of a place, rate it, and review your impressions about it. This app makes it easier to make notes of a place that was shown on TV, or that you visited.

### Features
* Writing anything you want since your notes will not be published.
* Rating for specific criteria for each place type.
* Review all the places you have made notes at once with pins on the map.

### Upcoming features
* Filtering your posts by ratings, or tags.
* Searching your notes by words.

# Usage
## Set your google api key
Rename "../.env.example" to "../.env".<br>
Open file "../.env" and add your API Key.<br>
If you don't have google api keys, get them from [here](https://cloud.google.com/maps-platform).
```
GOOGLE_API_KEY_JS  = YOUR_API_KEY_HERE
GOOGLE_API_KEY_PHP = YOUR_API_KEY_HERE
```
If you'd like to use this app just for yourself, using same api key for GOOGLE_API_KEY_JS and GOOGLE_API_KEY_PHP works for you. If you'd like to let other people use this app on your server, getting a GOOGLE_API_KEY_JS which has a restriction with http referer and a GOOGLE_API_KEY_PHP with no restriction is recommended.

## Create DB and seed initial values
Rename "../database/database.sqlite.example" to "../database/database.sqlite".<br>
Execute the following command from the command line. 
```sh
>> php artisan migrate --seed
```

## Change setting on APP_ENV
If you use this app on your server and you also want it to use https in every access, all you need to do is to rewrite "../.env".<br>
Find the following line in ".env".
```
APP_ENV=local
```
Substitute "local" to "production".
```
APP_ENV=production
```

# Technical information
### Languages
PHP, JavaScript, HTML, CSS
### Frameworks
Laravel
### Libraries
jQuery, [markerclusterer](https://github.com/googlemaps/v3-utility-library/tree/master/packages/markerclusterer), [jQuery-sidebar](https://github.com/jillix/jQuery-sidebar/)
### APIs
[Google Maps API](https://cloud.google.com/maps-platform/maps), [Google Places API](https://cloud.google.com/maps-platform/places)

# License
Copyright © 2020 makotsait All rights reserved.
Distribution or commercial use of this program or a copy of this program are prohibited. License terms will be changed later.
