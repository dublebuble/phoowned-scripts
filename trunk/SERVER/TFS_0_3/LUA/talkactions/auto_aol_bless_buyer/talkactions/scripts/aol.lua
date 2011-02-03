--#################################################
--### Scripted by PhoOwned                      ###
--### Contact: phoowned@wp.pl                   ###
--###                                           ###
--### Auto AOL and / or Bless buyer after death ###
--### version: 1.0                              ###
--#################################################

local autoAOLStorage = 57928

function onSay(cid, words, param)
	if(param == '1' or param == 'on') then
		doCreatureSetStorage(cid, autoAOLStorage, 1)
		doPlayerSendTextMessage(cid,MESSAGE_EVENT_ADVANCE,'Auto-buy AOL after death - ON!')
	elseif(param == '0' or param == 'off') then
		doCreatureSetStorage(cid, autoAOLStorage)
		doPlayerSendTextMessage(cid,MESSAGE_EVENT_ADVANCE,'Auto-buy AOL after death - OFF!')
	elseif(param == '') then
		if(doPlayerRemoveMoney(cid,10000)) then
			doPlayerAddItem(cid,2173,1)
			doCreatureSay(cid,'AOL',TALKTYPE_ORANGE_1)
			doSendMagicEffect(getThingPosition(cid),CONST_ME_BATS)
			doPlayerSendTextMessage(cid,MESSAGE_EVENT_ADVANCE,'You have bought Amulet of Loss!')
		else
			doSendMagicEffect(getThingPosition(cid),CONST_ME_POFF)
			doPlayerSendTextMessage(cid,MESSAGE_EVENT_ADVANCE,"You need 1 crystal coin to get AOL!")
		end
	else
		doPlayerSendTextMessage(cid,MESSAGE_EVENT_ADVANCE,'Wrong param')
	end    
	return 1
end
