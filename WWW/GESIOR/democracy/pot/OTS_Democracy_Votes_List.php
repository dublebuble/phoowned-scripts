<?php
class OTS_Democracy_Votes_List extends OTS_Base_List
{
    public function init()
    {
        $this->table = 'p_democracy_votes';
        $this->class = 'Democracy_Vote';
    }
}
?>