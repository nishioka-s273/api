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

### request value
- returnOrigin : the origin name of source IdP. (the IdP should register this name for the SP in advance.)

### return value
- result (String) : 'OK' or 'NG' indicating the request has completed successfully or not.
- attributes (Array of String) : the request values for authorization.
- key (Associative Array of int) : the public key that will be used in magic protocol.
- session_id : the session ID binded for each user's  authentication and authorization session.

## cal_wij.php
- accessed by an IdP (from function/get_zi.php)
- return the value of w_{i}{j}, used to calculate in the IdP.

### request value
- returnOrigin : the origin name of source IdP.
- z (Array) : the calculated value of attribute value in the IdP.
- session_id : the session ID.

### return value
- result (String) : 'OK' or 'NG' indicating the request has completed successfully or not.
- hash_function (String) : the hash function used in magic protocol.
- algo (String) : the algorithm used in the hash function.
- key (String) : the shared secret key used in the hash function.
- w_ij (Array of int) : the calculated value in this protocol.

