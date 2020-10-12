# SP AuthN + AuthZ API

## returnJson.php
- used to return JSON Response
- input $resultArray; the array of values to response
- input $origin; where the api is accessed from (only idp1.local or idp2.local is allowed to access)
- output JSON Response
- servers access to SP's API should send the origin of them as $_REQUEST['returnOrigin'] (desirable to use some key or challenge binded to the IdP, in advance)

## attribute.php
- accessed by an IdP (from function/get_attribute.php)
- return the attributes and public key used in this protocol