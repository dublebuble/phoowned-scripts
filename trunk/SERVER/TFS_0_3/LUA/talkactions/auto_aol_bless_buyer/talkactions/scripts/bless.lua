--#################################################
--### Scripted by PhoOwned                      ###
--### Contact: phoowned@wp.pl                   ###
--###                                           ###
--### Auto AOL and / or Bless buyer after death ###
--### version: 1.0                              ###
--#################################################

local autoBlessStorage = 57927

function onSay(cid, words, param)
	if(param == '1' or param == 'on') then
		doCreatureSetStorage(cid, autoBlessStorage, 1)
		doPlayerSendTextMessage(cid,MESSAGE_EVENT_ADVANCE,'Auto-buy bless after death - ON!')
	elseif(param == '0' or param == 'off') then
		doCreatureSetStorage(cid, autoBlessStorage)
		doPlayerSendTextMessage(cid,MESSAGE_EVENT_ADVANCE,'Auto-buy bless after death - OFF!')
	elseif(param == '') then
		if(getPlayerBlessing(cid,1)) then
			doPlayerSendCancel(cid,'You are blessed!')
		elseif(doPlayerRemoveMoney(cid,50000)) then
			for b=1,5 do
				doPlayerAddBlessing(cid,b)
			end
			doCreatureSay(cid,'BLESS',TALKTYPE_ORANGE_1)
			doSendMagicEffect(getThingPosition(cid),CONST_ME_HOLYDAMAGE)
			doPlayerSendTextMessage(cid,MESSAGE_EVENT_ADVANCE,'You have been blessed by the gods!')
		else
			doSendMagicEffect(getThingPosition(cid),CONST_ME_POFF)
			doPlayerSendTextMessage(cid,MESSAGE_EVENT_ADVANCE,"You need 5 crystal coin to get blessed!")
		end
	else
		doPlayerSendTextMessage(cid,MESSAGE_EVENT_ADVANCE,'Wrong param')
	end    
	return 1
end
