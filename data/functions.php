<?php
require('counties.php');
require('../config.php');

/**
 * Get JSON
 * @return json
 */
function get_json() {
  $file = '../cache/cache.json';
  $current_time = time();
  $expire_time = 86400;

  /**
   * Check if we have a cached version of the file and return it
   * if it is not more than a day old.
   */
  if (file_exists($file)) {
    $file_time = filemtime($file);
    $time_difference = $current_time - $expire_time;
    if ($time_difference < $file_time) {
      return file_get_contents($file);
    }
  }

  $json = create_json();
  file_put_contents($file, $json);
  return $json;
}

/**
 * Get JSON
 * @return json
 */
function get_mailings_json() {
  $file = '../cache/mailings.json';

  if (file_exists($file)) {
    return file_get_contents($file);
  }

  $json = create_mailings_json();
  file_put_contents($file, $json);
  return $json;
}

/**
 * Get HTML from Florida from local cache, or remote server
 * @return string HTML Content
 */
function get_html() {
  $file = '../cache/cache.html';
  $current_time = time();
  $expire_time = 86400;

  /**
   * Check if we have a cached version of the file and return it
   * if it is not more than a day old.
   */
  if (file_exists($file)) {
    $file_time = filemtime($file);
    $time_difference = $current_time - $expire_time;
    if ($time_difference < $file_time) {
      return file_get_contents($file);
    }
  }

  /**
   * This website seems a little unstable regarding uptime, so here we are
   * going to first try to download a new copy of the data if the cache is
   * expired above.  But should we fail to connect, just fall back on the
   * last succesful download we did have
   */
  $html = file_get_contents('http://dos.elections.myflorida.com/initiatives/initSignDetailCounty.asp?account=64388&seqnum=1&ctype=CSV&elecyear=2018');

  if ($html) {
    file_put_contents($file, $html);
    return $html;
  } else if (file_exists($file)) {
    return file_get_contents($file);
  }
}

/**
 * Convert HTML to JSON & cache it
 * @return sting
 */
function create_json() {
  global $county_map_data;

  $html = get_html();
  $doc = new DOMDocument();

  libxml_use_internal_errors(TRUE);

  if (!empty($html)) {

  	$doc->loadHTML($html);
  	libxml_clear_errors();

  	$xpath = new DOMXPath($doc);
    $data = array(
      'summary' => array(
        'review_needed' => 0,
        'review_total' => 0,
        'review_percent' => 0,
        'review_success' => FALSE,
        'ballot_needed' => 0,
        'ballot_total' => 0,
        'ballot_percent' => 0,
        'ballot_success' => FALSE
      ),
      'counties' => $county_map_data,
      'districts' => array(),
      'map_data' => array()
    );

  	// Get all Districts from HTML
  	$districts = $xpath->query('//center //center');

  	if ($districts->length > 0) {
  		foreach ($districts as $row) {
        $text = trim(preg_replace('/\s+/', ' ', $row->nodeValue));
        preg_match('/DISTRICT ([0-9]{1,2}) Needed for Review ([0-9,]+) Needed for Ballot ([0-9,]+)/', $text, $matches);

        if (count($matches) === 4) {
          $district = intval(str_replace(',', '', $matches[1]));
          $review = intval(str_replace(',', '', $matches[2]));
          $ballot = intval(str_replace(',', '', $matches[3]));

          $data['districts'][] = array(
            'district' => $district,
            'review' => $review,
            'review_percent' => 0,
            'review_success' => FALSE,
            'ballot' => $ballot,
            'ballot_percent' => 0,
            'ballot_success' => FALSE
          );

          $data['summary']['review_needed'] += $review;
          $data['summary']['ballot_needed'] += $ballot;
        }
  		}
  	}

    // Get all Counties from HTML
  	$counties = $xpath->query('//center //table');

    if ($counties->length > 0) {
      $current_district = 0;
      foreach ($counties as $county_row) {
        $county_text = trim(preg_replace('/\s+/', ' ', $county_row->nodeValue));
        $county_text = str_replace('COUNTY ValidSignatures ', '', $county_text);
        $county_text = str_replace('COUNTY ValidSignatures ', '', $county_text);
        $county_text = str_replace('STATE ValidSignatures TOTAL ', '', $county_text);
        $county_text = str_replace('(Pre-Redistricting)', '', $county_text);
        $county_text = preg_replace('/&nbsp/', '', $county_text);
        $county_text = preg_replace('/ \(as of [0-9]{2}\/[0-9]{2}\/[0-9]{4}\)/', '', $county_text);

        preg_match_all('/([^0-9]+) ([0-9,]+)/', $county_text, $county_matches);

        if (count($county_matches) === 3 && count($county_matches[0]) > 0) {
          for ($i = 0; $i < count($county_matches[0]); $i++) {
            $slug = slugify($county_matches[1][$i]);

            if ($slug !== 'total' && $slug !== 'state-validsignatures-total') {
              $count = intval(str_replace(',', '', $county_matches[2][$i]));
              $data['districts'][$current_district]['total'] += $count;

              $data['summary']['review_total'] += $count;
              $data['summary']['ballot_total'] += $count;

              $data['counties'][$slug]['signatures'] += $count;
            }
          }

          // Update District Totals
          $district_total = $data['districts'][$current_district]['total'];
          $district_review = $data['districts'][$current_district]['review'];
          $district_ballot = $data['districts'][$current_district]['ballot'];

          $district_review_percent = ($district_review > 0) ? round(($district_total / $district_review) * 100, 2) : 0;
          $district_ballot_percent = ($district_ballot > 0) ? round(($district_total / $district_ballot) * 100, 2) : 0;

          $data['districts'][$current_district]['review_percent'] = $district_review_percent;
          $data['districts'][$current_district]['ballot_percent'] = $district_ballot_percent;

          $data['districts'][$current_district]['review_success'] = ($district_review_percent >= 100);
          $data['districts'][$current_district]['ballot_success'] = ($district_ballot_percent >= 100);

          $current_district++;
        }
      }

      // Update Summary totals
      $review_total = $data['summary']['review_total'];
      $review_needed = $data['summary']['review_needed'];

      $ballot_total = $data['summary']['ballot_total'];
      $ballot_needed = $data['summary']['ballot_needed'];

      $review_percent = ($review_needed > 0) ? round(($review_total / $review_needed) * 100, 2) : 0;
      $ballot_percent = ($ballot_needed > 0) ? round(($ballot_total / $ballot_needed) * 100, 2) : 0;

      $data['summary']['review_percent'] = $review_percent;
      $data['summary']['ballot_percent'] = $ballot_percent;

      $data['summary']['review_success'] = ($review_percent >= 100);
      $data['summary']['ballot_success'] = ($ballot_percent >= 100);
    }

    // Update `map_data` for `highcharts` maps
    foreach ($data['counties'] as $county_map) {
      $data['map_data'][] = array($county_map['code'], $county_map['signatures']);
    }

    /**
     * Sanity Check to make sure we parsed HTML correctly, otherwise
     * we could accidently overwrite our JSON file with incorrect data
     */
    if ($data['summary']['review_needed'] > 0 && $data['summary']['ballot_needed'] > 0) {
      return json_encode($data, JSON_PRETTY_PRINT);
    } else {
      return json_encode(array('error' => 'Unable to Generate JSON File'), JSON_PRETTY_PRINT);
    }
  }
}

/**
 * Fetch ZipCodes Mailers
 * @return sting
 */
function create_mailings_json() {
  $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname='.DB_NAME, DB_USER, DB_PASS);
  $mailings = $pdo->query("SELECT `a`.`zipcode`, COUNT(`a`.`id`) as 'count', `z`.`latitude` AS latitude, `z`.`longitude` AS longitude FROM `address_list` a LEFT JOIN `zipcode` z ON `a`.`zipcode` = `z`.`zipcode` WHERE `a`.`mailed` = 1 GROUP BY `a`.`zipcode`, `z`.`latitude`, `z`.`longitude`")->fetchAll(PDO::FETCH_ASSOC);

  $total = 0;
  $data = array();
  foreach ($mailings as $row) {
    $total += intval($row['count'], 10);
    if ($row['latitude'] && $row['longitude']) {
      $data[] = array(
        'zipcode' => $row['zipcode'],
        'count' => intval($row['count'], 10),
        'z' => intval($row['count'], 10),
        'lat' => $row['latitude'],
        'lon' => $row['longitude']
      );
    }
  }

  return json_encode(array('total' => $total, 'zipcodes' => $data), JSON_PRETTY_PRINT);
}

/**
 * Create Slug from Text
 * @param  string $text
 * @return string
 */
function slugify($text) {

  $text = preg_replace('~[^\pL\d]+~u', '-', $text);
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  $text = preg_replace('~[^-\w]+~', '', $text);
  $text = trim($text, '-');
  $text = preg_replace('~-+~', '-', $text);
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}
