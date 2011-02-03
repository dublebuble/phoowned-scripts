<?php
class OTS_Democracy_Votings_List extends OTS_Base_List
{
    public function init()
    {
        $this->table = 'p_democracy';
        $this->class = 'Democracy_Voting';
    }
}
?>