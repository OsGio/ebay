<?php
/********************************************
addItem.php

Uses eBay Trading API to list an item under 
a seller's account.

********************************************/

	// include our Trading API constants
		
	DEFINE("SITEID",0);
	DEFINE("API_COMPATIBILITY_LEVEL",779);
	
	$is_test = false;
		
	//sandbox
	if($is_test) {
		DEFINE("API_URL",'https://api.sandbox.ebay.com/ws/api.dll');
		DEFINE("API_DEV_NAME",'fdec0311-09ab-4c7f-af74-b393c461d9b2');//sand
		DEFINE("API_APP_NAME",'yuukimin-76ae-4112-b3ae-e74fe2ebecbb');
		DEFINE("API_CERT_NAME",'e648827a-a927-40d0-9f92-9d96f48e3947');
		//DEFINE("AUTH_TOKEN",'AgAAAA**AQAAAA**aAAAAA**UVl4Uw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4GhCpWEoA2dj6x9nY+seQ**fT8CAA**AAMAAA**gN/RwGGKYN90YYN1v7eZs3I9DZr3ex1SMQIpHK+pRyPBVeKb/799k2iVgZ08SLJknBIN2Xb0fy8Wjl5hysGfqO1Vi997yqR43fawEk4+/n1fU/ggRY9NJ3Cn+urgLUep8PxT1K6b8f5RXPA1HomSWp6bdr5eVyTBkCPQugEbSA/dBCbv2gG5DInp3JsGo79FPkb1C+rmK1nIqUqJk1vScmCUcAMcotGr7nBHXZ3LSAphpKYs0kq/BImtYIKP6ibO0v8+GeUzDv7J5X54gJHQ8WBQ6CgHAn0nAj2iFWaOO2+BlMxEeW3yRK1UgE0WpO2MImERFNT7m8yYDTJ7+cTd0KiWEQVRsEiH5Rz7ktD2EFnpn8FQNOuCheSURIiDLiiDdmFH1hc6R9ZTmrPuVHvGdD3drHzISDBVdf9rBVGWfUdjBw5qdOWDz2iXEWCQZGwviTp0WrzwiKD64elg4BOysoFP5qtzstnU0Tp+qScVm8vys/qVL7N73lzuvpq7qWnrepIe5LS76Vr9fe34X0zf5JpkUI7Yiba4SeOnPo1FI+IjRz6+JHZvG4cHP+iDtZR4CRQ4T7c6Gm8g9PxQ11vwWdy4YcN0wbvfkGissP+EU2tH6pobza7W2hEoEtCTtCM4JONPHHeTQRBXoo977VBnuH9OPIMHHycdHzx9yXQLDacr6bhfLFA3zMsvhYQwigcGO/Wg3VQGfdY8IsoA3IBIfhezZm0VEOe5Fb4sFW1y1Zzvb3YfFLjBbsaPKtTxEUhw'); 
		DEFINE("EBAY_SERVER",'https://api.sandbox.ebay.com/ws/api.dll'); 
		DEFINE("LOGIN_URL",'https://signin.sandbox.ebay.com/ws/eBayISAPI.dll'); 
		DEFINE("RU_NAME",'yuuki_minohara-yuukimin-76ae-4-pjvpqgojo'); 
	}else{
		// PRODUCTION
		// Set the production URL for Trading API
		DEFINE("API_URL",'https://api.ebay.com/ws/api.dll');
		DEFINE("API_DEV_NAME",'9c9646be-b4f1-41d9-8f3a-934e4b2b26f1');
		DEFINE("API_APP_NAME",'Japancf54-19ac-403d-9c77-f92d8e6b7c2');
		DEFINE("API_CERT_NAME",'e563191a-80e3-40a7-a3b4-6852f8dd365c');
		//DEFINE("AUTH_TOKEN",'AgAAAA**AQAAAA**aAAAAA**aSDdUQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AEl4CpCJOKpASdj6x9nY+seQ**v+ABAA**AAMAAA**z2k0w6DWU3D8+i0L2JpzQOa+8H+Fw7d9X2DaM5EXdgtmyHCjNf1tTb16NJJIU2at2sK/EAEWmU/I6jzjSJ0rFkqu5/pUJNUWz/tUdBEimIRq7vGG1u8somPgQLor/umZxpg5vB3OhGI+Y5naCusTlz5AKriC5Z254uY/m/kY+GsHT6U6bDBQTXZniFXg8atHyQPEGzt3NaY//rwwZb0uJJ+xcKy2kQyNjUJzrw2Vw85ocGGwSvMCUDzg2ZM9JzdLjRFYdkwjQ59lOXWLwkUve8+4G5GeI8e/cw0Wxfbt3rZJhIfNLguSBwzZkS5DIX62PYKBmFiQ1CTwl23IAuDbCCBX3fAQAHjd82+PdlplmN+Wkc+RWMJWPlrsTl83El2jj40pDZpqfH6RIK1E898Lwz5UDf3fvV1Kp+bQKLz35iZnjz71L0DgxQ/mwAUwq3MxI6x5Q5S+N753MzqMEkus5akVaeFNwZp0exajKCSX0bG5gUGsnbDYxSDIDkrHGck6Me2NRu2ZtzTk09AYu8gbGWJOuHc+tc5c25ECib0+vC2jEZaxl3mnmDB1mZOdYOuSs5rGDzHNygdPbQRY7tJg8bGFRucmsM90tFPQTwpkC263ag3R2R60Rh+K1dAumVWdAnJa2CG9LacejFRO8E9OfFAuOGcJ/ivY9mDpqSm0BN4WSJlElQls+1TvMdnwWEd0suCYuVkFMcSZKMhqs/KtoaXPCiV1WgcoqSCtKnQ6Tdg8BrGEXQ/FVGztb6eyurzv'); 
		DEFINE("EBAY_SERVER",'https://api.ebay.com/ws/api.dll'); //�{��
		DEFINE("LOGIN_URL",'https://signin.ebay.com/ws/eBayISAPI.dll'); 
		DEFINE("RU_NAME",'Japan-Japancf54-19ac--wjxbom'); 
	}
	?>
