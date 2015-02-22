<?php
/********************************************
tradingConstants.php

Constants used for Trading API calls.
Replace keys and tokens with your information.

********************************************/

// eBay site to use - 0 = United States
DEFINE("SITEID",0);

// production vs. sandbox flag - true=production
DEFINE("FLAG_PRODUCTION",true);

// eBay Trading API version to use
DEFINE("API_COMPATIBILITY_LEVEL",779);
    
/* Set the Dev, App and Cert IDs
Create these on developer.ebay.com
check if need to use production or sandbox keys */
if (FLAG_PRODUCTION) {

	// PRODUCTION
	// Set the production URL for Trading API
	DEFINE("API_URL",'https://api.ebay.com/ws/api.dll');

	// Set production credentials (from developer.ebay.com)
	DEFINE("API_DEV_NAME",'fdec0311-09ab-4c7f-af74-b393c461d9b2');
	DEFINE("API_APP_NAME",'yuukimin-354e-4441-b41b-6b4656975539');
	DEFINE("API_CERT_NAME",'4b7097f1-8be7-444b-8d9f-28b90f3f8ed9');

	// Set the auth token for the user profile used
	DEFINE("AUTH_TOKEN",'AgAAAA**AQAAAA**aAAAAA**j1HEUQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4GhCpWEoA2dj6x9nY+seQ**fT8CAA**AAMAAA**gN/RwGGKYN90YYN1v7eZs3I9DZr3ex1SMQIpHK+pRyPBVeKb/799k2iVgZ08SLJknBIN2Xb0fy8Wjl5hysGfqO1Vi997yqR43fawEk4+/n1fU/ggRY9NJ3Cn+urgLUep8PxT1K6b8f5RXPA1HomSWp6bdr5eVyTBkCPQugEbSA/dBCbv2gG5DInp3JsGo79FPkb1C+rmK1nIqUqJk1vScmCUcAMcotGr7nBHXZ3LSAphpKYs0kq/BImtYIKP6ibO0v8+GeUzDv7J5X54gJHQ8WBQ6CgHAn0nAj2iFWaOO2+BlMxEeW3yRK1UgE0WpO2MImERFNT7m8yYDTJ7+cTd0KiWEQVRsEiH5Rz7ktD2EFnpn8FQNOuCheSURIiDLiiDdmFH1hc6R9ZTmrPuVHvGdD3drHzISDBVdf9rBVGWfUdjBw5qdOWDz2iXEWCQZGwviTp0WrzwiKD64elg4BOysoFP5qtzstnU0Tp+qScVm8vys/qVL7N73lzuvpq7qWnrepIe5LS76Vr9fe34X0zf5JpkUI7Yiba4SeOnPo1FI+IjRz6+JHZvG4cHP+iDtZR4CRQ4T7c6Gm8g9PxQ11vwWdy4YcN0wbvfkGissP+EU2tH6pobza7W2hEoEtCTtCM4JONPHHeTQRBXoo977VBnuH9OPIMHHycdHzx9yXQLDacr6bhfLFA3zMsvhYQwigcGO/Wg3VQGfdY8IsoA3IBIfhezZm0VEOe5Fb4sFW1y1Zzvb3YfFLjBbsaPKtTxEUhw'); 

} else {  

	// SANDBOX
	// Set the sandbox URL for Trading API calls
	DEFINE("API_URL",'https://api.sandbox.ebay.com/ws/api.dll');

	// Set sandbox credentials (from developer.ebay.com)
	DEFINE("API_DEV_NAME",'WasabiApp');
	DEFINE("API_APP_NAME",'yuukimin-76ae-4112-b3ae-e74fe2ebecbb');
	DEFINE("API_CERT_NAME",'e648827a-a927-40d0-9f92-9d96f48e3947');

	// Set the auth token for the user profile used
	DEFINE("AUTH_TOKEN",'AgAAAA**AQAAAA**aAAAAA**j1HEUQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4GhCpWEoA2dj6x9nY+seQ**fT8CAA**AAMAAA**gN/RwGGKYN90YYN1v7eZs3I9DZr3ex1SMQIpHK+pRyPBVeKb/799k2iVgZ08SLJknBIN2Xb0fy8Wjl5hysGfqO1Vi997yqR43fawEk4+/n1fU/ggRY9NJ3Cn+urgLUep8PxT1K6b8f5RXPA1HomSWp6bdr5eVyTBkCPQugEbSA/dBCbv2gG5DInp3JsGo79FPkb1C+rmK1nIqUqJk1vScmCUcAMcotGr7nBHXZ3LSAphpKYs0kq/BImtYIKP6ibO0v8+GeUzDv7J5X54gJHQ8WBQ6CgHAn0nAj2iFWaOO2+BlMxEeW3yRK1UgE0WpO2MImERFNT7m8yYDTJ7+cTd0KiWEQVRsEiH5Rz7ktD2EFnpn8FQNOuCheSURIiDLiiDdmFH1hc6R9ZTmrPuVHvGdD3drHzISDBVdf9rBVGWfUdjBw5qdOWDz2iXEWCQZGwviTp0WrzwiKD64elg4BOysoFP5qtzstnU0Tp+qScVm8vys/qVL7N73lzuvpq7qWnrepIe5LS76Vr9fe34X0zf5JpkUI7Yiba4SeOnPo1FI+IjRz6+JHZvG4cHP+iDtZR4CRQ4T7c6Gm8g9PxQ11vwWdy4YcN0wbvfkGissP+EU2tH6pobza7W2hEoEtCTtCM4JONPHHeTQRBXoo977VBnuH9OPIMHHycdHzx9yXQLDacr6bhfLFA3zMsvhYQwigcGO/Wg3VQGfdY8IsoA3IBIfhezZm0VEOe5Fb4sFW1y1Zzvb3YfFLjBbsaPKtTxEUhw'); 
}
?>