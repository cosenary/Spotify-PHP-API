<?php

/**
 * Spotify Metadata API class
 * API Documentation: https://developer.spotify.com/technologies/web-api/
 * Class Documentation: https://github.com/cosenary/Spotify-PHP-API
 * 
 * @author Christian Metz
 * @since 26.11.2011
 * @copyright Christian Metz - MetzWeb Networks
 * @version 1.2
 * @license BSD http://www.opensource.org/licenses/bsd-license.php
 */

class Spotify {

  /**
   * The API base URL
   * 
   * @var string
   */
  const API_URL = 'http://ws.spotify.com';

  /**
   * Available detail parameters of the lookup method
   * 
   * @var array
   */
  private static $_extras = array('album', 'albumdetail', 'track', 'trackdetail');

  /**
   * Search a Artist by its name
   * 
   * @param string $name                  Name of an artist
   * @param integer [optional] $page      Page number
   * @return mixed
   */
  public static function searchArtist($name, $page = 1) {
    return self::_makeCall('/search/1/artist', array('q' => $name, 'page' => $page));
  }

  /**
   * Search a Album by its name
   * 
   * @param string $title                 Title of a album
   * @param integer [optional] $page      Page number
   * @return mixed
   */
  public static function searchAlbum($title, $page = 1) {
    return self::_makeCall('/search/1/album', array('q' => $title, 'page' => $page));
  }

  /**
   * Search a Track by its name
   * 
   * @param string $title                 Title of a track
   * @param integer [optional] $page      Page number
   * @return mixed
   */
  public static function searchTrack($title, $page = 1) {
    return self::_makeCall('/search/1/track', array('q' => $title, 'page' => $page));
  }

  /**
   * Looks up for more details
   * 
   * @param string $uri                   Valid Spotify URI
   * @param string [optional] $detail     Detail level of the response
   * @return mixed
   */
  public static function lookup($uri, $detail = null) {
    $params = array('uri' => $uri);
    if (isset($detail) && in_array($detail, self::$_extras)) {
      $params['extras'] = $detail;
    }
    return self::_makeCall('/lookup/1/', $params);
  }

  /**
   * Returns the Spotify URI
   * 
   * @param object $obj                   JSON object returned by a search method
   * @param integer [optional] $count     (Default first one)
   * @return string
   */
  public static function getUri($obj, $count = 0) {
    if (true === is_object($obj)) {
      $array = self::_objectToArray($obj);
      $type = $array['info']['type'] . 's';
      return $array[$type][$count]['href'];
    } else {
      throw new Exception("Error: getUri() - Requires JSON object returned by a search method.");
    }
  }

  /**
   * Convert JSON object to an array
   * 
   * @param object $object                The object to convert
   * @return array
   */
  private static function _objectToArray($object) {
    if (!is_object($object) && !is_array($object)) {
      return $object;
    }
    if (is_object($object)) {
      $object = get_object_vars($object);
    }
    return array_map(array(self, '_objectToArray'), $object);
  }

  /**
   * The call operator
   *
   * @param string $function              API resource path
   * @param array $params                 Request parameters
   * @return mixed
   */
  private static function _makeCall($function, $params) {
    $params = '.json?' . utf8_encode(http_build_query($params));
    $apiCall = self::API_URL.$function.$params;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiCall);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    
    $jsonData = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($jsonData);
  }

}