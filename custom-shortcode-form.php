<?php
/**
* Plugin Name: Simpel mathematical captcha protected form
* Description: mathematical captcha protected form with shortcode support
* Version: 1.0
* Author: snntx
**/

/*
* Creating the function for shortcode 
*/
function snntx_form_shotcode(){
    //Generate random 2 numbers with wp_rand function
    $secure_num_1 = wp_rand( 1, 11 );
    $secure_num_2 = wp_rand( 1, 11 );
    
    $secure_ans = ($secure_num_1 + $secure_num_2); //Answer to compare in server side
    
    $regRedirect = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; //Get the whole URL for form action. Not necessary unless working with URL parameters. This form catches $_POST from the same page (Action URL) 
    
    //HTML FORM
    $return_this = "
    <form enctype='multipart/form-data' action='$regRedirect' method='POST'>
    <label>Name: </label><input required type='text' name='custom_user_name' placeholder='Will Smith'>
    
    <p>Solve the question below to continue - I'm not a robot!</p> // Just a text to let user know
    <label for='securityans'> $secure_num_1 +  $secure_num_2 = </label> // Shows variables needs to be solved in a label
    <input required type='number' name='user_sec_ans'> //Text box for POST answer
    </div>

    // We have to POST the answer to the server before validate
    <input type='hidden' name='dbay-listing' value='$claimingID'>
    <input type='hidden' name='sec_ans' value='$secure_ans'>
    
    <input type='submit' value='submit and validate'> // Submit button
    
    </form>
    ";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
        //Before get other variables, Get captcha values first
        $secure_user_ans = $_POST['user_sec_ans'];
        $secure_ans = $_POST['sec_ans'];

        if($secure_user_ans==$secure_ans){ //Captcha Check
         echo $_POST['custom_user_name'];
         //Do something if captcha is passed
        }else{
         //Dispaly an error message
         echo "Sorry the captcha validation failed";
        }
    }
    return $return_this;  //Returns and dispaly the form and results
}

add_shortcode('captcha-form', 'snntx_form_shotcode'); //Creates the shortcode for use.
