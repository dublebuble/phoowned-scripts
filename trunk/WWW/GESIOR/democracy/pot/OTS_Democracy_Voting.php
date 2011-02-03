<?php
class OTS_Democracy_Voting extends OTS_Row_DAO
{
    private $data = array('state' => 0, 'finish_time' => 0, 'author_id' => 0,'author_accountid' => 0,'topic' => 0,'text' => 0,'premdays' => 0, 'created' => 0);

    public function create()
    {
        // saves blank voting info
        $this->db->query('INSERT INTO ' . $this->db->tableName('p_democracy') . ' (' . $this->db->fieldName('state') . ', ' . $this->db->fieldName('finish_time') . ', ' . $this->db->fieldName('author_id') . ', ' . $this->db->fieldName('author_accountid') . ', ' . $this->db->fieldName('topic') . ', ' . $this->db->fieldName('text') . ') VALUES (0, 0, 0, 0, \'\', \'\')');

        // reads created voting's ID
        $this->data['id'] = $this->db->lastInsertId();

        // return name of newly created 
        return $id;
    }

    public function load($id)
    {
        // SELECT query on database
        $this->data = $this->db->query('SELECT ' . $this->db->fieldName('id') . ', ' . $this->db->fieldName('state') . ', ' . $this->db->fieldName('finish_time') . ', ' . $this->db->fieldName('author_id') . ', ' . $this->db->fieldName('author_accountid') . ', ' . $this->db->fieldName('topic') . ', ' . $this->db->fieldName('text') . ' FROM ' . $this->db->tableName('p_democracy') . ' WHERE ' . $this->db->fieldName('id') . ' = ' . (int) $id)->fetch();
    }

    public function find($id)
    {
        // SELECT query on database
        $this->data = $this->db->query('SELECT ' . $this->db->fieldName('id') . ', ' . $this->db->fieldName('state') . ', ' . $this->db->fieldName('finish_time') . ', ' . $this->db->fieldName('author_id') . ', ' . $this->db->fieldName('author_accountid') . ', ' . $this->db->fieldName('topic') . ', ' . $this->db->fieldName('text') . ' FROM ' . $this->db->tableName('p_democracy') . ' WHERE ' . $this->db->fieldName('id') . ' = ' . (int) $id)->fetch();
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
        $this->db->query('UPDATE ' . $this->db->tableName('p_democracy') . ' SET ' . $this->db->fieldName('state') . ' = ' . $this->db->quote($this->data['state']) . ', ' . $this->db->fieldName('finish_time') . ' = ' . $this->db->quote($this->data['finish_time']) . ', ' . $this->db->fieldName('author_id') . ' = ' . $this->db->quote($this->data['author_id']) . ', ' . $this->db->fieldName('author_accountid') . ' = ' . $this->db->quote($this->data['author_accountid']) . ', ' . $this->db->fieldName('topic') . ' = ' . $this->db->quote($this->data['topic']) . ', ' . $this->db->fieldName('text') . ' = ' . $this->db->quote($this->data['text']) . ', WHERE ' . $this->db->fieldName('id') . ' = ' . $this->data['id']);
    }
	
    public function getVotes($type = null)
    {
        if( !isset($this->data['id']) )
        {
            throw new E_OTS_NotLoaded();
        }

        // creates filters
        $filter = new OTS_SQLFilter();
        $filter->compareField('voting_id', (int) $this->data['id']);
		if($type)
			$filter->compareField('type', (int) $type);

		$list = new OTS_Democracy_Votes_List();
        $list->setFilter($filter);

        return $list;
    }

    public function hasVoted($player_id)
    {
        if( !isset($this->data['id']) )
        {
            throw new E_OTS_NotLoaded();
        }

        // creates filters
        $filter = new OTS_SQLFilter();
        $filter->compareField('voting_id', (int) $this->data['id']);
		$filter->compareField('player_id', (int) $player_id);

		$list = new OTS_Democracy_Votes_List();
        $list->setFilter($filter);

        return $list->count() > 0;
    }
	
    public function getId()
    {
        if( !isset($this->data['id']) )
        {
            throw new E_OTS_NotLoaded();
        }

        return $this->data['id'];
    }

    public function getState()
    {
        if( !isset($this->data['state']) )
        {
            throw new E_OTS_NotLoaded();
        }

        return $this->data['state'];
    }

    public function setState($state)
    {
        $this->data['state'] = (int) $state;
    }

    public function getFinishTime()
    {
        if( !isset($this->data['finish_time']) )
        {
            throw new E_OTS_NotLoaded();
        }

        return $this->data['finish_time'];
    }

    public function setFinishTime($finish_time)
    {
        $this->data['finish_time'] = (int) $finish_time;
    }

    public function getAuthor()
    {
        if( !isset($this->data['author_id']) )
        {
            throw new E_OTS_NotLoaded();
        }
		$author = new OTS_Player();
		$author->load($this->data['author_id']);
        return $author;
    }

    public function getAuthorId()
    {
        if( !isset($this->data['author_id']) )
        {
            throw new E_OTS_NotLoaded();
        }

        return $this->data['author_id'];
    }

    public function setAuthorId($author_id)
    {
        $this->data['author_id'] = (int) $author_id;
    }

    public function getAuthorAccount()
    {
        if( !isset($this->data['author_accountid']) )
        {
            throw new E_OTS_NotLoaded();
        }
		$author_account = new OTS_Account();
		$author_account->load($this->data['author_accountid']);
        return $author_account;
    }

    public function getAuthorAccountId()
    {
        if( !isset($this->data['author_accountid']) )
        {
            throw new E_OTS_NotLoaded();
        }

        return $this->data['author_accountid'];
    }

    public function setAuthorAccountId($author_accountid)
    {
        $this->data['author_accountid'] = (int) $author_accountid;
    }
	
    public function getTopic()
    {
        if( !isset($this->data['topic']) )
        {
            throw new E_OTS_NotLoaded();
        }

        return $this->data['topic'];
    }

    public function setTopic($topic)
    {
        $this->data['topic'] = (string) $topic;
    }
	
    public function getText()
    {
        if( !isset($this->data['text']) )
        {
            throw new E_OTS_NotLoaded();
        }

        return $this->data['text'];
    }

    public function setText($text)
    {
        $this->data['text'] = (string) $text;
    }
}
?>
