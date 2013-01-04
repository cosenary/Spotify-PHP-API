# Spotify PHP API #

## About ##

A simple static PHP wrapper for Spotify's Metadata API.  
Your feedback is always welcome.

## Requirements ##

- PHP 5.2.x or higher
- cURL

## Get started ##

### Setup class and search for an Artist ###

```php
<?php
    require_once 'spotify.class.php';
        
    // Search for an artist by its name
    $artist = Spotify::searchArtist('Maroon 5');
        
    // Take a look at the response
    echo '<pre>';
    print_r($artist);
    echo '<pre>';
?>
```

### URI Lookup ###

```php
<?php
    // Look up for an artist by its Spotify URI
    Spotify::lookup('spotify:artist:58lV9VcRSjABbAbfWS6skp', 'album');
?>
```

### Generate Spotify URI ###

```php
<?php
    // Search for a track
    $track = Spotify::searchTrack('Narcotic');
        
    // Receive the Spotify URI for the first track
    $uri = Spotify::getUri($track); // spotify:track:6MSPmHR15vgpa0A5L205Xv
        
    // Display Spotify link (opens Spotify player)
    echo "<a href="/{$uri}"/>Play Song with Spotify</a>";
?>
```

**All methods return the API data `json_decode()` - so you can directly access the data.**

## Available methods ##

### Search methods ###

- `searchArtist($name, <$page>)`
- `searchAlbum($title, <$page>)`
- `searchTrack($title, <$page>)`

All `<$page>` parameters are optional. If the page number is undefined, the first one will be returned *(default)*.

> [Sample responses of the Search Endpoints.](https://github.com/cosenary/Spotify-PHP-API/wiki/Search-endpoints)

### Lookup method ###

- `lookup($uri, <$detail>)`
  - `$uri` is a valid Spotify URI like: `spotify:artist:58lV9VcRSjABbAbfWS6skp`, `spotify:track:4I4BS0OeI7VZdo5WeEQHFP`
     - the URI type will be automatically detected
  - `$detail` defines the detail level in the response. Possible options are:
     - Artist: `album`, `albumdetail`
     - Album: `track`, `trackdetail`
     - Track: `no detail level available`
- `getUri($obj, <$count>)`
  - `$obj` is a JSON object returned by one of the search methods
  - `$count` *[optional]* number of result (first result = 0 *[default]*)

> [Sample responses of the Lookup Endpoints.](https://github.com/cosenary/Spotify-PHP-API/wiki/Lookup-endpoints)

If you need additional informations, take a look at [Spotify's API docs](https://developer.spotify.com/technologies/web-api/).

## History ##

**Spotify 1.2 - 04/01/2013**

- `bug` Fixed undeclared static property error
- `update` Updated Spotify API doc URLs

**Spotify 1.1 - 12/12/2011**

- `feature` Changed class to static methods
- `update` Adjusted documentation
- `change` Removed default constructor

**Spotify 1.0 - 27/11/2011**

- `release` First official released version
- `feature` Added `getUri()` method
- `update` Detailed documentation

**Spotify 0.5 - 26/11/2011**

- `release` Beta version
- `update` Small documentation

## Credits ##

Copyright (c) 2011 - Programmed by Christian Metz  
Released under the [BSD License](http://www.opensource.org/licenses/bsd-license.php).