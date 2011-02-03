<?PHP
#################################################
### Scripted by PhoOwned                      ###
### Contact: phoowned@wp.pl                   ###
###                                           ###
### Democracy - tutors and ST can vote and    ###
### post their ideas                          ###
### version: 0.2 (beta)                       ###
#################################################
/*
In MySQL:
CREATE TABLE `p_democracy` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`state` INT NOT NULL ,
`finish_time` INT NOT NULL ,
`author_id` INT NOT NULL ,
`author_accountid` INT NOT NULL ,
`topic` VARCHAR( 255 ) NOT NULL ,
`text` TEXT NOT NULL ,
INDEX ( `state` , `finish_time` ));
ALTER TABLE `players` ADD `mytutor` INT NOT NULL DEFAULT '0';
CREATE TABLE `p_democracy_votes` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`voting_id` INT NOT NULL ,
`player_id` INT NOT NULL ,
`type` INT NOT NULL ,
`comment` TEXT NOT NULL ,
INDEX ( `voting_id` )
);
*/
    function bb_parse($string) {
        while (preg_match_all('`\[(.+?)=?(.*?)\](.+?)\[/\1\]`', $string, $matches)) foreach ($matches[0] as $key => $match) {
            list($tag, $param, $innertext) = array($matches[1][$key], $matches[2][$key], $matches[3][$key]);
            switch ($tag) {
                case 'b': $replacement = "<strong>$innertext</strong>"; break;
                case 'i': $replacement = "<em>$innertext</em>"; break;
                case 'size': $replacement = "<span style=\"font-size: $param;\">$innertext</span>"; break;
                case 'color': $replacement = "<span style=\"color: $param;\">$innertext</span>"; break;
                case 'center': $replacement = "<div class=\"centered\">$innertext</div>"; break;
                case 'quote': $replacement = "<blockquote>$innertext</blockquote>" . $param? "<cite>$param</cite>" : ''; break;
                case 'url': $replacement = '<a href="' . ($param? $param : $innertext) . "\">$innertext</a>"; break;
                case 'img':
                    list($width, $height) = preg_split('`[Xx]`', $param);
                    $replacement = "<img src=\"$innertext\" " . (is_numeric($width)? "width=\"$width\" " : '') . (is_numeric($height)? "height=\"$height\" " : '') . '/>';
                break;
                case 'video':
                    $videourl = parse_url($innertext);
                    parse_str($videourl['query'], $videoquery);
                    if (strpos($videourl['host'], 'youtube.com') !== FALSE) $replacement = '<embed src="http://www.youtube.com/v/' . $videoquery['v'] . '" type="application/x-shockwave-flash" width="425" height="344"></embed>';
                    if (strpos($videourl['host'], 'google.com') !== FALSE) $replacement = '<embed src="http://video.google.com/googleplayer.swf?docid=' . $videoquery['docid'] . '" width="400" height="326" type="application/x-shockwave-flash"></embed>';
                break;
            }
            $string = str_replace($match, $replacement, $string);
        }
        return $string;
    } 
$groups = array();
$groups['vote'] = 2;
$groups['add_idea'] = 3;
$groups['moderate_idea'] = 4;
$groups['moderate_voting'] = 5;
$active = "117744";
$notactive = "225577";

$players_vote = array();
$players_add = array();
$allow_moderate_idea = false;
$allow_moderate_voting = false;

const STATE_IDEA = 0;
const STATE_VOTING = 1;
const STATE_ACCEPTED = 2;
const STATE_REJECTED = 3;
const STATE_ADDED = 4;

const VOTE_NOTDECIDED = 0;
const VOTE_ACCEPT = 1;
const VOTE_REJECT = 2;

$main_content .= '
	<style>
	.tableHead0 {background-color: #9C5566;text-align: center;vertical-align: middle;}
	.tableHead0:hover {background-color: #4450DD;}
	.tableHead1 {background-color: #990000;text-align: center;vertical-align: middle;}
	.tableHead1:hover {background-color: #945511;}

	.tableRow0 {background-color: #005500;text-align: left;vertical-align: middle;}
	.tableRow0:hover {background-color: #4450DD;}
	.tableRow1 {background-color: #9900CC;text-align: left;vertical-align: middle;}
	.tableRow1:hover {background-color: #945511;}
	</style>';

$state = (int) $_REQUEST['state'];

$main_content .= '<h1><center>sejm</center></h1>';
$main_content .= 'Here Tutors and Senior Tutors can vote.<br />';
$main_content .= '<table cellspacing="0" border="0" width="100%"><tr>';
$main_content .= '<td class="tableHead' . (int)($state == STATE_VOTING) . '" onclick="window.location = \'?subtopic=democracy&state=' . STATE_VOTING . '\'"><h3>VOTINGS</h3></td>';
$main_content .= '<td class="tableHead' . (int)($state == STATE_IDEA) . '" onclick="window.location = \'?subtopic=democracy&state=' . STATE_IDEA . '\'"><h3>IDEAS</h3></td>';
$main_content .= '<td class="tableHead' . (int)($state == STATE_ACCEPTED) . '" onclick="window.location = \'?subtopic=democracy&state=' . STATE_ACCEPTED . '\'"><h3>ACCEPTED</h3></td>';
$main_content .= '<td class="tableHead' . (int)($state == STATE_REJECTED) . '" onclick="window.location = \'?subtopic=democracy&state=' . STATE_REJECTED . '\'"><h3>REJECTED</h3></td>';
$main_content .= '<td class="tableHead' . (int)($state == STATE_ADDED) . '" onclick="window.location = \'?subtopic=democracy&state=' . STATE_ADDED . '\'"><h3>ADDED</h3></td>';
$main_content .= '</tr></table>';

if($action == "") // show main page
{
	$main_content .= '<table cellpadding="0" cellspacing="0" border="0" width="100%">';
	$list = new OTS_Democracy_Votings_List();
    $filter = new OTS_SQLFilter();
    $filter->compareField('state', $state);
    $list->setFilter($filter);
	$list->orderBy('finish_time', POT::ORDER_ASC);
	foreach($list as $row => $voting)
		$main_content .= '<tr class="tableRow' . ($row % 2) . '"><td>' . date('jS F Y h:i:s A', $voting->getFinishTime()) . '</td><td><a href="?subtopic=democracy&action=show&id=' . $voting->getId() . '">' . $voting->getTopic() . '</a><br /><small>by ' . $voting->getAuthor()->getName() . '</small></td></tr>';
	$main_content .= '</table>';
	//link do listy tutorow
}
elseif($action == "show") // show idea or voting
{

}
elseif($action == "vote") // accept, reject, ignore, set 'ready'
{

}
elseif($action == "add") // add idea
{

}
elseif($action == "delete") // delete idea or voting
{

}
?>