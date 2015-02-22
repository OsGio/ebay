<?php
/********************************************
addItem.php

Uses eBay Trading API to list an item under 
a seller's account.

********************************************/

// include our Trading API constants
	// PRODUCTION
	// Set the production URL for Trading API
	DEFINE("API_URL",'https://api.ebay.com/ws/api.dll');
DEFINE("SITEID",0);
DEFINE("API_COMPATIBILITY_LEVEL",779);

	// Set production credentials (from developer.ebay.com)
	DEFINE("API_DEV_NAME",'fdec0311-09ab-4c7f-af74-b393c461d9b2');
	DEFINE("API_APP_NAME",'yuukimin-354e-4441-b41b-6b4656975539');
	DEFINE("API_CERT_NAME",'4b7097f1-8be7-444b-8d9f-28b90f3f8ed9');

	// Set the auth token for the user profile used
	DEFINE("AUTH_TOKEN",'AgAAAA**AQAAAA**aAAAAA**aSDdUQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AEl4CpCJOKpASdj6x9nY+seQ**v+ABAA**AAMAAA**z2k0w6DWU3D8+i0L2JpzQOa+8H+Fw7d9X2DaM5EXdgtmyHCjNf1tTb16NJJIU2at2sK/EAEWmU/I6jzjSJ0rFkqu5/pUJNUWz/tUdBEimIRq7vGG1u8somPgQLor/umZxpg5vB3OhGI+Y5naCusTlz5AKriC5Z254uY/m/kY+GsHT6U6bDBQTXZniFXg8atHyQPEGzt3NaY//rwwZb0uJJ+xcKy2kQyNjUJzrw2Vw85ocGGwSvMCUDzg2ZM9JzdLjRFYdkwjQ59lOXWLwkUve8+4G5GeI8e/cw0Wxfbt3rZJhIfNLguSBwzZkS5DIX62PYKBmFiQ1CTwl23IAuDbCCBX3fAQAHjd82+PdlplmN+Wkc+RWMJWPlrsTl83El2jj40pDZpqfH6RIK1E898Lwz5UDf3fvV1Kp+bQKLz35iZnjz71L0DgxQ/mwAUwq3MxI6x5Q5S+N753MzqMEkus5akVaeFNwZp0exajKCSX0bG5gUGsnbDYxSDIDkrHGck6Me2NRu2ZtzTk09AYu8gbGWJOuHc+tc5c25ECib0+vC2jEZaxl3mnmDB1mZOdYOuSs5rGDzHNygdPbQRY7tJg8bGFRucmsM90tFPQTwpkC263ag3R2R60Rh+K1dAumVWdAnJa2CG9LacejFRO8E9OfFAuOGcJ/ivY9mDpqSm0BN4WSJlElQls+1TvMdnwWEd0suCYuVkFMcSZKMhqs/KtoaXPCiV1WgcoqSCtKnQ6Tdg8BrGEXQ/FVGztb6eyurzv'); 


	?>
