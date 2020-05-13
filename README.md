# ADutrey--Evaluation-Intermediaire-BackEnd-WF3--SQL-PHP
4hours
-> Create a DB "immobilier" with a table "logement", including: id - titre   - adresse  - ville   - cp   - surface   - prix   - photo - type (location ou vente)   - description.
-> Create a form to add an ad: all fields are compulsory, except photo & description, cp should be 5 digits max., the size and type of the photo should be checked. The type field should be select options or radio buttons. Save datas into the DB.
-> Create a page displaying all ads in a table
-> Uploaded files should be renamed such as é « logement_timestamp.jpg »
-> Create a page displaying a selected ad 


VARIABLES INDEX
----------------------
PHP VARIABLES
--------------
$ad                         ---> ad inside the loop
$address                    ---> ad's address
$ads                        ---> ads
$description                ---> ad's description
$entireName                 ---> entire picture's name generated with abolute path and extension
$extension                  ---> file's extension
$field                      ---> Inside checkForm: form's fields inside the loop
$fields                     ---> Inside checkForm: form's fields
$name                       ---> picture's random name
$picture                    ---> ad's picture
$pictype                    ---> pictures' type
$postalcode                 ---> ad's postalcode
$price                      ---> ad's accomadtion price
$response                   ---> Inside checkForm: boolean in case of filled in fields
$sqrmeter                   ---> square meter of the ad's accomodation
$superglobale               ---> Inside checkForm: encompass $_GET & $_POST
$title                      ---> ad's title
$town                       ---> town from the ad's address
$type                       ---> ad's type -> sale or rent

SUPERGLOBALES
--------------
$_FILES                     ---> complete datas from the current script
$_GET                       ---> data extracted from the DB passing through URL
$_POST                      ---> data extracted from the form
$_SERVER                    ---> data defined by the server, on user's actions (e.g. last page consulted)

MAGIC CONSTANTS
----------------
__DIR__
__FILE__

PREDEFINED CONSTANTS
---------------------
PDO::PARAM_INT
PDO::PARAM_STR 
PDO::FETCH_ASSOC

SQL VARIABLES
--------------
:address
:description
:picture
:postalcode
:price
:sqrmeter
:title
:town
:type 