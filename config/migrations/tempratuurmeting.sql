DELIMITER //

CREATE PROCEDURE AddTempMeting(ColdRoomSensorNumber bigint(20), Temperature decimal(10,2))
BEGIN
	INSERT INTO `nerdycopy`.`coldroomtemperatures`
	(`ColdRoomSensorNumber`,`RecordedWhen`,`Temperature`,`ValidFrom`,`ValidTo`)
	VALUES
		(ColdRoomSensorNumber,now(),Temperature,now(),now());
END //

DELIMITER ;


CREATE TABLE IF NOT EXISTS tempguid(
    current_guid VARCHAR(255) NOT NULL
);