<h2 id="airHdr">Artists in Residence</h2>
<p>Each year, IMAGINE Crafts selects exceptionally talented artists for the Artists In Residence (AIR) program from a worldwide applicant pool. These artists create hundreds of exceptional artworks each year with video and written instructions posted on our website and blog. Our AIRs embody a variety of different aesthetics, from CAS (cute and simple) cards to dynamic 3D mixed media pieces. Their innovative projects will spark your creativity.</p>

<p>Meet our current AIRs team:</p>

<?php

$qry = "SELECT * FROM artists JOIN content ON artists.CONTENT_ID=content.ID WHERE artists.ACTIVE='1' ORDER BY artists.LAST_NAME ASC, artists.FIRST_NAME ASC";
$res = mysql_query($qry) or die(mysql_error());
$totalArtists = mysql_num_rows($res);

if ($totalArtists > 0) {

  // determine half-way point
  if ($totalArtists % 2 == 0) {
    $firstHalf = $totalArtists / 2;
    $secondHalf = $totalArtists / 2;  
  }
  else {
    $firstHalf = ceil($totalArtists / 2);
    $secondHalf = floor($totalArtists / 2);  
  }

  $dataArr = array();
  while ($data = mysql_fetch_assoc($res)) {
    $dataArr[]= $data;
  }

  echo '<div class="artistCol"><ul>';
  for ($i=0; $i<$firstHalf; $i++) {
    echo '<li><a href="/', $dataArr[$i]['MOD_NAME'], '">', $dataArr[$i]['COMPLETE_NAME'], '</a></li>';
  }
  echo '</ul></div>';
  
  echo '<div class="artistCol"><ul>';
  for ($i=0; $i<$secondHalf; $i++) {
    echo '<li><a href="/', $dataArr[$i + $firstHalf]['MOD_NAME'], '">', $dataArr[$i + $firstHalf]['COMPLETE_NAME'], '</a></li>';
  }
  echo '</ul></div>';  

}

?>

<div class="clr"></div>

<h2 id="icBlogHdr" class="communityHdr">IMAGINE Crafts Blog</h2>
AIRS projects are debuted on the <a href="http://imaginecraftsblog.com">IMAGINE Crafts Blog</a>. A new project is posted each day.  <a href="http://imaginecrafts.us7.list-manage.com/subscribe?u=39123d10fce8c075189e0eb4e&id=157580261d">Sign up here.</a>

<h2 id="stayConnectedHdr" class="communityHdr">Stay Connected</h2>
With so many ways to keep up with the latest activity, you'll never be at a loss for inspiration!<br />
<a href="http://www.facebook.com/pages/Imagine-Crafts-Tsukineko/242875492467397" target="_blank">Facebook</a> - project updates and frequent giveaways<br />
<a href="http://www.pinterest.com/imaginecrafts/" target="_blank">Pinterest</a> - inspiration from all over the web<br />
<a href="https://www.twitter.com/Imagine_Crafts" target="_blank">Twitter</a> - the latest news<br />
<a href="http://www.youtube.com/user/ImagineCraftsvideos" target="_blank">YouTube</a> and <a href="https://vimeo.com/imaginecrafts/" target="_blank">Vimeo</a> - step-by-step video instruction
