<?php

/* predefined constants */
define("DEWPLAYER", 1);
define("DEWPLAYER_MINI", 2);
define("DEWPLAYER_MULTI", 3);

/**
 * Returns a playlist from the given mixed (could be a string or an array)
 *
 * @param mixed $files
 *
 * @return string
 */
function _get_playlist($files)
{
  $playlist = "";
  if (is_array($files))
  {
    foreach ($files as $file)
    {
      $playlist .= $file."|";
    }
    $playlist = substr($playlist, 0, -1);
  }
  else
  {
    $playlist = $files;
  }

  return $playlist;
}

/**
 * Returns a parameter from the given option and value.
 *
 * @param string $option
 * @param mixed $value could be a boolean or a string
 *
 * @return string
 */
function _get_dewplayer_param($option, $value)
{
  if ($value === true)
  {
    $value = 1;
  }
  else if ($value === false)
  {
    $value = 0;
  }
  else
  {
    $value = $value;
  }
  return "&$option=$value";
}

/**
 * Returns a player url from a given type
 *
 * @param int $type A constant: DEWPLAYER || DEWPLAYER_MINI || DEWPLAYER_MULTI
 *
 * @return string
 */
function _get_player($type)
{
  $player = "";
  switch($type)
  {
    case DEWPLAYER:
      $player .= "dewplayer";
    break;
    case DEWPLAYER_MINI:
      $player .= "dewplayer-mini";
    break;
    case DEWPLAYER_MULTI:
      $player .= "dewplayer-multi";
    break;
  }

  $player .= ".swf";

  return public_path("/pmDewplayerPlugin/$player");
}

/**
 * Returns the selected player width from the given type
 *
 * @param int $type A constant: DEWPLAYER || DEWPLAYER_MINI || DEWPLAYER_MULTI
 *
 * @return string
 */
function _get_player_width($type)
{
  $ret = "";

  switch($type)
  {
    case DEWPLAYER:
      $ret = "200";
    break;
    case DEWPLAYER_MINI:
      $ret = "160";
    break;
    case DEWPLAYER_MULTI:
      $ret = "240";
    break;
  }

  return $ret;
}

/**
 * Returns the player specified by $type
 *
 * @param int $type A constant: DEWPLAYER || DEWPLAYER_MINI || DEWPLAYER_MULTI
 * @param mixed $files Could be a string (only one file) or an array (multiple files)
 * @param array $options Options for dewplayer
 *
 * @return string
 */
function _dewplayer_common($type, $files, $options = array())
{
  $playlist_string = _get_playlist($files);

  $params = "";
  foreach ($options as $option => $value)
  {
    $params .= _get_dewplayer_param($option, $value);
  }

  $player = _get_player($type)."?mp3=$playlist_string".$params;

  $html = tag("object", array("height" => 20, "width" => _get_player_width($type), "data" => $player, "type" => "application/x-shockwave-flash"), true);

  $html .= content_tag("param", null, array("name" => "movie", "value" => $player));

  $html .= tag("/object", null, false);

  return $html;
}

/**
 * Returns a dewplayer
 *
 * @param mixed $files Could be a string (only one file) or an array (multiple files)
 * @param array $options Options for dewplayer
 *
 * @return string
 */
function dewplayer($files, $options = array())
{
  return _dewplayer_common(DEWPLAYER, $files, $options);
}

/**
 * Returns a dewplayer (mini version)
 *
 * @param mixed $files Could be a string (only one file) or an array (multiple files)
 * @param array $options Options for dewplayer
 *
 * @return string
 */
function dewplayer_mini($files, $options = array())
{
  return _dewplayer_common(DEWPLAYER_MINI, $files, $options);
}

/**
 * Returns a dewplayer (multi version)
 *
 * @param mixed $files Could be a string (only one file) or an array (multiple files)
 * @param array $options Options for dewplayer
 *
 * @return string
 */
function dewplayer_multi($files, $options = array())
{
  return _dewplayer_common(DEWPLAYER_MULTI, $files, $options);
}
