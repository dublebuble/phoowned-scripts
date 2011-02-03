--#################################################
--### Scripted by PhoOwned                      ###
--### Contact: phoowned@wp.pl                   ###
--###                                           ###
--### Auto AOL and / or Bless buyer after death ###
--### version: 1.0                              ###
--#################################################

local autoBlessStorage = 57927
local autoAOLStorage = 57928

function onLogin(cid)
	local templePosition = getTownTemplePosition(getPlayerTown(cid))
	local playerPosition = getThingPosition(cid)
	local fyi = {}
	local msg = {}
	if(getDistanceBetween(templePosition, playerPosition) <= 2) then
		if(getCreatureStorage(cid, autoAOLStorage) == 1 and getPlayerSlotItem(cid, CONST_SLOT_NECKLACE).itemid == 0) then
			if(doPlayerRemoveMoney(cid,10000)) then
				doPlayerAddItem(cid,2173,1)
				doCreatureSay(cid,'AOL',TALKTYPE_ORANGE_1)
				doSendMagicEffect(getThingPosition(cid),CONST_ME_BATS)
				table.insert(msg, 'You have bought Amulet of Loss!')
			else
				table.insert(fyi, 'You got no money for Amulet of Loss! It cost 1 crystal coin!')
			end
		end
		if(getCreatureStorage(cid, autoBlessStorage) == 1 and not getPlayerBlessing(cid,1)) then
			if(doPlayerRemoveMoney(cid,50000)) then
				for b=1,5 do
					doPlayerAddBlessing(cid,b)
				end
				doCreatureSay(cid,'BLESS',TALKTYPE_ORANGE_1)
				doSendMagicEffect(getThingPosition(cid),CONST_ME_HOLYDAMAGE)
				table.insert(msg, 'You have been blessed by the gods!')
			else
				table.insert(fyi, 'You got no money for Bless! It cost 5 crystal coin!')
			end
		end
	end
	if(#fyi > 0) then
		doPlayerPopupFYI(cid, table.concat(fyi, '\n'))
	end
	if(#msg > 0) then
		doPlayerSendTextMessage(cid, MESSAGE_STATUS_CONSOLE_BLUE, table.concat(msg, '\n'))
	end
	if(#msg > 0 or #fyi > 0) then
		doPlayerSendTextMessage(cid, MESSAGE_STATUS_CONSOLE_BLUE, 'You can turn off auto buyer by commands:\n!aol off\n!bless off')
	end
	return true
end