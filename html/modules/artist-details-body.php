<?php

$qry = "SELECT * FROM artists WHERE ACTIVE='1' AND CONTENT_ID='" . $content['ID'] . "'";
$res = mysql_query($qry) or die(mysql_error());
$data = mysql_fetch_assoc($res);

if (!empty($data)) {

  $projectExists = false;

  if (!empty($data['PROJECT1_PHOTO'])) {
  
    $imgPath = "images/artists/" . $data['ARTIST_ID'] . '/project1/' . $data['PROJECT1_PHOTO'];
    if (file_exists($imgPath)) {
      echo '<div class="projectImg"><img src="', $imgPath, '" alt="Project by ', $data['COMPLETE_NAME'], '" /></div>';
      $projectExists = true;
    }
  
  }

  if (!empty($data['PROJECT2_PHOTO'])) {
  
    $imgPath = "images/artists/" . $data['ARTIST_ID'] . '/project2/' . $data['PROJECT2_PHOTO'];
    if (file_exists($imgPath)) {
      echo '<div class="projectImg"><img src="', $imgPath, '" alt="Project by ', $data['COMPLETE_NAME'], '" /></div>';
      $projectExists = true;
    }
  
  }

  if (!empty($data['PROJECT3_PHOTO'])) {
  
    $imgPath = "images/artists/" . $data['ARTIST_ID'] . '/project3/' . $data['PROJECT3_PHOTO'];
    if (file_exists($imgPath)) {
      echo '<div class="projectImg"><img src="', $imgPath, '" alt="Project by ', $data['COMPLETE_NAME'], '" /></div>';
      $projectExists = true;
    }
  
  }

  if ($projectExists) {
  
    echo '<div class="clr"></div>';
  
  }

  echo '<h1>', $data['COMPLETE_NAME'], '</h1>';
  
  if (!empty($data['ARTIST_PHOTO'])) {
  
    $imgPath = "images/artists/" . $data['ARTIST_ID'] . '/' . $data['ARTIST_PHOTO'];
    if (file_exists($imgPath)) {
      echo '<div class="artistImg"><img src="', $imgPath, '" alt="', $data['COMPLETE_NAME'], '" /></div>';
    }
  
  }  
  
  echo '<div class="artistBio">', $data['DETAILS'], '</div>';
  
}

echo '<div class="clr"></div>';

?>