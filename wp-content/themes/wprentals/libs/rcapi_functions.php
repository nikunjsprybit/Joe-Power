<?php

function rcapi_retrive_token(){
    $token_expiration = floatval( esc_html ( get_option('wp_estate_token_expire','') ) );
    $time= time();
    
    print 'check ';
    echo $check= $token_expiration - $time + 3600;
    print '</br>';
    
    
    if ( $check <= 0 || $token_expiration==0){
        print'regenerate 1';
        $token = rentals_club_get_token();
        update_option('wp_estate_token_expire',time());
        update_option('wp_estate_curent_token',$token);
    }else{
        print 'from db</br>';
        $token = esc_html ( get_option('wp_estate_curent_token','') );
    }
    
    if($token==''){
        print'regenerate 2';
        $token = rentals_club_get_token();
        update_option('wp_estate_token_expire',time());
        update_option('wp_estate_curent_token',$token);
    }
    print 'we use '.$token.'</br>';
    
    return $token;
    
}

function rentals_club_get_token(){
    
    $client_id      = esc_html ( get_option('wp_estate_rcapi_api_key','') );
    $client_secret  = esc_html ( get_option('wp_estate_rcapi_api_secret_key','') );
    $username       = esc_html ( get_option('wp_estate_rcapi_api_username','') );
    $password       = esc_html ( get_option('wp_estate_rcapi_api_password','') );


    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => CLUBLINKSSL."://www.".CLUBLINK."/?oauth=token",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "grant_type=password&username=".$username."&password=".$password,
    CURLOPT_HTTPHEADER => array(
        "authorization: Basic ". base64_encode( $client_id . ':' . $client_secret ),
        "cache-control: no-cache",
        "content-type: application/x-www-form-urlencoded",
        "postman-token: 3d65984a-9f80-a881-5fe9-59717126687e"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
   /*
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      echo $response;
    } */
    $response= json_decode($response);
    return $response->access_token;
    //print_r($response);
}
        

function rentals_api_managment(){
    
    $rcapi_api_key= esc_html ( get_option('wp_estate_rcapi_api_key','') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Rentals Club API Key','wpestate').'</div>
        <div class="option_row_explain">'.__('Rentals Club API Key','wpestate').'</div>    
            <input cols="57" rows="2" name="rcapi_api_key" id="rcapi_api_key" value="'.$rcapi_api_key.'"></input>
    </div>';

    $rcapi_api_secret_key = esc_html ( get_option('wp_estate_rcapi_api_secret_key','') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Rentals Club API Secret Key','wpestate').'</div>
        <div class="option_row_explain">'.__('Rentals Club  API Secret Key','wpestate').'</div>    
            <input cols="57" rows="2" name="rcapi_api_secret_key" id="rcapi_api_secret_key" value="'.$rcapi_api_secret_key.'"></input>
    </div>';
    
    
    $rcapi_api_username = esc_html ( get_option('wp_estate_rcapi_api_username','') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Rentals Club Username','wpestate').'</div>
        <div class="option_row_explain">'.__('Rentals Club Username','wpestate').'</div>    
            <input cols="57" rows="2" name="rcapi_api_username" id="rcapi_api_secret_key" value="'.$rcapi_api_username.'"></input>
    </div>';
    
    $rcapi_api_password = esc_html ( get_option('wp_estate_rcapi_api_password','') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Rentals Club Password','wpestate').'</div>
        <div class="option_row_explain">'.__('Rentals Club password','wpestate').'</div>    
             <input cols="57" rows="2" name="rcapi_api_password" id="rcapi_api_password" value="'.$rcapi_api_password.'"></input>
    </div>';
    
    
    
    print ' <div class="estate_option_row_submit">
    <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wpestate').'" />
    </div>';

    
}