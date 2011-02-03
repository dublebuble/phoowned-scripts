<?php
class OTS_Democracy_Vote extends OTS_Row_DAO
{
    private $data = array('voting_id' => 0, 'player_id' => 0, 'type' => 0, 'comment' => '');

    public function create()
    {
        // saves blank voting info
        $this->db->query('INSERT INTO ' . $this->db->tableName('p_democracy_votes') . ' (' . $this->db->fieldName('voting_id') . ', ' . $this->db->fieldName('player_id') . ', ' . $this->db->fieldName('type') . ', ' . $this->db->fieldName('comment') . ') VALUES (0, 0, 0, '');

        // reads created voting's ID
        $this->data['id'] = $this->db->lastInsertId();

        // return name of newly created 
        return $id;
    }

    public function load($id)
    {
        // SELECT query on database
        $this->data = $this->db->query('SELECT ' . $this->db->fieldName('id') . ', ' . $this->db->fieldName('voting_id') . ', ' . $this->db->fieldName('player_id') . ', ' . $this->db->fieldName('type') . ', ' . $this->db->fieldName('comment') . ' FROM ' . $this->db->tableName('p_democracy_votes') . ' WHERE ' . $this->db->fieldName('id') . ' = ' . (int) $id)->fetch();
    }

    public function find($name)
    {
        // SELECT query on database
		$this->load($name);
    }

    public function isLoaded()
    {
        return isset($this->data['id']);
    }

    public function save()
    {
        if( !isset($this->data['id']) )
        {
            throw new E_OTS_NotLoaded();
        }

        // UPDATE query on database
        $this->db->query('UPDATE ' . $this->db->tableName('p_democracy_votes') . ' SET ' . $this->db->fieldName('voting_id') . ' = ' . $this->db->quote($this->data['voting_id']) . ', ' . $this->db->fieldName('player_id') . ' = ' . $this->db->quote($this->data['player_id']) . ', ' . $this->db->fieldName('type') . ' = ' . $this->db->quote($this->data['type']) . ', ' . $this->db->fieldName('comment') . ' = ' . $this->db->quote($this->data['comment']) . ' WHERE ' . $this->db->fieldName('id') . ' = ' . $this->data['id']);
    }
	
    public function getId()
    {
        if( !isset($this->data['id']) )
        {
            throw new E_OTS_NotLoaded();
        }

        return $this->data['id'];
    }

    public function getVotingId()
    {
        if( !isset($this->data['id']) )
        {
            throw new E_OTS_NotLoaded();
        }

        return $this->data['voting_id'];
    }

    public function setVotingId($voting_id)
    {
        $this->data['voting_id'] = (int) $voting_id;
    }
	
    public function getPlayer()
    {
        if( !isset($this->data['player_id']) )
        {
            throw new E_OTS_NotLoaded();
        }
		$player = new OTS_Player();
		$player->load($this->data['player_id']);
        return $player;
    }

    public function getPlayerId()
    {
        if( !isset($this->data['id']) )
        {
            throw new E_OTS_NotLoaded();
        }

        return $this->data['player_id'];
    }

    public function setPlayerId($player_id)
    {
        $this->data['player_id'] = (int) $player_id;
    }

    public function getType()
    {
        if( !isset($this->data['id']) )
        {
            throw new E_OTS_NotLoaded();
        }

        return $this->data['type'];
    }

    public function setType($type)
    {
        $this->data['type'] = (int) $type;
    }

    public function getComment()
    {
        if( !isset($this->data['id']) )
        {
            throw new E_OTS_NotLoaded();
        }

        return $this->data['comment'];
    }

    public function setComment($comment)
    {
        $this->data['comment'] = (string) $comment;
    }
}
?>
